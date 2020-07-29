<?php
require_once("config.php");

$dsn = "mysql:host=localhost;dbname=php7db";
$user = "root";

$sql = new Sql($dsn, $user, "");

$usuarios = $sql->select("SELECT * FROM tb_usuarios;");

echo json_encode($usuarios);