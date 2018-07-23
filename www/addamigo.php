<?php
/* Página de adicionar amigo - Bronzebook */

// Inclui a biblioteca de funções
include_once('funcoes.php');

// Conecta ao banco de dados
conectarBD();

// Obtém o nome do usuário
$usuario = stripslashes(@$_GET['id']);

// Adiciona como amigo
addAmigo($usuario);

// Desconecta do banco de dados
desconectarBD();

// Redireciona a página
header('Location: perfil.php?usuario='.$usuario);
?>
