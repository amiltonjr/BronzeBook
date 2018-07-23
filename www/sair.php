<?php
/* Página de logout - Bronzebook */

// Inclui a biblioteca de funções
include_once('funcoes.php');

// Conecta ao banco de dados
conectarBD();

// Efetua o logout
Logout();

// Desconecta do banco de dados
desconectarBD();

// Redireciona a página
header('Location: index.php');
?>
