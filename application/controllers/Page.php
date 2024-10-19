<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('auth_model', 'auth');
	}

	public function login() {
		$login_token = get_cookie('remember');
		if ($this->auth->is_user_logged_in($login_token)) {
			redirect(base_url('dashboard'));
		}

		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		if ($this->form_validation->run() === false) {
			template('blank', 'login');
		} else {

			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$remember_me = $this->input->post('remember_me');

			$user = $this->user->signin($username, $password, $remember_me);

			if ($user) {
				$this->session->set_flashdata('login_success', 'Login Successful');
				redirect(base_url('dashboard'));
			} else {
				$this->session->set_flashdata('login_error', 'Invalid username or password');
				redirect(base_url());
			}
		}
	}

	public function register() {
		$login_token = get_cookie('remember');
		if ($this->auth->is_user_logged_in($login_token)) {
			redirect(base_url('dashboard'));
		}

		$this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
		$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_is_email_exists_rule');
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|regex_match[/^[0-9]{11}$/]');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|callback_is_username_exists_rule');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');

		if ($this->form_validation->run() === true) {
			$data = array(
				'firstname' => $this->input->post('firstname'),
				'lastname' => $this->input->post('lastname'),
				'email' => $this->input->post('email'),
				'mobile' => $this->input->post('mobile'),
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password')
			);

			$user_id = $this->user->signup($data);

			if ($user_id) {
				$this->session->set_flashdata('register_success', 'You have successfully registered. Please login.');
				redirect(base_url());
			} else {
				$this->session->set_flashdata('register_error', 'Registration failed. Please try again.');
				redirect(base_url('page/register'));
			}
		} else {
			template('blank', 'register');
		}
	}

	public function logout() {
		$this->auth->remove_login_token();
		$this->session->sess_destroy();
		redirect(base_url());
	}

	public function is_email_exists_rule($email) {
		// Query the user model to check if the email exists
		$is_email_exists = $this->user->is_email_exists($email);

		// If email exists, return false and set a custom error message
		if ($is_email_exists) {
			$this->form_validation->set_message('is_email_exists_rule', 'The {field} already exists.');
			return false;
		}

		return true;
	}

	public function is_username_exists_rule($username) {
		// Query the user model to check if the username exists
		$is_username_exists = $this->user->is_username_exists($username);

		// If username exists, return false and set a custom error message
		if ($is_username_exists) {
			$this->form_validation->set_message('is_username_exists_rule', 'The {field} already exists.');
			return false;
		}

		return true;
	}
}
