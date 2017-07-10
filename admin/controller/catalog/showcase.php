<?php
class ControllerCatalogShowcase extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/showcase');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/showcase');

		$this->getList();
	}

	public function add() {
		$this->load->language('catalog/showcase');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/showcase');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->model_catalog_showcase->addShowcase($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/showcase', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/showcase');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/showcase');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->model_catalog_showcase->editShowcase($this->request->get['showcase_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/showcase', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/showcase');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/showcase');

		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $showcase_id) {
				$this->model_catalog_showcase->deleteShowcase($showcase_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/showcase', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'od.name';
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

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/showcase', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('catalog/showcase/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/showcase/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['showcases'] = array();

		$option_total = $this->model_catalog_showcase->getTotalShowcases();

		$results = $this->model_catalog_showcase->getShowcases();
		foreach ($results as $result) {
			$data['showcases'][] = array(
				'showcase_id'  => $result['showcase_id'],
				'title'       => $result['title'],
				'sort_order' => $result['sort_order'],
				'edit'       => $this->url->link('catalog/showcase/edit', 'token=' . $this->session->data['token'] . '&showcase_id=' . $result['showcase_id'] . $url, true)
			);
		}
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('catalog/showcase', 'token=' . $this->session->data['token'] . '&sort=od.name' . $url, true);
		$data['sort_sort_order'] = $this->url->link('catalog/showcase', 'token=' . $this->session->data['token'] . '&sort=o.sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $option_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/showcase', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($option_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($option_total - $this->config->get('config_limit_admin'))) ? $option_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $option_total, ceil($option_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/showcase_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['showcase_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_choose'] = $this->language->get('text_choose');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_radio'] = $this->language->get('text_radio');
		$data['text_checkbox'] = $this->language->get('text_checkbox');
		$data['text_input'] = $this->language->get('text_input');
		$data['text_text'] = $this->language->get('text_text');
		$data['text_textarea'] = $this->language->get('text_textarea');
		$data['text_file'] = $this->language->get('text_file');
		$data['text_date'] = $this->language->get('text_date');
		$data['text_datetime'] = $this->language->get('text_datetime');
		$data['text_time'] = $this->language->get('text_time');

		$data['entry_name'] = $this->language->get('entry_name');
                $data['entry_category'] = $this->language->get('entry_category');
		$data['entry_type'] = $this->language->get('entry_type');
		$data['entry_showcase_command'] = $this->language->get('entry_showcase_command');
		$data['entry_showcase_result'] = $this->language->get('entry_showcase_result');
		$data['entry_showcase_is_edit'] = $this->language->get('entry_showcase_is_edit');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_showcase_command_add'] = $this->language->get('button_showcase_command_add');
		$data['button_remove'] = $this->language->get('button_remove');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/showcase', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['showcase_id'])) {
			$data['action'] = $this->url->link('catalog/showcase/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/showcase/edit', 'token=' . $this->session->data['token'] . '&showcase_id=' . $this->request->get['showcase_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('catalog/showcase', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['showcase_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$showcase_info = $this->model_catalog_showcase->getShowcase($this->request->get['showcase_id']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['title'])) {
			$data['title'] = $this->request->post['title'];
		} elseif (!empty($showcase_info)) {
			$data['title'] = $showcase_info['title'];
		} else {
			$data['title'] = '';
		}
                
                if (isset($this->request->post['category_id'])) {
			$data['category_id'] = $this->request->post['category_id'];
		} elseif (!empty($showcase_info)) {
			$data['category_id'] = $showcase_info['category_id'];
		} else {
			$data['category_id'] = '';
		}
		
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($showcase_info)) {
			$data['sort_order'] = $showcase_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		if (isset($this->request->post['showcase_commands'])) {
			$showcase_commands = $this->request->post['showcase_commands'];
		} elseif (isset($this->request->get['showcase_id'])) {
			$showcase_commands = $this->model_catalog_showcase->getShowcaseCommands($this->request->get['showcase_id']);
		} else {
			$showcase_commands = array();
		}
		
		$data['showcase_commands'] = array();

		foreach ($showcase_commands as $showcase_command) {
			$data['showcase_commands'][] = array(
				'showcase_command_id'       => $showcase_command['showcase_command_id'],
				'command'					=> $showcase_command['command'],
				'result'				    => $showcase_command['result'],
				'is_edit'					=> $showcase_command['is_edit'],
				'sort_order'                => $showcase_command['sort_order']
			);
		}
                
                $this->load->model('catalog/category');
                $data['categories'] = $this->model_catalog_category->getCategories();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/showcase_form', $data));
	}
}