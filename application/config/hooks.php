<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/userguide3/general/hooks.html
|
*/

$hook['pre_system'][] = array(
    'class'    => 'DatabaseHook',
    'function' => 'generate_database',
    'filename' => 'DatabaseHook.php',
    'filepath' => 'hooks',
);

$hook['post_controller_constructor'][] = array(
    'class'    => 'DatabaseHook',
    'function' => 'generate_tables',
    'filename' => 'DatabaseHook.php',
    'filepath' => 'hooks'
);