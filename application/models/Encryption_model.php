<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Encryption_model extends CI_Model {

    // Generates a secure random token (32 characters long) using random bytes
    public function generate_token() {
        return bin2hex(random_bytes(16)); // Generates 16 random bytes and converts to hexadecimal
    }

    // Hashes the provided password using the PASSWORD_DEFAULT algorithm
    // PASSWORD_DEFAULT uses the current strongest available algorithm (e.g., bcrypt)
    public function generate_hash_password(string $password) {
        return password_hash($password, PASSWORD_DEFAULT); // Hashes the password securely
    }
}
