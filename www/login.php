<?php
/* Página de login - Bronzebook */

// Inclui a biblioteca de funções
include_once('funcoes.php');

// Inicia a flag de erro
$erro = false;

// Se recebeu dados do formulário para login
if ( isset($_POST['apelido']) )
{
	// Obtém os valores dos campos
	$apelido = $_SESSION['br_apelido'] = stripslashes(@$_POST['apelido']);
	$senha = stripslashes(@$_POST['senha']);
	
	// Tenta fazer o login
	if ( Login($apelido, $senha) )
	{
		unset($_SESSION['br_apelido']);
		
		header('Location: perfil.php');
		exit;
	}
	else
		$erro = true;
}

// Imprime o cabeçalho
cabecalho('Login');
?>  
  		<div class="content">
			<h1>Login de bronze</h1>
			<?php
			if ( $erro )
			{
			?>
			<h3 class="erro">Não foi possível efetuar o login! Tente novamente.</h3>
			<?php
			}
			?>
			<form action="login.php" method="post">
				<p>
					<label><img src="img/add.jpg" alt=""/> Apelido:
						<input type="text" name="apelido" value="<?=@$_SESSION['br_apelido'];?>" />
					</label>
				<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label>Senha:&nbsp;&nbsp;
						<input type="password" name="senha" />
					</label>
				</p>
				<p>
					<input type="submit" value="Login" />
					&nbsp;&nbsp;
					<input type="button" value="Cancelar" onclick="javascript:location.href='index.php';" />
				</p>
			</form>
			<h2 align="center">&nbsp;</h2>
  		</div>
	  
<?php
// Imprime o rodapé
rodape();
?>
