<?php
/* Página de ver equipe - Bronzebook */

// Inclui a biblioteca de funções
include_once('funcoes.php');

// O usuário deve estar logado para ter acesso a esta página
deveEstarLogado();

// Obtém a equipe
$equipe = obterEquipe(@$_GET['id']);
$participantes = obterParticipantes(@$_GET['id']);
$lider = $participantes['lider'];
unset($participantes['lider']);
// Obtém as bronzices
$bronzices = obterBronzices(@$_GET['id']);

// Imprime o cabeçalho
cabecalho('Equipe '.$equipe['nome']);
?>
  		<div class="content">
			<h1>Equipe <?=$equipe['nome'];?></h1>
			
			<div class="fltrt"><input type="button" value="Ver Jogadas" onclick="javascript:location.href='verjogadas.php?idequipe=<?=$equipe['idequipe'];?>';" /></div>
			
			<p>
				<img src="img/pessoas.jpg" alt=""/> 
				Participantes: <strong><a href="perfil.php?usuario=<?=$lider;?>"><?=$lider;?></a></strong>
				<?php foreach ( $participantes as $participante ) { ?>
				, <a href="perfil.php?usuario=<?=$participante;?>"><?=$participante;?></a>
				<?php } ?>
			</p>
			
			<div class="bronzices">
				<span class="bronziceT">Bronzices</span>
				
				<div class="fltrt"><input type="button" value="+ Adicionar nova bronzice" onclick="javascript:location.href='addbronzice.php?idequipe=<?=$equipe['idequipe'];?>';" /></div>
				
				<br />
				
				<?php foreach ( $bronzices as $bronzice ) { ?>
				<p>
					<a href="verbronzice.php?id=<?=$bronzice['idpost'];?>">
					<strong><?=$bronzice['assunto'];?></strong>
					<br />
					<?=$bronzice['curtidas'];?> curtiram - <?=$bronzice['respostas'];?> resposta(s) - Última resposta: <?=$bronzice['dia'];?> - <?=$bronzice['hora'];?>h
					</a>
				</p>
				
				<br />
				<?php } ?>
				
			</div>
			
  		</div>
	  
<?php
// Imprime o rodapé
rodape();
?>
