<?php
/* Página de remover amigo - Bronzebook */

// Inclui a biblioteca de funções
include_once('funcoes.php');

// Conecta ao banco de dados
conectarBD();

// Obtém o nome do usuário
$usuario = stripslashes(@$_GET['id']);

// Remove como amigo
removerAmigo($usuario);

// Desconecta do banco de dados
desconectarBD();

// Redireciona a página
header('Location: perfil.php?usuario='.$usuario);
?>
