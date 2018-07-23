<?php
/* Página de adicionar nova bronzice - Bronzebook */

// Inclui a biblioteca de funções
include_once('funcoes.php');

// O usuário deve estar logado para ter acesso a esta página
deveEstarLogado();

// Obtém a equipe
$equipe = obterEquipe(@$_GET['idequipe']);
$participantes = obterParticipantes(@$_GET['id']);
$lider = $participantes['lider'];
unset($participantes['lider']);

// Flag para erros
$erro = false;

// Se recebeu dados do formulário para criar
if ( isset($_POST['titulo']) && strlen($_POST['titulo']) > 2 )
{
	$titulo		= stripslashes($_POST['titulo']);
	$descricao	= stripslashes($_POST['descricao']);
	
	// Tenta adicionar a bronzice
	if ( addBronzice($equipe['idequipe'], obterID(), $titulo, $descricao) )
	{
		// Redireciona a página
		header('Location: verequipe.php?id='.$_POST['idequipe']);
		// Encerra a execução
		exit;
	}
	else
		$erro = true;
}

// Imprime o cabeçalho
cabecalho('Adicionar nova Bronzice');
?>
  		<div class="content">
			<h1>Equipe <?=$equipe['nome'];?></h1>
			
			<?php
			if ( $erro )
			{
			?>
			<h3 class="erro">Não foi possível adicionar esta bronzice! Tente novamente.</h3>
			<?php
			}
			?>
			
			<h3><img src="img/pessoas.jpg" alt=""/> Adicionar nova bronzice</h3>
			
			<form action="addbronzice.php?idequipe=<?=$equipe['idequipe'];?>" method="post">
			<p>
				<input type="hidden" name="idequipe" value="<?=$equipe['idequipe'];?>" />
				<label>
				Titulo: 
				<input name="titulo" type="text" size="60" />
				</label>
				
				<br />
				
				<label>
				Descrição:&nbsp;&nbsp;&nbsp;(até 200 caracteres)<br />
				<textarea name="descricao" cols="68" rows="5"></textarea>
				</label>
				
				<p>
					<input type="submit" value="Adicionar" />
					&nbsp;&nbsp;
					<input type="button" value="Cancelar" onclick="javascript:location.href='verequipe.php?id=<?=$equipe['idequipe'];?>';" />
				</p>
			
			</form>
			
  		</div>
	  
<?php
// Imprime o rodapé
rodape();
?>

