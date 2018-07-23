<?php
/* Página de ver bronzice - Bronzebook */

// Inclui a biblioteca de funções
include_once('funcoes.php');

// O usuário deve estar logado para ter acesso a esta página
deveEstarLogado();

// Obtém os dados da bronzice
$bronzice = obterDadosBronzice(@$_GET['id']);
$equipe = obterEquipe($bronzice['idequipe']);
$autor = obterDadosPerfilID($bronzice['idbronze']);
$respostas = obterRespostas($bronzice['idpost']);
$idbronze = obterID();
$idbronzice = $bronzice['idpost'];

// Imprime o cabeçalho
cabecalho($bronzice['assunto']);
?>
  		<div class="content">
			<h1>Equipe <?=$equipe['nome'];?></h1>
			
			<p>
				<img src="img/pessoas.jpg" alt=""/> 
				<strong><big><?=$bronzice['assunto'];?></big></strong>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<?=$bronzice['curtidas'];?> curtiram
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<?php if ( Curtiu($idbronzice, $idbronze) ) { ?>
				<a href="curtir.php?id=<?=$idbronzice;?>"><img src="img/curtir.jpg" alt=""/> Curtir (desfazer)</a>
				<?php } else { ?>
				<a href="curtir.php?id=<?=$idbronzice;?>"><img src="img/curtir.jpg" alt=""/> Curtir</a>
				<?php } ?>
			</p>
			
			<p>
				<big><?=$bronzice['texto'];?></big>
				<br />
				<small><a href="perfil.php?usuario=<?=$autor['apelido'];?>"><?=$autor['apelido'];?></a> - <?=$bronzice['dia'];?> - <?=$bronzice['hora'];?>h</small>
			</p>
			
			<?php foreach ( $respostas as $resposta ) { ?>
			<p>
				<big><?=$resposta['texto'];?></big>
				<br />
				<small><a href="perfil.phpusuario=<?=obterApelido($resposta['idbronze']);?>"><?=obterApelido($resposta['idbronze']);?></a> - <?=$resposta['dia'];?> - <?=$resposta['hora'];?>h</small>
			</p>
			<?php } ?>
			
			<form action="respbronzice.php" method="post">
				<input type="hidden" name="idbronzice" value="<?=$idbronzice;?>" />
				<p><textarea name="resposta" cols="100" rows="5"></textarea></p>
				<p>
					<input type="submit" value="Responder" />
					&nbsp;&nbsp;
					<input type="button" value="Voltar" onclick="javascript:location.href='verequipe.php?id=<?=$equipe['idequipe'];?>';" />
				</p>
			</form>
			
  		</div>
	  
<?php
// Imprime o rodapé
rodape();
?>
