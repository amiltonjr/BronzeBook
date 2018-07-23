<?php
/* Página de login - Bronzebook */

// Inclui a biblioteca de funções
include_once('funcoes.php');

// O usuário deve estar logado para ter acesso a esta página
deveEstarLogado();

// Se é outro perfil
if ( isset($_GET['usuario']) )
	$usuario = stripslashes($_GET['usuario']);
else
	$usuario = obterApelido();

// Obtém os vetores de dados
$dados = obterDadosPerfil($usuario);
$amigos = obterAmigos($usuario);
if ( $dados['idequipe'] == NULL )
	$dados['idequipe'] = false;
$dadosequipe = obterEquipe($dados['idequipe']);
$equipe = obterParticipantes($dados['idequipe']);
$lider = $equipe['lider'];
unset($equipe['lider']);

// Imprime o cabeçalho
cabecalho('Perfil de '.$dados['apelido']);
?>
  		<div class="content">
			<h1>Perfil de <?=$dados['apelido'];?>
			<?php
			// Se o usuário for dono do perfil atual
			if ( obterApelido() == $dados['apelido'] )
			{
			?>
				&nbsp;&nbsp;<input type="button" value="Editar" onclick="javascript:location.href='editarperfil.php';" />
			<?php
			}
			?>
			</h1>
			
			<div class="fltrt" style="margin-right:10px;">
				<h3>Amigos</h3>
				
				<p>
				<?php if ( $amigos['quantos'] == 0 ) { ?>
					Nenhum amigo!
				<?php } ?>
					
				<?php unset($amigos['quantos']); ?>
				
				<?php foreach ( $amigos as $amigo ) { ?>
				<a href="perfil.php?usuario=<?=$amigo['apelido'];?>"><?=$amigo['apelido'];?></a><br />
				<?php } ?>
				</p>
			</div>
			
			<p>
				<img src="img/relogio.jpg" alt=""/> <strong>Disponibilidade para jogar (dia e horário):</strong>
					<?=$dados['diasemana'];?> das <?=$dados['deh'];?>:<?=$dados['dem'];?>h às <?=$dados['ateh'];?>:<?=$dados['atem'];?>h
			</p>
			<p>
				<img src="img/arquivo.jpg" alt=""/> <strong>Descrição:</strong>
					<?=$dados['descricao'];?>
			</p>
			<p>
				<img src="img/pessoa.jpg" alt=""/> <strong>Humor:</strong>
				<img src="img/<?=$dados['humor'];?>.jpg" alt=""/> <?=ucfirst($dados['humor']);?>
			</p>
			<p>
				<img src="img/pessoas.jpg" alt=""/> <strong>Equipe:</strong>
					&nbsp;&nbsp;
					
					<i><a href="verequipe.php?id=<?=$dadosequipe['idequipe'];?>"><?=$dadosequipe['nome'];?></a></i> - <strong><a href="perfil.php?usuario=<?=$lider;?>"><?=$lider;?></a></strong>
				<?php foreach ( $equipe as $participante ) { ?>
				, <a href="perfil.php?usuario=<?=$participante;?>"><?=$participante;?></a>
				<?php } ?>
			</p>
			<?php
			// Se o usuário Não for dono do perfil atual
			if ( obterApelido() != $dados['apelido'] )
			{
				// Se não forem amigos
				if ( !saoAmigos(obterApelido(), $dados['apelido']) )
				{
			?>
					<p><input type="button" value="+ Adicionar amigo" onclick="javascript:location.href='addamigo.php?id=<?=$dados['apelido'];?>';" /></p>
			<?php
				} else {
			?>
					<p><input type="button" value="- Desfazer amizade" onclick="javascript:location.href='removeramigo.php?id=<?=$dados['apelido'];?>';" /></p>
			<?php
				}
			}
			?>
		</div>
	  
<?php
// Imprime o rodapé
rodape();
?>
