<?php
/* Página de responder bronzice - Bronzebook */

// Inclui a biblioteca de funções
include_once('funcoes.php');

// Conecta ao banco de dados
conectarBD();

// Obtém os valores
$idbronzice	= stripslashes(@$_POST['idbronzice']);
$resposta	= stripslashes(@$_POST['resposta']);

// Adiciona a resposta
addResposta($idbronzice, obterID(), $resposta);

// Desconecta do banco de dados
desconectarBD();

// Redireciona a página
header('Location: verbronzice.php?id='.$idbronzice);
?>
