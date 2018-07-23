<?php
/* Página de nova equipe - Bronzebook */

// Inclui a biblioteca de funções
include_once('funcoes.php');

// O usuário deve estar logado para ter acesso a esta página
deveEstarLogado();

$amigos = obterAmigos($usuario);

// Se recebeu dados do formulário para criar
if ( isset($_POST['nome']) && strlen($_POST['nome']) > 2 )
{
	$nome		= stripslashes($_POST['nome']);
	$adicionar	= $_POST['adicionar'];
	
	// Tenta efetuar o cadastro
	if ( cadastrarEquipe($nome, $adicionar) )
	{
		// Exibe um alerta e redireciona a página
		echo '<script type="text/javascript"> alert("Equipe criada com sucesso!"); location.href="equipe.php"; </script>';
		// Encerra a execução
		exit;
	}
}

// Imprime o cabeçalho
cabecalho('Criar uma nova Equipe');
?>
  		<div class="content">
			<h1>Criar uma Equipe</h1>
			<form action="novaequipe.php" method="post">
				<p>
					<label><img src="img/pessoas.jpg" alt=""/> Nome:
						<input name="nome" type="text" size="30" value="<?=@$_POST['nome'];?>" />
					</label>
				</p>
				
				<?php if ( $amigos['quantos'] > 0 ) { ?>
				<p><strong>Adicionar amigos à Equipe:</strong></p>
				<?php unset($amigos['quantos']); ?>	
				<p>
					<?php foreach ( $amigos as $amigo ) { ?>
					<a href="perfil.php?usuario=<?=$amigo['apelido'];?>"><?=$amigo['apelido'];?></a> <label><input type="checkbox" name="adicionar[]" value="<?=$amigo['apelido'];?>"> Adicionar à Equipe</label><br />
					<?php } ?>
				</p>
				<?php } ?>
				
				<p>
					<input type="submit" value="Criar" />
					&nbsp;&nbsp;
					<input type="button" value="Cancelar" onclick="javascript:location.href='equipe.php';" />
				</p>
			</form>
  		</div>
	  
<?php
// Imprime o rodapé
rodape();
?>
