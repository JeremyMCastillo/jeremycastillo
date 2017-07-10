<?php
class ControllerInformationAbout extends Controller {
	public function index() {
		$this->load->language('information/about');

                $this->document->setTitle($this->language->get('heading_title'));
                
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/sitemap')
		);

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

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_quote'] = $this->language->get('text_quote');
                $data['text_titles'] = $this->language->get('text_titles');
		$data['text_about'] = $this->language->get('text_about');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('information/about', $data));
	}
}
