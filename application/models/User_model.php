<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model {

    // Constructor to load necessary models for encryption and authentication
    public function __construct() {
        parent::__construct();
        $this->load->model('encryption_model', 'encryption');
        $this->load->model('auth_model', 'auth');
    }

    // Method to handle user signup (registration)
    public function signup(array $data) {
        // Get the current date and time for user registration timestamp
        $date = date('Y-m-d H:i:s');

        // Hash the user's password for secure storage in the database
        $data['password'] = $this->encryption->generate_hash_password($data['password']);
        // Add the 'date_added' field to the user data
        $data['date_added'] = $date;

        // Insert the new user data into the 'users' table
        $this->db->insert('users', $data);
        // Get the ID of the newly inserted user
        $user_id = $this->db->insert_id();

        // Return the user ID if the insert operation was successful, otherwise return false
        if ($user_id) {
            return $user_id;
        } else {
            return false;
        }
    }

    // Method to handle user login (authentication)
    public function signin(string $username, string $password, $remember_me = false) {
        // Search for the user by their username
        $this->db->where('username', $username);
        $query = $this->db->get('users');

        // If the user exists in the database
        if ($query->num_rows() > 0) {
            $user = $query->row();

            // Verify the provided password against the stored hashed password
            if (password_verify($password, $user->password)) {
                // If the password is correct, call auto_login to log the user in
                $this->auto_login($user->id, true);
                return $user; // Return the user object on successful login
            } else {
                return false; // Return false if the password is incorrect
            }
        } else {
            return false; // Return false if no user with the given username is found
        }
    }

    // Method to handle auto-login (session management)
    public function auto_login(int $user_id, $remember_me = false) {
        // Search for the user by their user ID
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');

        // If the user exists in the database
        if ($query->num_rows() > 0) {
            $user = $query->row();
            // Generate a unique login token for session management
            $login_token = $this->encryption->generate_token();

            // If "remember me" is selected, set a cookie with the login token
            if ($remember_me) {
                $cookie = array(
                    'name'   => 'remember',
                    'value'  => $login_token,
                    'expire' => '2592000', // Cookie expires in 30 days (2592000 seconds)
                    'secure' => false,
                    'httponly' => true // Cookie is accessible only through HTTP (not JavaScript)
                );
                set_cookie($cookie);
                // Store the login token in the database for the user
                $this->auth->set_login_token($user_id, $login_token);
            }

            // Prepare user session data
            $user_data = array(
                'user_id' => $user->id,
                'email' => $user->email,
                'username' => $user->username,
                'firtname' => $user->firstname, // Note: There is a typo here, 'firtname' should be 'firstname'
                'lastname' => $user->lastname,
                'fullname' => $user->firstname . ' ' . $user->lastname,
                'logged_in' => true
            );
            // Regenerate session to prevent session fixation attacks
            $this->session->sess_regenerate();
            // Store the user data in the session
            $this->session->set_userdata($user_data);

            return true; // Return true on successful login
        }

        return false; // Return false if the user is not found
    }

    // Method to update the user's password
    public function update_password(int $user_id, $password) {
        // Find the user by their ID and update the password field
        $this->db->where('id', $user_id);
        $this->db->update('users', ['password' => $password]);
    }

    // Method to get user data by user ID
    public function get_userdata_by_id(int $user_id) {
        // Search for the user by their ID
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');

        // Return the user object
        return $query->row();
    }

    // Method to update the user's data
    public function update_user(int $user_id, $data) {
        // Find the user by their ID and update their information
        $this->db->where('id', $user_id);
        $this->db->update('users', $data);

        // Check if any rows were affected by the update operation
        if ($this->db->affected_rows() > 0) {
            return true; // Return true if the update was successful
        } else {
            return false; // Return false if no rows were affected (i.e., no changes were made)
        }
    }
}
