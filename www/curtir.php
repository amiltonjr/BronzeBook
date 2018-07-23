<?php
/* Página de curtir - Bronzebook */

// Inclui a biblioteca de funções
include_once('funcoes.php');

// Conecta ao banco de dados
conectarBD();

// Obtém os valores
$idbronzice	= stripslashes(@$_GET['id']);
$idbronze	= obterID();

// Chama a função para alterar o estado de curtir
toggleCurtir($idbronzice, $idbronze);

// Desconecta do banco de dados
desconectarBD();

// Redireciona a página
header('Location: verbronzice.php?id='.$idbronzice);
?>
