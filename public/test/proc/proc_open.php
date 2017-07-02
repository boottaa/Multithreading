<?php

error_reporting(E_ALL);
require_once "Multithreading.php";

$pro = new Multithreading();

$pro->run("php comander.php", "comander", true);




?>