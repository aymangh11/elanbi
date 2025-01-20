<?php 
session_start();

session_unset();
session_destroy();

header("Location: 1234567890.php");