<?php

defined('BASEPATH') or exit('No direct script access allowed');

class DatabaseHook {

    /**
     * Generate the database specified in the database config file.
     *
     * Connects to the MySQL server using the credentials specified in the
     * database config file, and checks if the database specified exists.
     * If the database does not exist, it is created.
     *
     * @return void
     */
    public function generate_database() {

        // Load the database configuration file
        include(APPPATH . 'config/database.php');
        $dbName = $db['default']['database'];
        $dbHost = $db['default']['hostname'];
        $dbUser = $db['default']['username'];
        $dbPass = $db['default']['password'];

        // Connect to the MySQL server (without selecting a database)
        $conn = new mysqli($dbHost, $dbUser, $dbPass);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if the database exists
        $dbExists = $conn->select_db($dbName);

        // If the database does not exist, create it
        if (!$dbExists) {
            $sql = "CREATE DATABASE IF NOT EXISTS `$dbName`";
            if ($conn->query($sql) === TRUE) {
                log_message("info", "Database $dbName created successfully");
            } else {
                log_message("error", "Error creating database $dbName: " . $conn->error);
                die("Error creating database: " . $conn->error);
            }
        }

        // Close the connection
        $conn->close();
    }

    /**
     * Generates the tables in the database based on the defined schema.
     * If the table already exists, it will just add the missing fields.
     *
     * @return void
     */
    public function generate_tables() {
        // Load the database and dbforge libraries
        $CI = &get_instance();
        $CI->load->database();
        $CI->load->dbforge();

        // The following tables are created in the database
        // - users: contains user information
        // - supplier: contains supplier information
        // - materials: contains product information
        // - orders: contains order information
        $tables = array(
            'users' => array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => true,
                    'unsigned' => true,
                ),
                'firstname' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                ),
                'lastname' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                ),
                'email' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                ),
                'mobile' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                ),
                'username' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                ),
                'password' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                ),
                'address' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                ),
                'login_token' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                ),
                'date_added' => array(
                    'type' => 'DATETIME',
                    'null' => false,
                ),
                'date_modified' => array(
                    'type' => 'TIMESTAMP',
                    'on_update' => 'CURRENT_TIMESTAMP',
                    'null' => false,
                ),

            ),
            'suppliers' => array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => true,
                    'unsigned' => true,
                ),
                'name' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                ),
                'address' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                ),
                'mobile' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                ),
                'status' => array(
                    'type' => 'ENUM',
                    'constraint' => array('active', 'inactive'),
                    'null' => false,
                ),
                'date_added' => array(
                    'type' => 'DATETIME',
                    'null' => false,
                ),
                'date_modified' => array(
                    'type' => 'TIMESTAMP',
                    'on_update' => 'CURRENT_TIMESTAMP',
                    'null' => false,
                ),

            ),
            'materials' => array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => true,
                    'unsigned' => true,
                ),
                'material' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                ),
                'supplier_id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => false,
                ),
                'price' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => false,
                ),
                'additional_price' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => false,
                ),
                'quantity' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => false,
                ),
                'status' => array(
                    'type' => 'ENUM',
                    'constraint' => array('active', 'inactive'),
                    'null' => false,
                ),
                'date_added' => array(
                    'type' => 'DATETIME',
                    'null' => false,
                ),
                'date_modified' => array(
                    'type' => 'TIMESTAMP',
                    'on_update' => 'CURRENT_TIMESTAMP',
                    'null' => false,
                ),

            ),
            'products' => array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => true,
                    'unsigned' => true,
                ),
                'name' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                ),
                'price' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => false,
                ),
                'quantity' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => false,
                ),
                'status' => array(
                    'type' => 'ENUM',
                    'constraint' => array('active', 'inactive'),
                    'null' => false,
                ),
                'date_added' => array(
                    'type' => 'DATETIME',
                    'null' => false,
                ),
                'date_modified' => array(
                    'type' => 'TIMESTAMP',
                    'on_update' => 'CURRENT_TIMESTAMP',
                    'null' => false,
                ),
            ),
            'transactions' => array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => true,
                    'unsigned' => true,
                ),
                'product_id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => false,
                ),
                'product_price'=> array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => false,
                ),
                'transaction_id' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                ),
                'name' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                ),
                'address' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                ),
                'mobile' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                ),
                'quantity' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => false,
                ),
                'mode_of_payment' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                ),
                'status' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                ),
                'date_delivered' => array(
                    'type' => 'DATETIME',
                    'null' => true,
                ),
                'date_purchased' => array(
                    'type' => 'DATETIME',
                    'null' => false,
                ),
                'date_added' => array(
                    'type' => 'DATETIME',
                    'null' => false,
                ),
                'date_modified' => array(
                    'type' => 'TIMESTAMP',
                    'on_update' => 'CURRENT_TIMESTAMP',
                    'null' => false,
                ),
            )
        );


        // Loop through each table and create it if it doesn't exist
        foreach ($tables as $table => $fields) {

            // Create the table if it doesn't exist
            if (!$CI->db->table_exists($table)) {
                $CI->dbforge->add_field($fields);
                $CI->dbforge->add_key('id', true);
                $CI->dbforge->create_table($table);
            } else {
                // Loop through each field in the table and add it if it doesn't exist
                $current_fields = $CI->db->list_fields($table);
                foreach ($fields as $field => $attributes) {
                    if (!in_array($field, $current_fields)) {
                        $CI->dbforge->add_column($table, array($field => $attributes));
                    }
                }
            }
        }

        $CI->load->model('populate_model', 'populate');
        // Comment out the following line if you don't want to populate new dummy data into the database
        $CI->populate->populateDatabase();
    }
}
