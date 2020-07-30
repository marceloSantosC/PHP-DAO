<?php
require_once("config.php");

$root = new Usuario();

$root->loadById(3);

echo "$root<br>";

echo Usuario::getAll() . "<br>";

echo Usuario::search("joao") . "<br>";

$usuario = new Usuario();
$usuario->login("root", "102030");
echo "$usuario<br>";

$insert = new Usuario("Aluno", "@luno");
$insert->insert();
echo $insert;

