<?php
class ControllerCommonHome extends Controller {
	public function index() {
		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));
                $this->document->addStyle('catalog/view/javascript/plugins/terminal.css');
		$this->document->addScript('catalog/view/javascript/plugins/terminal.js');
		$this->document->addScript('catalog/view/javascript/common/home.js');
		$this->load->model('catalog/showcase');

		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}
		
		if (isset($this->request->get['route'])) {
			$this->document->addLink($this->config->get('config_url'), 'canonical');
		}
		
		$data['showcases'] = $this->model_catalog_showcase->getShowcases();
                reset($data['showcases']);
                $data['selected_category'] = key($data['showcases']);

		$data['portfolio'] = $this->load->controller('product/portfolio');
		$data['contact'] = $this->load->controller('information/contact');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('common/home', $data));
	}
}
