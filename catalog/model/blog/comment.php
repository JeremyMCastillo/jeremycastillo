<?php
class ModelBlogComment extends Model {
	public function addComment($blog_post_id, $data) {
		/*print_r($data);
		exit;*/
		$this->event->trigger('pre.comment.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "blog_comment SET author = '" . $this->db->escape(ucwords($data['name'])) . "', email = '" . $this->db->escape($data['email']) . "', customer_id = '" . (int)$this->customer->getId() . "', blog_post_id = '" . (int)$blog_post_id . "', text = '" . $this->db->escape($data['text']) . "', date_added = NOW()");

		$blog_comment_id = $this->db->getLastId();//$comment_id

		if ($this->config->get('config_comment_mail')) {
			$this->load->language('mail/comment');
			$this->load->model('blog/post');
			$blog_post_info = $this->model_blog_post->getPost($blog_post_id);

			$subject = sprintf($this->language->get('text_subject'), $this->config->get('config_name'));

			$message  = $this->language->get('text_waiting') . "\n";
			$message .= sprintf($this->language->get('text_blog_post'), $this->db->escape(strip_tags($blog_post_info['title']))) . "\n";
			$message .= sprintf($this->language->get('text_commenter'), $this->db->escape(strip_tags($data['name']))) . "\n";
			
			$message .= $this->language->get('text_comment') . "\n";
			$message .= $this->db->escape(strip_tags($data['text'])) . "\n\n";

			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_host');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
			
			$mail->setTo($this->config->get('config_email'));
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender($this->config->get('config_name'));
			$mail->setSubject($subject);
			$mail->setText($message);
			$mail->send();

			// Send to additional alert emails
			$emails = explode(',', $this->config->get('config_mail_alert'));

			foreach ($emails as $email) {
				if ($email && preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $email)) {
					$mail->setTo($email);
					$mail->send();
				}
			}
		}

		$this->event->trigger('post.comment.add', $blog_comment_id);//$comment_id
	}

	public function getComments($data = array()) {

		$sql = "SELECT r.blog_comment_id, r.author, r.email, r.text, p.blog_post_id, pd.title, r.date_added FROM " . DB_PREFIX . "blog_comment r LEFT JOIN " . DB_PREFIX . "blog_post p ON (r.blog_post_id = p.blog_post_id) LEFT JOIN " . DB_PREFIX . "blog_post_description pd ON (p.blog_post_id = pd.blog_post_id) WHERE  p.status = '1' AND r.status = '1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_blog_post_id'])) {
			$sql .= " AND p.blog_post_id = '" . (int)$blog_post_id . "'";
		}

		$sort_data = array(
			'r.author',
			'r.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY r.date_added";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getCommentsByPostId($blog_post_id, $start = 0, $limit = 20) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 20;
		}

		$query = $this->db->query("SELECT r.blog_comment_id, r.author, r.email, r.text, p.blog_post_id, pd.title, r.date_added FROM " . DB_PREFIX . "blog_comment r LEFT JOIN " . DB_PREFIX . "blog_post p ON (r.blog_post_id = p.blog_post_id) LEFT JOIN " . DB_PREFIX . "blog_post_description pd ON (p.blog_post_id = pd.blog_post_id) WHERE p.blog_post_id = '" . (int)$blog_post_id . "' AND p.status = '1' AND r.status = '1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY r.date_added DESC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getTotalCommentsByPostId($blog_post_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_comment r LEFT JOIN " . DB_PREFIX . "blog_post p ON (r.blog_post_id = p.blog_post_id) LEFT JOIN " . DB_PREFIX . "blog_post_description pd ON (p.blog_post_id = pd.blog_post_id) WHERE p.blog_post_id = '" . (int)$blog_post_id . "' AND p.status = '1' AND r.status = '1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row['total'];
	}
}