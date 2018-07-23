<?php
/* Página de vídeo - Bronzebook */

// Inclui a biblioteca de funções
include_once('funcoes.php');

// O usuário deve estar logado para ter acesso a esta página
deveEstarLogado();

// Obtém os dados
$jogada = obterJogada(@$_GET['idjogada']);
$equipe = obterEquipe($jogada['idequipe']);

// Imprime o cabeçalho
cabecalho('Vídeo - '.$jogada['titulo']);
?>
  		<div class="content">
			<h1>Equipe <?=$equipe['nome'];?></h1>
			
			<p>
			<img src="img/pessoas.jpg" alt=""/> <strong><?=$jogada['titulo'];?></strong>
			<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Em <?=$jogada['dia'];?> às <?=$jogada['hora'];?>h - Participantes: 
			<?php
			$participantes = obterParticipantesJogada($jogada['idjogada']);
			$primeiro = $participantes[0];
			unset($participantes[0]);
			foreach ( $participantes as $participante ) {
			?>
			<a href="perfil.php?usuario=<?=$participante['apelido'];?>"><?=$participante['apelido'];?></a></strong>, 
			<?php } ?>
			<a href="perfil.php?usuario=<?=$primeiro['apelido'];?>"><?=$primeiro['apelido'];?></a></strong>
			</p>
			
			<p align="center">
				<iframe width="560" height="315" src="https://www.youtube.com/embed/<?=$jogada['idvideo'];?>" frameborder="0" allowfullscreen></iframe>
			</p>
			
			<input type="button" value="Voltar" onclick="javascript:location.href='verjogadas.php?idequipe=<?=$jogada['idequipe'];?>';" />
			
  		</div>
	  
<?php
// Imprime o rodapé
rodape();
?>
