<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model {

    // Constructor: Loads the 'user_model' to interact with the user-specific functions
    public function __construct() {
        parent::__construct();
        $this->load->model('user_model', 'user');
    }

    /**
     * Check if the user is logged in.
     * 
     * @param string $login_token Optional login token for authentication.
     * @return bool Returns true if the user is logged in, otherwise false.
     */
    public function is_user_logged_in($login_token = '') {
        $status = false;

        try {
            // Get the user ID from the session
            $user_id = $this->session->user_id;

            // Check if the session contains a user ID
            if ($user_id) {
                $this->db->where('id', $user_id);
                $query = $this->db->get('users');

                // Verify if the user exists
                if ($query->num_rows() > 0) {
                    $status = true;
                } else {
                    $status = false;
                }
            }

            // If the user is not logged in through session, check for the login token
            if (!$status && $login_token) {
                $user = $this->get_user_by_login_token($login_token);

                // Auto login if a valid user is found through the login token
                if ($user) {
                    $this->user->auto_login($user->id, true);
                } else {
                    $status = false;
                }
            }
            return $status;
        } catch (Exception $e) {
            return $status;
        }
    }

    /**
     * Retrieve a user record by login token.
     * 
     * @param string $login_token Optional login token parameter.
     * @return mixed Returns the user object if found, otherwise false.
     */
    public function get_user_by_login_token($login_token = '') {
        // If no login token is passed, get it from the 'remember' cookie
        if ($login_token) {
            $login_token = get_cookie('remember');
        }

        // If the login token is still empty, return false
        if (!$login_token) {
            return false;
        }

        // Fetch the user based on the login token from the 'users' table
        $this->db->where('login_token', $login_token);
        $query = $this->db->get('users');

        // Return the user object if a match is found, otherwise return false
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    /**
     * Validate the current user's password.
     * 
     * @param string $password The password to validate.
     * @return bool Returns true if the password is valid, otherwise false.
     */
    public function validate_current_user_password($password) {
        // Get the current user ID from the session
        $user_id = $this->session->user_id;

        // Fetch the user record by user ID
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');
        $user = $query->row();

        // Validate the entered password using the password hash stored in the database
        if (password_verify($password, $user->password)) {
            return true;
        }

        return false;
    }

    /**
     * Set a login token for the user.
     * 
     * @param int $user_id The user ID.
     * @param string $remember_token The token to be saved.
     * @return void
     */
    public function set_login_token(int $user_id, string $remember_token) {
        // Update the 'login_token' field for the user
        $this->db->where('id', $user_id);
        $this->db->update('users', array('login_token' => $remember_token));
    }

    /**
     * Get the login token for the user.
     * 
     * @param int $user_id The user ID.
     * @return string Returns the login token of the user.
     */
    public function get_login_token(int $user_id) {
        // Retrieve the login token from the 'users' table
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');
        return $query->row()->login_token;
    }

    /**
     * Remove the login token for the current user.
     * 
     * @return void
     */
    public function remove_login_token() {
        // Get the current user ID from the session
        $user_id = $this->session->user_id;

        if ($user_id) {
            // Delete the 'remember' cookie and clear the login token in the database
            delete_cookie('remember');
            $this->db->where('id', $user_id);
            $this->db->update('users', array('login_token' => ''));
        }
    }
}
