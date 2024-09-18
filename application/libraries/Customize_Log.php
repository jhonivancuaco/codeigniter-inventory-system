<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customize_Log extends CI_Log {

    // Custom log levels - adding level 5 for CUSTOM log messages
    protected $_levels = array('ERROR' => '1', 'DEBUG' => '2', 'INFO' => '3', 'ALL' => '4', 'DB' => '5');

    /**
     * Custom log method for custom log levels
     *
     * @param string $message
     * @param string $level
     * @return bool
     */
    public function custom_log($message, $level = 'DB') {
        $level = strtoupper($level);

        // If the level exists, log the message
        if (isset($this->_levels[$level])) {
            return $this->write_log($level, $message);
        }

        // If the level doesn't exist, fallback to default logging
        return $this->write_log('DB', $message);
    }
}
