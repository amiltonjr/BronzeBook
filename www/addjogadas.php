<?php
/* Página de adicionar jogada - Bronzebook */

// Inclui a biblioteca de funções
include_once('funcoes.php');

// O usuário deve estar logado para ter acesso a esta página
deveEstarLogado();

// Obtém a equipe
$equipe = obterEquipe(@$_GET['idequipe']);
$participantes = obterParticipantes($equipe['idequipe']);
$lider = $participantes['lider'];
unset($participantes['lider']);

// Flag para erros
$erro = false;

// Se recebeu dados do formulário para criar
if ( isset($_POST['titulo']) && strlen($_POST['titulo']) > 2 )
{
	$titulo		= $_SESSION['br_titulo']	=	stripslashes($_POST['titulo']);
	$video		= $_SESSION['br_video']		=	stripslashes($_POST['video']);
	$dia		= $_SESSION['br_dia']		=	stripslashes($_POST['dia']);
	$mes		= $_SESSION['br_mes']		=	stripslashes($_POST['mes']);
	$ano		= $_SESSION['br_ano']		=	stripslashes($_POST['ano']);
	$hora		= $_SESSION['br_hora']		=	stripslashes($_POST['hora']);
	$minuto		= $_SESSION['br_minuto']	=	stripslashes($_POST['minuto']);
	$jogadores								=	$_POST['jogadores'];
	
	// Formata a data e hora
	$dataF = $dia.'/'.$mes.'/'.$ano;
	$horaF = $hora.':'.$minuto;
	
	// Tenta adicionar a jogada
	if ( addJogada($equipe['idequipe'], $titulo, $video, $dataF, $horaF, $jogadores) )
	{
		unset($_SESSION['br_titulo'], $_SESSION['br_video'], $_SESSION['br_dia'], $_SESSION['br_mes'], $_SESSION['br_ano'], $_SESSION['br_hora'], $_SESSION['br_minuto']);
		
		// Redireciona a página
		header('Location: verjogadas.php?idequipe='.$equipe['idequipe']);
		// Encerra a execução
		exit;
	}
	else
		$erro = true;
}

// Imprime o cabeçalho
cabecalho('Adicionar Jogada');
?>
  		<div class="content">
			<h1>Equipe <?=$equipe['nome'];?></h1>
			
			<?php
			if ( $erro )
			{
			?>
			<h3 class="erro">Não foi possível adicionar esta jogada! Tente novamente.</h3>
			<?php
			}
			?>
			
			<form action="addjogadas.php?idequipe=<?=$equipe['idequipe'];?>" method="post">
			<p>
				<img src="img/pessoas.jpg" alt=""/> 
				<label>
				Titulo: 
				<input name="titulo" type="text" size="60" value="<?=@$_SESSION['br_titulo'];?>" />
				</label>
				
				<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				
				<label>
				Link do vídeo no YouTube: 
				<input name="video" type="text" size="42" value="<?=@$_SESSION['br_video'];?>" />
				</label>
				
				<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				
				<label>
				Data: 
				<select name="dia">
					<?php if ( isset($_SESSION['br_dia']) ) { ?>
					<option value="<?=$_SESSION['br_dia'];?>" selected="selected"><?=$_SESSION['br_dia'];?></option>
					<?php } ?>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
					<option value="13">13</option>
					<option value="14">14</option>
					<option value="15">15</option>
					<option value="16">16</option>
					<option value="17">17</option>
					<option value="18">18</option>
					<option value="19">19</option>
					<option value="20">20</option>
					<option value="21">21</option>
					<option value="22">22</option>
					<option value="23">23</option>
					<option value="24">24</option>
					<option value="25">25</option>
					<option value="26">26</option>
					<option value="27">27</option>
					<option value="28">28</option>
					<option value="29">29</option>
					<option value="30">30</option>
					<option value="31">31</option>
				</select>
				/
				<select name="mes">
					<?php if ( isset($_SESSION['br_mes']) ) { ?>
					<option value="<?=$_SESSION['br_mes'];?>" selected="selected"><?=$_SESSION['br_mes'];?></option>
					<?php } ?>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
				</select>
				/
				<select name="ano">
					<?php if ( isset($_SESSION['br_ano']) ) { ?>
					<option value="<?=$_SESSION['br_ano'];?>" selected="selected"><?=$_SESSION['br_ano'];?></option>
					<?php } ?>
					<option value="2015">2015</option>
					<option value="2014">2014</option>
					<option value="2013">2013</option>
					<option value="2012">2012</option>
					<option value="2011">2011</option>
					<option value="2010">2010</option>
					<option value="2009">2009</option>
					<option value="2008">2008</option>
					<option value="2007">2007</option>
					<option value="2006">2006</option>
					<option value="2005">2005</option>
					<option value="2004">2004</option>
					<option value="2003">2003</option>
					<option value="2002">2002</option>
					<option value="2001">2001</option>
					<option value="2000">2000</option>
				</select>
				<img src="img/calendario.jpg" />
				</label>
				
				&nbsp;&nbsp;&nbsp;&nbsp;
				
				<label>
				Hora:
				<select name="hora">
						<?php if ( isset($_SESSION['br_hora']) ) { ?>
						<option value="<?=$_SESSION['br_hora'];?>" selected="selected"><?=$_SESSION['br_hora'];?></option>
						<?php } ?>
						<option value="00">00</option>
						<option value="01">01</option>
						<option value="02">02</option>
						<option value="03">03</option>
						<option value="04">04</option>
						<option value="05">05</option>
						<option value="06">06</option>
						<option value="07">07</option>
						<option value="08">08</option>
						<option value="09">09</option>
						<option value="10">10</option>
						<option value="11">11</option>
						<option value="12">12</option>
						<option value="13">13</option>
						<option value="14">14</option>
						<option value="15">15</option>
						<option value="16">16</option>
						<option value="17">17</option>
						<option value="18">18</option>
						<option value="19">19</option>
						<option value="20">20</option>
						<option value="21">21</option>
						<option value="22">22</option>
						<option value="23">23</option>
					</select>
					:
					<select name="minuto">
						<?php if ( isset($_SESSION['br_minuto']) ) { ?>
						<option value="<?=$_SESSION['br_minuto'];?>" selected="selected"><?=$_SESSION['br_minuto'];?></option>
						<?php } ?>
						<option value="00">00</option>
						<option value="15">15</option>
						<option value="30">30</option>
						<option value="45">45</option>
					</select>
					h
				</label>
				
				<br /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				
				<strong>Participante(s):</strong><br />
				
				<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label><input type="checkbox" name="jogadores[]" value="<?=$lider;?>"> <?=$lider;?></label>
				
				<?php foreach ( $participantes as $participante ) { ?>
				<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label><input type="checkbox" name="jogadores[]" value="<?=$participante;?>"> <?=$participante;?></label>
				<?php } ?>
			</p>
			
			<p>
					<input type="submit" value="Adicionar" />
					&nbsp;&nbsp;
					<input type="button" value="Cancelar" onclick="javascript:location.href='verjogadas.php?idequipe=<?=$equipe['idequipe'];?>';" />
				</p>
			
			</form>
			
  		</div>
	  
<?php
// Imprime o rodapé
rodape();
?>
