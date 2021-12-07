<?php

include 'connectionFactory.php';
include 'pdf_builder.php';
$mysqli= ConnectionFactory::GetConnection();
$code =  $_POST['code'];
 getPDF($code, $mysqli, false);
?>
