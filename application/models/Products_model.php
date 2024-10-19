<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products_model extends CI_Model {

    // Retrieve all products along with related product and supplier details
    public function get_transactions() {
        // Fetch data from the 'products' table with the necessary joins
        $this->db->select('t.*, p.name as product_name');
        $this->db->where('p.status', 'active');
        $this->db->join('products p', 'p.id = t.product_id');
        $this->db->order_by('t.date_delivered', 'ASC');
        $query = $this->db->get('transactions t');
        $transactions = $query->result();

        foreach ($transactions as &$transaction) {
            $transaction->total_price = $transaction->quantity * $transaction->product_price;
        }

        return $transactions;
    }

    public function get_products() {
        // Fetch data from the 'products' table
        $this->db->where('status', 'active');
        $query = $this->db->get('products');
        return $query->result();
    }

    // Add a new order to the 'products' table
    public function add_order(array $data) {
        // Insert the order data into the 'products' table
        $this->db->insert('transactions', $data);

        // Check if the insert operation was successful (by checking if an insert ID was generated)
        if ($this->db->insert_id()) {
            return true; // Return true if the order was successfully added
        } else {
            return false; // Return false if the insert operation failed
        }
    }

    // Update an existing order in the 'products' table
    public function update_order(int $order_id, array $data) {
        // Find the order by its ID
        $this->db->where('id', $order_id);
        // Update the order's data in the 'products' table
        $this->db->update('transactions', $data);

        // Check if any rows were affected by the update (i.e., if the update was successful)
        if ($this->db->affected_rows()) {
            return true; // Return true if the update was successful
        } else {
            return false; // Return false if no rows were affected (meaning the update failed or no changes were made)
        }
    }

    public function add_product(array $data) {
        $this->db->insert('products', $data);

        if ($this->db->insert_id()) {
            return true; // Return true if the order was successfully added
        } else {
            return false; // Return false if the insert operation failed
        }
    }

    public function update_product(int $product_id, array $data) {
        $this->db->where('id', $product_id);
        $this->db->update('products', $data);

        if ($this->db->affected_rows()) {
            return true; // Return true if the update was successful
        } else {
            return false; // Return false if no rows were affected (meaning the update failed or no changes were made)
        }
    }

    public function delete_product(int $product_id) {
        $this->db->where('id', $product_id);
        $this->db->update('products', ['status' => 'inactive']);

        if ($this->db->affected_rows()) {
            return true; // Return true if the update was successful
        } else {
            return false; // Return false if no rows were affected (meaning the update failed or no changes were made)
        }
    }
}
