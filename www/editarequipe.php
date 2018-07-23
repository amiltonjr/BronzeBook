<?php
/* Página de editar equipe - Bronzebook */

// Inclui a biblioteca de funções
include_once('funcoes.php');

// O usuário deve estar logado para ter acesso a esta página
deveEstarLogado();

// Obtém a equipe
$idequipe = @$_GET['id'];
$equipe = obterEquipe($idequipe);
$participantes = obterParticipantes($idequipe);
$lider = $participantes['lider'];
unset($participantes['lider']);
$amigos = obterAmigosExceto($participantes);

// Se recebeu dados do formulário para criar
if ( isset($_POST['nome']) && strlen($_POST['nome']) > 2 )
{
	$nome		= stripslashes($_POST['nome']);
	$adicionar	= $_POST['adicionar'];
	$remover	= $_POST['remover'];
	
	// Atualiza o nome da equipe
	atualizarEquipe($nome, $idequipe);
	
	// Adiciona as pessoas à equipe
	if ( is_array($adicionar) && count($adicionar) > 0 )
		foreach ( $adicionar as $bronze )
			addEquipe($bronze, $idequipe);
	
	// Remove as pessoas da equipe
	if ( is_array($remover) && count($remover) > 0 )
		foreach ( $remover as $bronze )
			removerEquipe($bronze, $idequipe);
	
	// Exibe um alerta e redireciona a página
	echo '<script type="text/javascript"> alert("Equipe atualizada com sucesso!"); location.href="verequipe.php?id='.@$_GET['id'].'"; </script>';
	// Encerra a execução
	exit;
}

// Imprime o cabeçalho
cabecalho('Editar Equipe');
?>
  		<div class="content">
			<h1>Editar Equipe</h1>
			<form action="editarequipe.php?id=<?=$idequipe;?>" method="post">
				<p>
					<label><img src="img/pessoas.jpg" alt=""/> Nome:
						<input name="nome" type="text" size="30" value="<?=$equipe['nome'];?>" />
					</label>
				</p>
				
				<table width="80%" border="0" align="center">
					<tr>
						<td>
							<p><strong>Participantes:</strong></p>
							
							<p>
								<?php if ( numParticipantes($equipe['idequipe']) == 1 ) { ?>
								Sem participantes ainda.
								<?php } else { foreach ( $participantes as $participante ) { ?>
								<a href="perfil.php?usuario=<?=$participante;?>"><?=$participante;?></a> <label><input type="checkbox" name="remover[]" value="<?=$participante;?>"> Remover da Equipe</label><br />
								<?php } } ?>
									
							</p>
						</td>
						<td>
							<?php if ( $amigos['quantos'] > 0 ) { ?>
							<p><strong>Adicionar amigos à Equipe:</strong></p>
							<?php unset($amigos['quantos']); ?>	
							<p>
								<?php foreach ( $amigos as $amigo ) { ?>
								<a href="perfil.php?usuario=<?=$amigo['apelido'];?>"><?=$amigo['apelido'];?></a> <label><input type="checkbox" name="adicionar[]" value="<?=$amigo['apelido'];?>"> Adicionar à Equipe</label><br />
								<?php } ?>
							</p>
							<?php } ?>
						</td>
					</tr>
				</table>
				
				<p>
					<input type="submit" value="Salvar" />
					&nbsp;&nbsp;
					<input type="button" value="Cancelar" onclick="javascript:location.href='equipe.php';" />
				</p>
			</form>
  		</div>
	  
<?php
// Imprime o rodapé
rodape();
?>
