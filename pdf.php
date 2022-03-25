<?php

require_once 'connectionFactory.php';
require_once 'pdf_builder.php';
$mysqli= ConnectionFactory::GetConnection();
$code =  $_POST['code'];
 getPDF($code, $mysqli, false);
?>
