<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Orders_model extends CI_Model {

    // Retrieve all orders along with related product and supplier details
    public function get_orders() {
        // Select columns from the 'orders', 'products', and 'suppliers' tables
        $this->db->select('o.*, p.id as product_id, p.material as product_name, (p.price + p.additional_price) as product_price, s.name as supplier_name');
        // Join 'products' table to fetch product details
        $this->db->join('products p', 'p.id = o.product_id');
        // Join 'suppliers' table to fetch supplier details based on the product's supplier
        $this->db->join('suppliers s', 's.id = p.supplier_id');
        // Fetch data from the 'orders' table with the necessary joins
        $query = $this->db->get('orders o');
        // Return the result as an array of objects
        return $query->result();
    }

    // Add a new order to the 'orders' table
    public function add_order(array $data) {
        // Insert the order data into the 'orders' table
        $this->db->insert('orders', $data);

        // Check if the insert operation was successful (by checking if an insert ID was generated)
        if ($this->db->insert_id()) {
            return true; // Return true if the order was successfully added
        } else {
            return false; // Return false if the insert operation failed
        }
    }

    // Update an existing order in the 'orders' table
    public function update_order(int $order_id, array $data) {
        // Find the order by its ID
        $this->db->where('id', $order_id);
        // Update the order's data in the 'orders' table
        $this->db->update('orders', $data);

        // Check if any rows were affected by the update (i.e., if the update was successful)
        if ($this->db->affected_rows()) {
            return true; // Return true if the update was successful
        } else {
            return false; // Return false if no rows were affected (meaning the update failed or no changes were made)
        }
    }
}
