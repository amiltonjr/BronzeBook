<?php
/* Página inicial - Bronzebook */

// Inclui a biblioteca de funções
include_once('funcoes.php');

// Se estiver logado, redireciona para o perfil
if ( estaLogado() )
{
	header('Location: perfil.php');
	exit;
}

// Imprime o cabeçalho
cabecalho();
?>  
  		<div class="content">
			<h2 align="center">&nbsp;</h2>
			<h2 align="center">Bem-vindo(a) à rede social Bronzebook!</h2>
			<p align="center">&nbsp;</p>
			<p align="center"><input type="button" value="Login" onclick="javascript:location.href='login.php';" />&nbsp;&nbsp;<input type="button" value="Cadastro" onclick="javascript:location.href='cadastro.php';" /></p>
		</div>
	  
<?php
// Imprime o rodapé
rodape();
?>
