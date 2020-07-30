<?php
require_once("config.php");

// Teste LoadById
$root = new Usuario();
$root->loadById(3);
echo "$root<br>";

// teste getAll
echo Usuario::getAll() . "<br>";

// Teste search
echo Usuario::search("joao") . "<br>";

// Teste login
$usuario = new Usuario();
$usuario->login("root", "102030");
echo "$usuario<br>";

// Teste insert
$insert = new Usuario("Aluno", "@luno");
$insert->insert();
echo "$insert<br>";

// Teste update
$update = new Usuario();
$update->loadById(6);
$update->update("maria", "5060100");
echo $update;