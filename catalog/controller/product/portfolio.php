<?php
class ControllerProductPortfolio extends Controller {
	public function index() {
                $this->load->model('catalog/product');
                $this->load->model('tool/image');
            
                $results = $this->model_catalog_product->getProducts();

                foreach ($results as $result) {
                        if ($result['image']) {
                                $image = $this->model_tool_image->resize($result['image'], 800, 0);
                        } else {
                                $image = $this->model_tool_image->resize('placeholder.png', 800, 0);
                        }

                        if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                                $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                        } else {
                                $price = false;
                        }

                        if ((float)$result['special']) {
                                $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                        } else {
                                $special = false;
                        }

                        if ($this->config->get('config_tax')) {
                                $tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
                        } else {
                                $tax = false;
                        }

                        if ($this->config->get('config_review_status')) {
                                $rating = (int)$result['rating'];
                        } else {
                                $rating = false;
                        }
                        
                        $categoriesList = $this->model_catalog_product->getCategories($result['product_id']);
                        $categories = '';
                        $delim = '';
                        foreach($categoriesList as $category){
                            $categories .= $delim . $category['category_id'];
                            $delim = ',';
                        }

                        $data['products'][] = array(
                                'product_id'  => $result['product_id'],
                                'thumb'       => $image,
                                'name'        => $result['name'],
                                'description' => $result['meta_description'],
                                'price'       => $price,
                                'special'     => $special,
                                'tax'         => $tax,
                                'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
                                'rating'      => $result['rating'],
                                'href'        => $result['model'],
                                'categories'  => $categories
                        );
                }

		return $this->load->view('product/portfolio', $data);
	}
}
