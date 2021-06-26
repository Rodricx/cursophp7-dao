<?php

require_once("config.php");

// $sql = new Sql();

// $usuarios = $sql->select("SELECT * FROM tb_usuario");

// echo json_encode($usuarios);


// Este retorna apenas   usuario
/*$root = new Usuario();

$root->loadById(2);

echo $root;*/

// Carrega uma lista de usuários
/*$lista = Usuario::getList();
echo json_encode($lista);*/


// Carrega uma lista de usuário buscando pelo login
/*$busca = Usuario::search("q");
echo json_encode($busca);*/



// Carrega usuário usando o login e a senha
/*$usuario = new Usuario();
$usuario->login("Henrique", "Pembele");
echo $usuario;*/



// INSERT EM DAO
/*
$aluno = new Usuario("aluno", "@lun0");
$aluno->setDesLogin("aluno");
$aluno->setDesSenha("@lun0");

$aluno->insert();

echo $aluno;
*/

$usuario = new Usuario();
$usuario->loadById(6);
$usuario->delete();

echo $usuario;


?>