<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once 'autoload.php';

/**
 * Run the app, buddy.
 *
 * @author brslv
 */
new Nanozen\App\Boot;