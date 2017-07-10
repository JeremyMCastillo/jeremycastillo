<?php
class ControllerBlogPost extends Controller {
	public function index() {
		$this->load->language('blog/post');

		$this->load->model('blog/post');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_blog'),
			'href' => $this->url->link('blog/category')
		);

		if (isset($this->request->get['blog_post_id'])) {
			$data['blog_post_id'] = $blog_post_id = (int)$this->request->get['blog_post_id'];
		} else {
			$data['blog_post_id'] = $blog_post_id = 0;
		}

		$post_info = $this->model_blog_post->getPost($blog_post_id);

		if ($post_info) {

			$this->document->setTitle($post_info['meta_title']);
			$this->document->setDescription($post_info['meta_description']);
			$this->document->setKeywords($post_info['meta_keyword']);

			$data['breadcrumbs'][] = array(
				'text' => $post_info['title'],
				'href' => $this->url->link('blog/post', 'blog_post_id=' .  $blog_post_id)
			);

			$data['heading_title'] = $post_info['title'];

			$data['button_continue'] = $this->language->get('button_continue');

			$data['description'] = html_entity_decode($post_info['description'], ENT_QUOTES, 'UTF-8');


			$data['text_write'] = $this->language->get('text_write');
			$data['text_login'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'));
			$data['text_note'] = $this->language->get('text_note');
			$data['text_loading'] = $this->language->get('text_loading');
			$data['help_email'] = $this->language->get('help_email');
			$data['text_posted_by'] = sprintf($this->language->get('text_posted_by'),ucwords($post_info['author']),date($this->language->get('date_format_long'), strtotime($post_info['date_added'])));
			$data['text_tags'] = $this->language->get('text_tags');
			
			$data['entry_name'] = $this->language->get('entry_name');
			$data['entry_email'] = $this->language->get('entry_email');
			$data['entry_comment'] = $this->language->get('entry_comment');


			$data['continue'] = $this->url->link('common/home');

			if ($this->config->get('config_google_captcha_status')) {
				$this->document->addScript('https://www.google.com/recaptcha/api.js');

				$data['site_key'] = $this->config->get('config_google_captcha_public');
			} else {
				$data['site_key'] = '';
			}

			$data['tags'] = array();

			if ($post_info['tag']) {
				$tags = explode(',', $post_info['tag']);

				foreach ($tags as $tag) {
					$data['tags'][] = array(
						'tag'  => trim($tag),
						'href' => $this->url->link('blog/category', 'filter_title=' . trim($tag))
					);
				}
			}

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('blog/post', $data));
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('blog/post', 'blog_post_id=' . $blog_post_id)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}
	}

	public function comment() {
		$this->load->language('blog/post');

		$this->load->model('blog/comment');

		$data['text_comment'] = $this->language->get('text_comment');
		$data['text_no_comments'] = $this->language->get('text_no_comments');//


		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['comments'] = array();

		$comment_total = $this->model_blog_comment->getTotalCommentsByPostId($this->request->get['blog_post_id']);

		$results = $this->model_blog_comment->getCommentsByPostId($this->request->get['blog_post_id'], ($page - 1) * 5, 5);

		foreach ($results as $result) {
			$data['comments'][] = array(
				'author'     => $result['author'],
				'text'       => nl2br($result['text']),				
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$pagination = new Pagination();
		$pagination->total = $comment_total;
		$pagination->page = $page;
		$pagination->limit = 5;
		$pagination->url = $this->url->link('blog/post/comment', 'blog_post_id=' . $this->request->get['blog_post_id'] . '&page={page}');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($comment_total) ? (($page - 1) * 5) + 1 : 0, ((($page - 1) * 5) > ($comment_total - 5)) ? $comment_total : ((($page - 1) * 5) + 5), $comment_total, ceil($comment_total / 5));

		$this->response->setOutput($this->load->view('blog/comment', $data));
	}

	public function write() {
		$this->load->language('blog/post');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 25)) {
				$json['error'] = $this->language->get('error_name');
			}

			if ((utf8_strlen($this->request->post['text']) < 25) || (utf8_strlen($this->request->post['text']) > 1000)) {
				$json['error'] = $this->language->get('error_text');
			}

			if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['email'])) {
				$json['error'] = $this->language->get('error_email');
			}

			if ($this->config->get('config_google_captcha_status')) {
				$recaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($this->config->get('config_google_captcha_secret')) . '&response=' . $this->request->post['g-recaptcha-response'] . '&remoteip=' . $this->request->server['REMOTE_ADDR']);

				$recaptcha = json_decode($recaptcha, true);

				if (!$recaptcha['success']) {
					$json['error'] = $this->language->get('error_captcha');
				}
			}

			if (!isset($json['error'])) {
				$this->load->model('blog/comment');

				$this->model_blog_comment->addComment($this->request->get['blog_post_id'], $this->request->post);

				$json['success'] = $this->language->get('text_success');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

}