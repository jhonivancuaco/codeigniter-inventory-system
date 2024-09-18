<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    // Constructor to load necessary models and ensure user authentication
    public function __construct() {
        parent::__construct();

        // Load the required models for encryption, authentication, suppliers, products, orders, and computations
        $this->load->model('encryption_model', 'encryption');
        $this->load->model('auth_model', 'auth');
        $this->load->model('supplier_model', 'supplier');
        $this->load->model('products_model', 'products');
        $this->load->model('orders_model', 'orders');
        $this->load->model('computation_model', 'computation');

        // Ensure the user is logged in; if not, redirect to the base URL
        if (!$this->auth->is_user_logged_in()) {
            redirect(base_url());
        }
    }

    // Dashboard overview page (Inventory) - Displays overview of sales and inventory
    public function index() {
        // Fetch an overview of sales and inventory data
        $overview = $this->computation->overview();
        $data['reports'] = $overview;
        $data['title'] = 'Inventory';

        // Load the inventory page with the provided data
        template('dashboard', 'dashboard/inventory', $data);
    }

    // Sales activity page - Displays detailed sales reports
    public function sales_activity() {
        // Fetch detailed sales reports
        $reports = $this->computation->get_reports();
        $data['reports'] = $reports;

        $data['title'] = 'Sales Activity';

        // Load the sales activity page with the provided data
        template('dashboard', 'dashboard/sales-activity', $data);
    }

    // User settings page - Handles changing passwords and updating profiles
    public function settings() {
        $user_id = $this->session->user_id;
        $action = $this->input->post('action');

        // If the action is to change the user's password
        if ($action === 'change-password') {
            $this->form_validation->set_rules('change_password', 'Old Password', 'trim|required|callback_same_password_checker');

            if ($this->form_validation->run() === true) {
                $password = $this->input->post('change_password');
                $password = $this->encryption->generate_hash_password($password);
                $this->user->update_password($user_id, $password);

                // Set success message for password change
                $this->session->set_flashdata('change_password_success', 'Password changed successfully');
            }
        }

        // If the action is to update the user's profile
        if ($action === 'update-profile') {
            $this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
            $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|regex_match[/^[0-9]{11}$/]');
            $this->form_validation->set_rules('address', 'Address', 'trim|required');

            if ($this->form_validation->run() === true) {
                $user_data = array(
                    'firstname' => $this->input->post('firstname'),
                    'lastname' => $this->input->post('lastname'),
                    'email' => $this->input->post('email'),
                    'mobile' => $this->input->post('mobile'),
                    'address' => $this->input->post('address'),
                );

                // Update the user's profile and set success or failure messages
                $is_updated = $this->user->update_user($user_id, $user_data);

                if ($is_updated) {
                    $this->session->set_flashdata('update_profile_success', 'Profile updated successfully');
                } else {
                    $this->session->set_flashdata('update_profile_failed', 'Failed to update profile or no changes made');
                }
            }
        }

        // Fetch user data to display in the settings form
        $user = $this->user->get_userdata_by_id($user_id);

        $data['userdata'] = $user;
        $data['title'] = 'Settings';

        // Load the settings page
        template('dashboard', 'dashboard/settings', $data);
    }

    // Custom validation rule to check if the new password is different from the old password
    public function same_password_checker($password) {
        // Check if the provided password matches the current password
        $same_password = $this->auth->validate_current_user_password($password);

        if ($same_password) {
            $this->form_validation->set_message('same_password_checker', 'The Old Password is the same as the current one. Please enter a new password.');
            return false;
        }

        return true;
    }

    // Supplier management page - Handles adding, updating, and deleting suppliers
    public function supplier() {
        $supplier_action = $this->input->post('supplier_action');
        $supplier_id = $this->input->post('supplier_id');

        // If the action is to add or update a supplier
        if ($supplier_action === 'add_update') {
            $this->form_validation->set_rules('name', 'Name', 'trim|required');
            $this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|regex_match[/^[0-9]{11}$/]');
            $this->form_validation->set_rules('address', 'Address', 'trim|required');

            if ($this->form_validation->run() === true) {
                $supplier_data = array(
                    'name' => $this->input->post('name'),
                    'mobile' => $this->input->post('mobile'),
                    'address' => $this->input->post('address'),
                );

                // Update existing supplier or add a new one
                if ($supplier_id) {
                    $result = $this->supplier->update_supplier($supplier_id, $supplier_data);

                    if ($result) {
                        $this->session->set_flashdata('supplier_success', 'Supplier updated successfully');
                    } else {
                        $this->session->set_flashdata('supplier_failed', 'Failed to update supplier or no changes made');
                    }
                } else {
                    $supplier_data['date_added'] = date('Y-m-d H:i:s');
                    $result = $this->supplier->add_supplier($supplier_data);

                    if ($result) {
                        $this->session->set_flashdata('supplier_success', 'Supplier added successfully');
                    } else {
                        $this->session->set_flashdata('supplier_failed', 'Failed to add new supplier');
                    }
                }
                redirect(base_url('dashboard/supplier'));
            }
        }

        // If the action is to delete a supplier
        if ($supplier_action === 'delete') {
            $this->form_validation->set_rules('supplier_id', 'Supplier ID', 'trim|required');

            if ($this->form_validation->run() === true) {
                $result = $this->supplier->delete_supplier($supplier_id);

                if ($result) {
                    $this->session->set_flashdata('supplier_success', 'Supplier deleted successfully');
                } else {
                    $this->session->set_flashdata('supplier_failed', 'Failed to delete supplier or supplier not found');
                }

                redirect(base_url('dashboard/supplier'));
            }
        }

        $data['title'] = 'Manage Sales - Supplier';
        $data['js'] = array(base_url('assets/js/supplier.js'));

        // Load the supplier management page
        template('dashboard', 'dashboard/supplier', $data);
    }

    // Product management page - Handles adding, updating, and deleting products
    public function products() {
        $suppliers = $this->supplier->get_suppliers();

        // If no suppliers are found, redirect to the supplier management page
        if (!$suppliers) {
            redirect(base_url('dashboard/supplier'));
        }

        $product_action = $this->input->post('product_action');
        $product_id = $this->input->post('product_id');

        // If the action is to add or update a product
        if ($product_action === 'add_update') {
            $this->form_validation->set_rules('material', 'Material', 'trim|required');
            $this->form_validation->set_rules('supplier_id', 'Supplier', 'trim|required|numeric|greater_than[0]');
            $this->form_validation->set_rules('price', 'Price', 'trim|required|numeric|greater_than[0]');
            $this->form_validation->set_rules('additional_price', 'Additional Price', 'trim|required|numeric|greater_than[0]');
            $this->form_validation->set_rules('quantity', 'Quantity', 'trim|required|numeric|greater_than[0]');

            if ($this->form_validation->run() === true) {
                $product_data = array(
                    'material' => $this->input->post('material'),
                    'supplier_id' => $this->input->post('supplier_id'),
                    'price' => $this->input->post('price'),
                    'additional_price' => $this->input->post('additional_price'),
                    'quantity' => $this->input->post('quantity'),
                );

                // Update existing product or add a new one
                if ($product_id) {
                    $result = $this->products->update_product($product_id, $product_data);

                    if ($result) {
                        $this->session->set_flashdata('product_success', 'Product updated successfully');
                    } else {
                        $this->session->set_flashdata('product_failed', 'Failed to update product or no changes made');
                    }
                } else {
                    $product_data['date_added'] = date('Y-m-d H:i:s');
                    $result = $this->products->add_product($product_data);

                    if ($result) {
                        $this->session->set_flashdata('product_success', 'Product added successfully');
                    } else {
                        $this->session->set_flashdata('product_failed', 'Failed to add new product');
                    }
                }

                redirect(base_url('dashboard/products'));
            }
        }

        // If the action is to delete a product
        if ($product_action === 'delete') {
            $this->form_validation->set_rules('product_id', 'Product ID', 'trim|required');

            if ($this->form_validation->run() === true) {
                $result = $this->products->delete_product($product_id);

                if ($result) {
                    $this->session->set_flashdata('product_success', 'Product deleted successfully');
                } else {
                    $this->session->set_flashdata('product_failed', 'Failed to delete product or product not found');
                }

            }

            redirect(base_url('dashboard/products'));
        }

        $data['suppliers'] = $suppliers;
        $data['title'] = 'Manage Sales - Products';
        $data['js'] = array(base_url('assets/js/products.js'));

        // Load the product management page
        template('dashboard', 'dashboard/products', $data);
    }

    // Order management page - Handles adding and updating orders
    public function orders() {
        $products = $this->products->get_products();

        // If no products are found, redirect to the product management page
        if (!$products) {
            redirect(base_url('dashboard/products'));
        }

        $order_id = $this->input->post('order_id');

        // Validate the form inputs for adding or updating orders
        $this->form_validation->set_rules('product_id', 'Product', 'trim|required|numeric|greater_than[0]');
        $this->form_validation->set_rules('transaction_id', 'Transaction ID', 'trim|required|numeric');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|regex_match[/^[0-9]{11}$/]');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('mode_of_payment', 'Payment Method', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');
        $this->form_validation->set_rules('quantity', 'Quantity', 'trim|required|numeric|greater_than[0]');
        $this->form_validation->set_rules('date_purchased', 'Date Purchased', 'trim|required');

        if ($this->input->post('date_delivered')) {
            $this->form_validation->set_rules('date_delivered', 'Date Delivered', 'trim|required');
        }

        if ($this->form_validation->run() === true) {
            $order_data = array(
                'transaction_id' => $this->input->post('transaction_id'),
                'name' => $this->input->post('name'),
                'address' => $this->input->post('address'),
                'mobile' => $this->input->post('mobile'),
                'product_id' => $this->input->post('product_id'),
                'quantity' => $this->input->post('quantity'),
                'mode_of_payment' => $this->input->post('mode_of_payment'),
                'status' => $this->input->post('status'),
                'date_purchased' => $this->input->post('date_purchased') ? date('Y-m-d H:i:s', strtotime($this->input->post('date_purchased'))) : null,
                'date_delivered' => $this->input->post('date_delivered') ? date('Y-m-d H:i:s', strtotime($this->input->post('date_delivered'))) : null,
            );

            // Update existing order or add a new one
            if ($order_id) {
                $result =  $this->orders->update_order($order_id, $order_data);

                if ($result) {
                    $this->session->set_flashdata('order_success', 'Order updated successfully');
                } else {
                    $this->session->set_flashdata('order_failed', 'Failed to update order');
                }
            } else {
                $order_data['date_added'] = date('Y-m-d H:i:s');
                $result = $this->orders->add_order($order_data);

                if ($result) {
                    $this->session->set_flashdata('order_success', 'Order added successfully');
                } else {
                    $this->session->set_flashdata('order_failed', 'Failed to add new order');
                }
            }

            redirect(base_url('dashboard/orders'));
        }

        $data['products'] = $products;
        $data['title'] = 'Manage Sales - Orders';
        $data['js'] = array(base_url('assets/js/orders.js'));

        // Load the order management page
        template('dashboard', 'dashboard/orders', $data);
    }
}
