<?php
/* Cabeçalho das páginas - Bronzebook */

// Inclui a biblioteca de funções
include_once('funcoes.php');

// Conecta ao banco de dados
conectarBD();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=$titulo;?></title>
<link rel="stylesheet" href="css/geral.css" type="text/css" media="all" />
</head>

<body>

	<div class="container">
  
  		<div class="header">
  			<h1><a href="index.php">Bronzebook</a></h1>
			
			<?php
			// Se o usuário estiver logado
			if ( estaLogado() )
			{
			?>
			<div class="menu">
				<div class="fltlft">
					<input type="button" value="Início" onclick="javascript:location.href='index.php';" /> <input type="button" value="Perfil" onclick="javascript:location.href='perfil.php';" /> <input type="button" value="Amigos" onclick="javascript:location.href='amigos.php';" /> <input type="button" value="Equipe" onclick="javascript:location.href='equipe.php';" /> <input type="button" value="Pesquisar" onclick="javascript:location.href='pesquisar.php';" />
				</div>
				<div class="fltrt">
					Logado(a) como <?=obterApelido();?> <input type="button" value="Sair" onclick="javascript:location.href='sair.php';" />
				</div>
			</div>
			<?php
			}
			?>
  		</div>