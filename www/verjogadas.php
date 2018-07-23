<?php
/* Página de jogadas - Bronzebook */

// Inclui a biblioteca de funções
include_once('funcoes.php');

// O usuário deve estar logado para ter acesso a esta página
deveEstarLogado();

// Obtém as jogadas
$jogadas = obterJogadas(@$_GET['idequipe']);

// Imprime o cabeçalho
cabecalho('Jogadas - Equipe '.$equipe['nome']);
?>
  		<div class="content">
			<h1>Equipe <?=$equipe['nome'];?></h1>
			
			<div class="fltrt"><input type="button" value="Ver Bronzices" onclick="javascript:location.href='verequipe.php?id=<?=@$_GET['idequipe'];?>';" /></div>
			
			<p>
			<img src="img/pessoas.jpg" alt=""/> Jogadas da equipe</p>
			
			<div class="bronzices">
				<span class="bronziceT">Jogadas</span>
				
				<div class="fltrt"><input type="button" value="+ Adicionar nova jogada" onclick="javascript:location.href='addjogadas.php?idequipe=<?=$equipe['idequipe'];?>';" /></div>
				
				<?php foreach ( $jogadas as $jogada ) { ?>
				<br />
				
				<p>
					<strong><?=$jogada['titulo'];?> <a href="video.php?idjogada=<?=$jogada['idjogada'];?>">(Assistir vídeo)</a></strong>
					<br />
					Em <?=$jogada['dia'];?> às <?=$jogada['hora'];?>h - Participantes: 
					<?php
					$participantes = obterParticipantesJogada($jogada['idjogada']);
					$primeiro = $participantes[0];
					unset($participantes[0]);
					foreach ( $participantes as $participante ) {
					?>
					<a href="perfil.php?usuario=<?=$participante['apelido'];?>" style="text-decoration:underline;"><?=$participante['apelido'];?></a></strong>, 
					<?php } ?>
					<a href="perfil.php?usuario=<?=$primeiro['apelido'];?>" style="text-decoration:underline;"><?=$primeiro['apelido'];?></a></strong>
				</p>
				<?php } ?>
				
			</div>
			
  		</div>
	  
<?php
// Imprime o rodapé
rodape();
?>
