<?php
/* Página de pesquisa - Bronzebook */

// Inclui a biblioteca de funções
include_once('funcoes.php');

// O usuário deve estar logado para ter acesso a esta página
deveEstarLogado();

// Se recebeu dados do formulário para pesquisa
if ( isset($_POST['apelido']) && strlen($_POST['apelido']) > 0 )
	$resultados = pesquisarBronze(stripslashes($_POST['apelido']));
else
	$resultados = false;

// Imprime o cabeçalho
cabecalho('Pesquisar');
?>
  		<div class="content">
			<h1>Pesquisar usuário</h1>
			<form action="pesquisar.php" method="post">
				<p>
					<label><img src="img/pessoas.jpg" alt=""/> Nome ou apelido:
						<input type="text" name="apelido" value="<?=@$_POST['apelido'];?>" />
					</label>
					&nbsp;
					<input type="submit" value="Pesquisar" />
				</p>
			</form>
			<?php if ( is_array($resultados) ) { ?>
			<div>
				<h3>Resultados da pesquisa para "<?=$_POST['apelido'];?>"</h3>
				
				<p>
					<?php if ( !$resultados ) { ?>
					Nenhum resultado encontrado!
					<?php } else { foreach ( $resultados as $bronze ) { ?>
					<a href="perfil.php?usuario=<?=$bronze['apelido'];?>"><?=$bronze['apelido'];?></a><br />
					<?php } } ?>
					
				</p>
			</div>
			<?php } ?>
  		</div>
	  
<?php
// Imprime o rodapé
rodape();
?>
