<?php
session_name('TodoApp');
session_start();

const DEBUG = true;

if(DEBUG) {
    error_reporting(E_ALL);
} else {
    error_reporting(false);
}
ini_set('display_errors', DEBUG);

require_once('class/TodoApp.php');
new TodoApp();
