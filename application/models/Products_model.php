<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products_model extends CI_Model {

    // Constructor to load the parent CI_Model and ensure the database connection
    public function __construct() {
        parent::__construct();
    }

    // Fetch all active products along with their supplier info, stock levels, sales, and total price
    public function get_products() {
        // Select columns from the 'products' table and join with the 'suppliers' table
        $this->db->select('p.*, s.id as supplier_id, s.name as supplier_name');
        // Only fetch products that are 'active'
        $this->db->where('p.status', 'active');
        // Join 'suppliers' table to get supplier information for each product
        $this->db->join('suppliers s', 's.id = p.supplier_id');
        // Query the 'products' table
        $query = $this->db->get('products p');
        $products = $query->result(); // Fetch the result as an array of product objects

        // For each product, calculate stock levels, total price, and amount purchased
        foreach ($products as $product) {
            // Get the total quantity of the product that has been sold (based on 'orders' table)
            $this->db->where('product_id', $product->id);
            $this->db->select('SUM(quantity) as quantity');
            $query = $this->db->get('orders');
            $orders = $query->row();

            // Calculate stock: remaining quantity after sales
            $product->stock = $product->quantity - $orders->quantity;
            // Calculate the number of items sold
            $product->sold = $product->quantity - $product->stock;
            // Calculate the total price (base price + additional price)
            $product->total_price = $product->price + $product->additional_price;
            // Calculate the total amount earned from the product based on sales
            $product->amount_purchased = $orders->quantity * $product->total_price;
        }

        // Return the final product data with calculated fields
        return $products;
    }

    // Add a new product to the 'products' table
    public function add_product(array $data) {
        // Insert the product data into the 'products' table
        $this->db->insert('products', $data);

        // Check if the insert operation was successful by checking if an insert ID was generated
        if ($this->db->insert_id()) {
            return true; // Return true if the product was successfully added
        } else {
            return false; // Return false if the insert operation failed
        }
    }

    // Update an existing product in the 'products' table
    public function update_product(int $product_id, array $data) {
        // Find the product by its ID and update the corresponding fields
        $this->db->where('id', $product_id);
        $this->db->update('products', $data);

        // Check if any rows were affected by the update operation
        if ($this->db->affected_rows() > 0) {
            return true; // Return true if the update was successful
        } else {
            return false; // Return false if no rows were affected (i.e., update failed or no changes were made)
        }
    }

    // Soft delete a product by setting its status to 'inactive'
    public function delete_product(int $product_id) {
        // Find the product by its ID and update the status to 'inactive'
        $this->db->where('id', $product_id);
        $this->db->update('products', ['status' => 'inactive']);

        // Check if any rows were affected by the update (to confirm the soft delete was successful)
        if ($this->db->affected_rows() > 0) {
            return true; // Return true if the product was successfully marked as 'inactive'
        } else {
            return false; // Return false if no rows were affected (i.e., deletion failed)
        }
    }
}
