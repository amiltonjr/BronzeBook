<?php
/* Página de login - Bronzebook */

// Inclui a biblioteca de funções
include_once('funcoes.php');

// O usuário deve estar logado para ter acesso a esta página
deveEstarLogado();

// Se recebeu dados do formulário para remover amigo
if ( isset($_POST['remover']) )
{
	$nomes = '';
	
	// Remove os amigos
	foreach ( $_POST['remover'] as $pessoa )
	{
		$nomes .= $pessoa.', ';
		removerAmigo($pessoa);
	}
	
	// Exibe um alerta
	echo '<script type="text/javascript"> alert("Amigo(s) '.$nomes.'foram removido(s)!"); </script>';
}

$amigos = obterAmigos($usuario);

// Imprime o cabeçalho
cabecalho('Meus Amigos');
?>
  		<div class="content">
  			<form action="amigos.php" method="post">
			<p>
				<img src="img/pessoas.jpg" alt=""/> Meus amigos
			</p>
				
				<p>
					<?php if ( $amigos['quantos'] == 0 ) { ?>
					Você ainda não tem nenhum amigo!
					<?php } ?>
					
					<?php unset($amigos['quantos']); ?>
					
					<?php foreach ( $amigos as $amigo ) { ?>
					<label><input type="checkbox" name="remover[]" value="<?=$amigo['apelido'];?>"> <a href="perfil.php?usuario=<?=$amigo['apelido'];?>"><?=$amigo['apelido'];?></a></label><br />
					<?php } ?>
				</p>
				
				<p>
					<input type="button" value="Voltar" onclick="javascript:location.href='index.php';" />
					&nbsp;&nbsp;
					<input type="submit" value="Desfazer amizade" />
				</p>
			</form>
  		</div>
	  
<?php
// Imprime o rodapé
rodape();
?>
