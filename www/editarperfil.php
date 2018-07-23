<?php
/* Página de editar perfil - Bronzebook */

// Inclui a biblioteca de funções
include_once('funcoes.php');

// O usuário deve estar logado para ter acesso a esta página
deveEstarLogado();

// Obtém o vetor de dados
$dados = obterDadosPerfil();

// Inicia a flag de erro
$erro = false;

// Se recebeu dados do formulário para atualizar
if ( isset($_POST['senha']) )
{
	// Obtém os valores dos campos
	$senha		= $_SESSION['br_senha']		= stripslashes(@$_POST['senha']);
	$dispDia	= $_SESSION['br_dispDia']	= stripslashes(@$_POST['disponibilidade']);
	$dispdH		= $_SESSION['br_dispdH']	= stripslashes(@$_POST['dasH']);
	$dispdM		= $_SESSION['br_dispdM']	= stripslashes(@$_POST['dasM']);
	$dispaH		= $_SESSION['br_dispaH']	= stripslashes(@$_POST['asH']);
	$dispaM		= $_SESSION['br_dispaM']	= stripslashes(@$_POST['asM']);
	$descricao	= $_SESSION['br_descricao']	= stripslashes(@$_POST['descricao']);
	$humor		= $_SESSION['br_humor']		= stripslashes(@$_POST['humor']);
	
	// Se foi atualizado
	if ( atualizarBronze(obterID($apelido), $apelido, $senha, $dispDia, $dispdH, $dispdM, $dispaH, $dispaM, $descricao, $humor) )
	{
		unset($_SESSION['br_senha'], $_SESSION['br_dispDia'], $_SESSION['br_dispdH'], $_SESSION['br_dispdM'], $_SESSION['br_dispaH'], $_SESSION['br_dispaM'], $_SESSION['br_descricao'], $_SESSION['br_humor']);
		
		// Exibe um alerta e redireciona a página
		echo '<script type="text/javascript"> alert("Perfil atualizado com sucesso!"); location.href="perfil.php"; </script>';
		// Encerra a execução
		exit;
	}
	else
	{
		$erro = true;
	}
}
else
{
	$_SESSION['br_senha']		= base64_decode($dados['senha']);
	$_SESSION['br_dispDia']		= $dados['diasemana'];
	$_SESSION['br_dispdH']		= $dados['deh'];
	$_SESSION['br_dispdM']		= $dados['dem'];
	$_SESSION['br_dispaH']		= $dados['ateh'];
	$_SESSION['br_dispaM']		= $dados['atem'];
	$_SESSION['br_descricao']	= $dados['descricao'];
	$_SESSION['br_humor']		= $dados['humor'];
}

// Imprime o cabeçalho
cabecalho('Editar Perfil');
?>
  		<div class="content">
			<h1>Editar Perfil</h1>
			<?php
			if ( $erro )
			{
			?>
			<h3 class="erro">Não foi possível atualizar seu perfil! Tente novamente.</h3>
			<?php
			}
			?>
			<form action="editarperfil.php" method="post">
				<p>
					<label><img src="img/add.jpg" alt=""/> Apelido:
						<input name="apelido" type="text" value="<?=$dados['apelido'];?>" disabled="disabled" />
					</label>
					&nbsp;&nbsp;
					<label>Senha:
						<input name="senha" type="password" value="<?=$_SESSION['br_senha'];?>" />
					</label>
				</p>
				<p><img src="img/relogio.jpg" alt=""/> Disponibilidade para jogar (dia e horário):
					<select name="disponibilidade">
						<?php if ( isset($_SESSION['br_dispDia']) ) { ?>
						<option value="<?=$_SESSION['br_dispDia'];?>" selected="selected"><?=$_SESSION['br_dispDia'];?></option>
						<?php } ?>
						<option value="Segunda-feira">Segunda-feira</option>
						<option value="Terça-feira">Terça-feira</option>
						<option value="Quarta-feira">Quarta-feira</option>
						<option value="Quinta-feira">Quinta-feira</option>
						<option value="Sexta-feira">Sexta-feira</option>
						<option value="Sábado">Sábado</option>
						<option value="Domingo">Domingo</option>
					</select>
					das
					<select name="dasH">
						<?php if ( isset($_SESSION['br_dispdH']) ) { ?>
						<option value="<?=$_SESSION['br_dispdH'];?>" selected="selected"><?=$_SESSION['br_dispdH'];?></option>
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
					<select name="dasM">
						<?php if ( isset($_SESSION['br_dispdM']) ) { ?>
						<option value="<?=$_SESSION['br_dispdM'];?>" selected="selected"><?=$_SESSION['br_dispdM'];?></option>
						<?php } ?>
						<option value="00">00</option>
						<option value="15">15</option>
						<option value="30">30</option>
						<option value="45">45</option>
					</select>
					h às
					<select name="asH">
						<?php if ( isset($_SESSION['br_dispaH']) ) { ?>
						<option value="<?=$_SESSION['br_dispaH'];?>" selected="selected"><?=$_SESSION['br_dispaH'];?></option>
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
					<select name="asM">
						<?php if ( isset($_SESSION['br_dispaM']) ) { ?>
						<option value="<?=$_SESSION['br_dispaM'];?>" selected="selected"><?=$_SESSION['br_dispaM'];?></option>
						<?php } ?>
						<option value="00">00</option>
						<option value="15">15</option>
						<option value="30">30</option>
						<option value="45">45</option>
					</select>
					h
				</p>
				<p>
					<label><img src="img/arquivo.jpg" alt=""/> Descrição:<br />
						<textarea name="descricao" cols="80" rows="4"><?=$_SESSION['br_descricao'];?></textarea>
					</label>
				</p>
				<p><img src="img/pessoa.jpg" alt=""/> Humor:
					<label>
						<input type="radio" name="humor" value="agressivo" <?php if ( @$_SESSION['br_humor'] == 'agressivo' ) { ?>checked="checked"<?php } ?> />
						<img src="img/agressivo.jpg" alt=""/> Agressivo
					</label>
					<label>
						<input type="radio" name="humor" value="neutro" <?php if ( @$_SESSION['br_humor'] == 'neutro' ) { ?>checked="checked"<?php } ?> />
						<img src="img/neutro.jpg" alt=""/> Neutro
					</label>
					<label>
						<input type="radio" name="humor" value="calmo" <?php if ( @$_SESSION['br_humor'] == 'calmo' ) { ?>checked="checked"<?php } ?> />
						<img src="img/calmo.jpg" alt=""/> Calmo
					</label>
				</p>
				<p>
					<input type="submit" value="Salvar" />
					&nbsp;&nbsp;
					<input type="button" value="Cancelar" onclick="javascript:location.href='index.php';" />
				</p>
			</form>
		</div>
	  
<?php
// Imprime o rodapé
rodape();
?>
