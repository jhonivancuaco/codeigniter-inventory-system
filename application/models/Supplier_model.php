<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier_model extends CI_Model {

    // Constructor to initialize the model and ensure the database connection is loaded
    public function __construct() {
        parent::__construct();
    }

    // Retrieve all active suppliers from the 'suppliers' table
    public function get_suppliers() {
        // Filter to only get suppliers with 'active' status
        $this->db->where('status', 'active');
        // Query the 'suppliers' table
        $query = $this->db->get('suppliers');
        // Return the result as an array of supplier objects
        return $query->result();
    }

    // Add a new supplier to the 'suppliers' table
    public function add_supplier(array $data) {
        // Insert the supplier data into the 'suppliers' table
        $this->db->insert('suppliers', $data);

        // Check if the insert operation was successful by checking if an insert ID was generated
        if ($this->db->insert_id()) {
            return true; // Return true if the supplier was successfully added
        } else {
            return false; // Return false if the insert operation failed
        }
    }

    // Update an existing supplier in the 'suppliers' table
    public function update_supplier(int $supplier_id, array $data) {
        // Find the supplier by its ID and update the corresponding fields
        $this->db->where('id', $supplier_id);
        $this->db->update('suppliers', $data);

        // Check if any rows were affected by the update operation
        if ($this->db->affected_rows() > 0) {
            return true; // Return true if the update was successful
        } else {
            return false; // Return false if no rows were affected (i.e., update failed or no changes were made)
        }
    }

    // Soft delete a supplier by setting its status to 'inactive'
    public function delete_supplier(int $supplier_id) {
        // Find the supplier by its ID and update the status to 'inactive'
        $this->db->where('id', $supplier_id);
        $this->db->update('suppliers', ['status' => 'inactive']);

        // Check if any rows were affected by the update (to confirm the soft delete was successful)
        if ($this->db->affected_rows() > 0) {
            return true; // Return true if the supplier was successfully marked as 'inactive'
        } else {
            return false; // Return false if no rows were affected (i.e., deletion failed)
        }
    }
}
