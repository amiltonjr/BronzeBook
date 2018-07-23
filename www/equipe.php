<?php
/* Página de equipe - Bronzebook */

// Inclui a biblioteca de funções
include_once('funcoes.php');

// O usuário deve estar logado para ter acesso a esta página
deveEstarLogado();

// Obtém a equipe que o usuário é dono
$equipe = obterEquipe();
// Obtém a equipe que o usuário só participa
$equipeParticipa = obterEquipeParticipa();

// Imprime o cabeçalho
cabecalho('Equipe');
?>
  		<div class="content">
			<h1>Minha equipe</h1>
			
			<?php if ( !$equipe && !$equipeParticipa ) { ?>
			<p>Você ainda não é dono de nenhuma equipe.</p>
			<p><input type="button" value="Criar Nova" onclick="javascript:location.href='novaequipe.php';" /></p>
			<?php } else if ( !$equipe && is_array($equipeParticipa) ) { ?>
				<img src="img/pessoas.jpg" alt=""/> <?=$equipeParticipa['nome'];?> - <?=numParticipantes($equipeParticipa['idequipe']);?> participante(s)
				<input type="button" value="Ver" onclick="javascript:location.href='verequipe.php?id=<?=$equipeParticipa['idequipe'];?>';" />
			<?php } else { ?>
			<p>
				<img src="img/pessoas.jpg" alt=""/> <?=$equipe['nome'];?> - <?=numParticipantes($equipe['idequipe']);?> participante(s)
				<input type="button" value="Ver" onclick="javascript:location.href='verequipe.php?id=<?=$equipe['idequipe'];?>';" />
				<input type="button" value="Editar" onclick="javascript:location.href='editarequipe.php?id=<?=$equipe['idequipe'];?>';" />
			</p>
			<?php } ?>
			
  		</div>
	  
<?php
// Imprime o rodapé
rodape();
?>
