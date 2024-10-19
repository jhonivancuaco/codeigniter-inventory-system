<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ajax extends CI_Controller {

    // Constructor to load necessary models and check if the user is logged in
    public function __construct() {
        parent::__construct();
        // Load models for authentication, suppliers, materials, and products
        $this->load->model('auth_model', 'auth');
        $this->load->model('supplier_model', 'supplier');
        $this->load->model('materials_model', 'materials');
        $this->load->model('products_model', 'products');

        // Check if the user is logged in, otherwise redirect to the base URL
        if (!$this->auth->is_user_logged_in()) {
            redirect(base_url()); // Redirect to the home page if not logged in
        }
    }

    // Method to handle AJAX request for getting supplier data
    public function ajax_get_suppliers() {
        // Fetch suppliers using the supplier model
        $suppliers = $this->supplier->get_suppliers();

        // Set HTTP status header to 200 (OK)
        $this->output->set_status_header(200);
        // Set content type to JSON and return the suppliers data as a JSON response
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $suppliers]));
    }

    // Method to handle AJAX request for getting product data
    public function ajax_get_materials() {
        // Fetch materials using the materials model
        $materials = $this->materials->get_materials();
        // Set HTTP status header to 200 (OK)
        $this->output->set_status_header(200);
        // Set content type to JSON and return the materials data as a JSON response
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $materials]));
    }

    // Method to handle AJAX request for getting order data
    public function ajax_get_transactions() {
        // Fetch products using the products model
        $products = $this->products->get_transactions();

        // Set HTTP status header to 200 (OK)
        $this->output->set_status_header(200);
        // Set content type to JSON and return the products data as a JSON response
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $products]));
    }

    public function ajax_get_products() {
        $products = $this->products->get_products();

        // Set HTTP status header to 200 (OK)
        $this->output->set_status_header(200);
        // Set content type to JSON and return the products data as a JSON response
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $products]));
    }
}
