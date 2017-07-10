<?php
class ControllerBlogCategory extends Controller {
	public function index() {
		$this->load->language('blog/category');

		$this->load->model('blog/category');

		$this->load->model('blog/post');

		$this->load->model('tool/image');

		if (isset($this->request->get['filter'])) {
			$filter = $this->request->get['filter'];
		} else {
			$filter = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}


		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		
		if (isset($this->request->get['blog_category_id'])) {
			$blog_category_id =  $this->request->get['blog_category_id'];
		}else{
			$blog_category_id = 0;
		}
			
		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added =  $this->request->get['filter_date_added'];
		}else{
			$filter_date_added = 0;
		}
						
		if (isset($this->request->get['filter_title'])) {
			$filter_title =  $this->request->get['filter_title'];
		}else{
			$filter_title = 0;
		}
					

		$category_info = $this->model_blog_category->getCategory($blog_category_id);

		if ($category_info) {
			$this->document->setTitle($category_info['meta_title']);
			$this->document->setDescription($category_info['meta_description']);
			$this->document->setKeywords($category_info['meta_keyword']);
			$this->document->addLink($this->url->link('blog/category', 'blog_category_id=' . $blog_category_id), 'canonical');

			$data['heading_title'] = $category_info['name'];

			$data['breadcrumbs'][] = array(
				'text' => $category_info['name'],
				'href' => $this->url->link('blog/category', 'blog_category_id=' . $blog_category_id)
			);


			$data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');			

		}else{
			$this->document->setTitle($this->language->get('heading_title'));
			$data['heading_title'] = $this->language->get('heading_title');

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('blog/category')
			);

			$data['description'] = '';			

		}

		$data['text_refine'] = $this->language->get('text_refine');
		$data['text_empty'] = $this->language->get('text_empty');


		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_list'] = $this->language->get('button_list');
		$data['button_grid'] = $this->language->get('button_grid');

		// Set the last category breadcrumb


		$data['compare'] = $this->url->link('post/compare');

		$url = '';

		if (isset($this->request->get['filter'])) {
			$url .= '&filter=' . $this->request->get['filter'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}


		$data['blog_posts'] = array();

		$filter_data = array(
			'filter_blog_category_id' => $blog_category_id,
			'filter_date_added'  => $filter_date_added,
			'filter_title' 		 => $filter_title,
			'filter_filter'      => $filter,
			'sort'               => array('date_added'),
			'order'              => 'DESC',
			'start'              => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'              => $this->config->get('config_limit_admin')
		);

		$post_total = $this->model_blog_post->getTotalPosts($filter_data);

		$results = $this->model_blog_post->getPosts($filter_data);

		foreach ($results as $result) {				

			$data['blog_posts'][] = array(
				'blog_post_id'  => $result['blog_post_id'],
				'title'        	=> $result['title'],
				'image'        => isset($result['image']) ? $result['image'] : "",
				'description' 	=> utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 500) . '..',				
				'href'        	=> $this->url->link('blog/post', (isset($result['blog_category_id'])?'blog_category_id=' . $result['blog_category_id']:'') . '&blog_post_id=' . $result['blog_post_id'] . $url)
			);
		}

		$url = '';

		if (isset($this->request->get['filter'])) {
			$url .= '&filter=' . $this->request->get['filter'];
		}	

		$url = '';

		if (isset($this->request->get['filter'])) {
			$url .= '&filter=' . $this->request->get['filter'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}


		$url = '';

		if (isset($this->request->get['filter'])) {
			$url .= '&filter=' . $this->request->get['filter'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $post_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('blog/category', 'blog_category_id=' . $blog_category_id . $url . '&page={page}');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($post_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($post_total - $this->config->get('config_limit_admin'))) ? $post_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $post_total, ceil($post_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('blog/category', $data));
		
	}
}