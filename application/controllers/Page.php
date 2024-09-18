<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page extends CI_Controller {

	public function __construct() {
		parent::__construct();

		// Load models
		$this->load->model('auth_model', 'auth');
		$this->load->model('user_model', 'user');
	}

	/**
	 * Logout
	 */
	public function logout() {
		// Remove login token
		$this->auth->remove_login_token();
		// Destroy session data
		$this->session->sess_destroy();
		// Redirect to homepage
		redirect(base_url());
	}

	/**
	 * Login
	 */
	public function login() {

		// If user is already logged in or has a login token, redirect to dashboard
		$login_token = get_cookie('remember');
		if ($this->auth->is_user_logged_in($login_token)) {
			redirect(base_url('dashboard'));
		}

		// Set form validation rule
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		// Check if form is not submitted
		if ($this->form_validation->run() === false) {
			template('blank', 'login');
		} else {
			// Do login logic when form is submitted and all fields are valid

			// Get form data
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$remember_me = $this->input->post('remember_me');

			// Do login logic from user model
			$user = $this->user->signin($username, $password, $remember_me);

			if ($user) {
				// If login is successful redirect to dashboard page
				$this->session->set_flashdata('login_success', 'Login Successful');
				redirect(base_url('dashboard'));
			} else {
				// If login is not successful, redirect back to login page and display error
				$this->session->set_flashdata('login_error', 'Invalid username or password');
				redirect(base_url());
			}
		}
	}

	/**
	 * Register
	 */
	public function register() {
		// If user is already logged in or has a login token, redirect to dashboard
		if ($this->auth->is_user_logged_in()) {
			redirect(base_url('dashboard'));
		}

		// Set form validation rule
		$this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
		$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|regex_match[/^[0-9]{11}$/]');
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');

		// Check if form is not submitted
		if ($this->form_validation->run() === false) {
			template('blank', 'register');
		} else {
			// Do register logic when form is submitted and all fields are valid

			// Get form data
			$data = array(
				'firstname' => $this->input->post('firstname'),
				'lastname' => $this->input->post('lastname'),
				'email' => $this->input->post('email'),
				'mobile' => $this->input->post('mobile'),
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password')
			);

			// Do register logic from user model
			$user_id = $this->user->signup($data);

			if ($user_id) {
				// If registration is successful redirect to login page
				$this->session->set_flashdata('register_success', 'You have successfully registered. Please login.');
				redirect(base_url());
			} else {
				// If registration is not successful, redirect back to register page and display error
				$this->session->set_flashdata('register_error', 'Registration failed. Please try again.');
				redirect(base_url('page/register'));
			}
		}
	}


	/**
	 * Populate the database with random suppliers, products, and orders.
	 *
	 * This is a temporary controller that is used for development purposes.
	 * It is not intended to be a part of the production code.
	 *
	 * @return void
	 */
	public function populate() {
		$this->load->model('populate_model', 'populate');

		// Populates the database with 10 suppliers, 100 products, and 1000 orders.
		// The numbers can be changed to whatever is desired.
		$this->populate->populateDatabase(10, 100, 1000);
	}
}
