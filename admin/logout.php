<?php
// admin/logout.php
require_once '../config/functions.php';

session_unset();
session_destroy();
session_start();

set_flash_msg('success', 'Logged out successfully.');
redirect('index.php');
?>
