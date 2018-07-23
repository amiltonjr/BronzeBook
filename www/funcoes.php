<?php
/* Arquivo de Funções - Bronzebook */

// Inicia o sistema de sessões
session_start();

// Inicia a variável global de conexão com o banco de dados
$dbconn = NULL;

// Função que conecta ao banco de dados
function conectarBD()
{
	// Obtém os dados de configuração
	include_once('config.php');
	
	// Instancia a variável global $dbconn
	global $dbconn;
	
	// Faz a conexão com o banco
	$dbconn = pg_connect('host='.$host.' dbname='.$banco.' user='.$usuario.' password='.$senha);
	
	// Se conectou com sucesso
	if ( $dbconn )
	{
		// Obtém a lista com todas as tabelas do banco
		$sql = pg_query("select table_name from information_schema.tables where table_schema = 'public';");
		$res = pg_fetch_all($sql);
		$tabelas = array();
		// Cria uma lista organizada
		foreach ( $res as $t )
			$tabelas[] = $t['table_name'];
		// Remove variáveis desnecessárias da memória
		unset($sql, $res, $t);
		
		// Verifica se as tabelas existem. Senão, cria-as
		
		if ( !in_array('bronze', $tabelas) )
		{
			$sql = pg_query("	create table bronze (
									idbronze serial,
									apelido varchar(50),
									senha varchar(50),
									descricao varchar(200),
									idequipe integer,
									humor varchar(20),
									constraint PKbronze primary key (idbronze)
								);");
		}
		
		if ( !in_array('dia_hora_disp', $tabelas) )
		{
			$sql = pg_query("	create table dia_hora_disp (
									idbronze integer,
									diasemana varchar(15),
									deh varchar(2),
									dem varchar(2),
									ateh varchar(2),
									atem varchar(2),
									constraint PKdia_hora_disp primary key (idbronze),
									constraint FKdia_hora_disp foreign key (idbronze) references bronze (idbronze) on update cascade on delete cascade
								);");
		}
		
		if ( !in_array('equipe', $tabelas) )
		{
			$sql = pg_query("	create table equipe (
									idequipe serial,
									nome varchar (50),
									lider integer not null,
									constraint PKequipe primary key (idequipe),
									constraint FKequipe foreign key(lider) references bronze(idbronze) on delete cascade,
									constraint SKequipe unique (nome)
								);
								
								alter table bronze add constraint FKbronze foreign key (idequipe) references equipe (idequipe) on delete set null;
							");
		}
		
		if ( !in_array('post', $tabelas) )
		{
			$sql = pg_query("	create table post (
									idpost serial,
									idequipe integer,
									idbronze integer,
									assunto varchar (50),
									texto varchar (300),
									dia varchar(10),
									hora varchar(5),
									constraint PKpost primary key (idpost),
									constraint FKpost foreign key(idequipe) references equipe (idequipe) on delete cascade,
									constraint FKpost2 foreign key (idbronze) references bronze(idbronze)on delete cascade
								);");
		}
		
		if ( !in_array('resposta', $tabelas) )
		{
			$sql = pg_query("	create table resposta (
									id serial,
									idpost integer,
									idbronze integer,
									texto varchar (300),
									dia varchar(10),
									hora varchar(5),
									constraint PKresp primary key (id),
									constraint FKresp foreign key(idpost) references post (idpost) on delete cascade,
									constraint FKresp2 foreign key (idbronze) references bronze(idbronze) on delete cascade
								);");
		}
		
		if ( !in_array('curte', $tabelas) )
		{
			$sql = pg_query("	create table curte (
									id serial,
									idpost integer,
									idbronze integer,
									constraint PKcurte primary key (id),
									constraint FKcurte foreign key (idpost) references post (idpost),
									constraint FKcurte2 foreign key (idbronze) references bronze (idbronze)	
								);");
		}
		
		if ( !in_array('amigo', $tabelas) )
		{
			$sql = pg_query("	create table amigo (
									id serial,
									idbronze integer,
									idbronzeamigo integer,
									constraint PKadiciona primary key (id),
									constraint FKadiciona foreign key (idbronze) references bronze (idbronze) on delete cascade,
									constraint FKadiciona2 foreign key(idbronzeamigo) references bronze(idbronze) on delete cascade
								);");
		}
		
		if ( !in_array('jogadaequipe', $tabelas) )
		{
			$sql = pg_query("	create table jogadaequipe (
									idjogada serial,
									titulo varchar(50),
									idequipe integer,
									idvideo varchar(50),
									dia varchar(10),
									hora varchar(5),
									constraint PKjogadaEquipe primary key (idjogada),
									constraint FKjogadaEquipe foreign key (idequipe) references equipe(idequipe) on delete cascade
								);");
		}
		
		if ( !in_array('jogadoresjogadaequipe', $tabelas) )
		{
			$sql = pg_query("	create table jogadoresjogadaequipe (
									id serial,
									idbronze integer,
									idjogada integer,
									constraint PKjogadoresJogadaEquipe primary key (id),
									constraint FKjogadoresJogadaEquipe foreign key (idjogada) references jogadaequipe (idjogada),
									constraint FKjogadoresJogadaEquipe2 foreign key (idbronze) references bronze (idbronze) on delete cascade
								);");
		}
		
		return true;
	}
	else
		return false;
}

// Função que desconecta do banco de dados
function desconectarBD()
{
	// Instancia a variável global $dbconn
	global $dbconn;
	
	// Fecha a conexão
	if ( $dbconn )
	{
		pg_close($dbconn);
		$dbconn = NULL;
	}
}

// Função que executa uma instrução no banco de dados
// e retorna com a resposta
function executarBD($sql=NULL)
{
	// Se há alguma instrução SQL
	if ( $sql != NULL )
	{
		// Instancia a variável global $dbconn
		global $dbconn;
		
		// Conecta ao banco de dados, se necessário
		if ( pg_connection_status($dbconn) !== PGSQL_CONNECTION_OK )
			if ( !conectarBD() )
				exit('Erro ao conectar ao Banco de Dados!');
		
		// Executa a instrução
		$res = pg_query($sql);
		
		// Retorna o resultado
		return $res;
	}
}

// Função que verifica se o usuário está logado no sistema
function estaLogado()
{
	// Verifica se existe uma sessão válida
	if ( strlen(@$_SESSION['bronzebookLogin']) > 3 )
	{
		/*
		// Obtém o apelido
		$apelido = stripslashes($_SESSION['bronzebookLogin']);
		
		// Verifica se o nome de usuário existe no banco de dados
		$sql = executarBD("select idbronze from bronze where apelido='$apelido';");
		
		// Se existe o usuário, então está realmente logado
		if ( pg_num_rows($sql) == 1 )
			return true;
		else
			return false;
		*/
		
		return true;
	}
	else
		return false;
}

// Função que obriga o usuário a estar logado para acessar a página
function deveEstarLogado()
{
	// Se o usuário não está logado
	if ( !estaLogado() )
	{
		// Redireciona a página
		header('Location: login.php');
		
		exit;
	}
}

// Função que faz o login no sistema
function Login($usuario=NULL, $senha=NULL)
{
	// Valida a entrada de dados
	if ( $usuario == NULL || $senha == NULL )
		return false;
	
	// "Criptografa" a senha
	$senha = base64_encode($senha);
	
	// Verifica se os dados de login estão corretos
	$sql = executarBD("select idbronze from bronze where apelido='$usuario' and senha='$senha';");
	
	// Se existe o usuário, então faz o login
	if ( pg_num_rows($sql) == 1 )
	{
		// Salva na sessão
		$_SESSION['bronzebookLogin'] = $usuario;
		
		return true;
	}
	// Se os dados não conferem
	else
	{
		// Destrói a sessão
		Logout();
		
		return false;
	}
}

// Função que faz o logout do sistema
function Logout()
{
	// Destrói a sessão
	$_SESSION['bronzebookLogin'] = 0;
}

// Função que obtém o nome de usuário (apelido)
function obterApelido($id=NULL)
{
	// Retorna com o apelido salvo no login
	if ( $id == NULL )
		return $_SESSION['bronzebookLogin'];
	else
	{
		$sql = pg_query("select apelido from bronze where idbronze=$id;");
		
		// Obtém o apelido
		$row = pg_fetch_row($sql);
		return $row[0];
	}
}

// Função que retorna com o ID do usuário logado
function obterID($apelido=NULL)
{
	// Obtém o apelido
	if ( $apelido == NULL )
		$apelido = obterApelido();
	
	$sql = executarBD("select idbronze from bronze where apelido='$apelido';");
	// Obtém o ID
	$row = pg_fetch_row($sql);
	$idbronze = $row[0];
	
	return $idbronze;
}

// Função que imprime o cabeçalho da página
function cabecalho($titulo=NULL)
{
	// Define o título
	if ( $titulo == NULL )
		$titulo = 'Bronzebook - Página Inicial';
	else
		$titulo = 'Bronzebook - '.$titulo;
	
	// Obtém o conteúdo o arquivo de cabeçalho
	include_once('cabecalho.php');
}

// Função que imprime o rodapé da página
function rodape()
{
	// Inclui o arquivo de rodapé
	include_once('rodape.php');
}

// Função que faz o cadastro de um novo bronze no sistema
function cadastrarBronze($apelido=NULL, $senha=NULL, $dispDia=NULL, $dispdH=NULL, $dispdM=NULL, $dispaH=NULL, $dispaM=NULL, $descricao=NULL, $humor=NULL)
{
	// Valida os dados
	if ( $apelido == NULL || strlen($apelido) < 4 || $senha == NULL || strlen($senha) < 4 || $dispDia == NULL || $dispdH == NULL || $dispdM == NULL || $dispaH == NULL || $dispaM == NULL || $descricao == NULL || $humor == NULL || $dispaH <= $dispdH )
		return false;
	
	// "Criptografa" a senha
	$senha = base64_encode($senha);
	
	// Insere o bronze no banco de dados
	$sql = executarBD("insert into bronze (apelido, senha, descricao, idequipe, humor) values ('$apelido', '$senha', '$descricao', null, '$humor') returning idbronze;");
	// Obtém o seu ID
	$row = pg_fetch_row($sql);
	$idbronze = $row[0];
	// Insere na tabela de disponibilidade de horário
	$sql = executarBD("insert into dia_hora_disp (idbronze, diasemana, deH, deM, ateH, ateM) values ($idbronze, '$dispDia', '$dispdH', '$dispdM', '$dispaH', '$dispaM');");
	
	return true;
}

// Função que faz a atualizacão do cadastro de um novo bronze no sistema
function atualizarBronze($idbronze=NULL, $senha=NULL, $dispDia=NULL, $dispdH=NULL, $dispdM=NULL, $dispaH=NULL, $dispaM=NULL, $descricao=NULL, $humor=NULL)
{
	// Valida os dados
	if ( $idbronze == NULL || $senha == NULL || strlen($senha) < 4 || $dispDia == NULL || $dispdH == NULL || $dispdM == NULL || $dispaH == NULL || $dispaM == NULL || $descricao == NULL || $humor == NULL || $dispaH <= $dispdH )
		return false;
	
	// "Criptografa" a senha
	$senha = base64_encode($senha);
	
	// Atualiza o bronze no banco de dados
	$sql = executarBD("update bronze set senha='$senha', descricao='$descricao', humor='$humor' where idbronze=$idbronze;");
	// Atualiza na tabela de disponibilidade de horário
	$sql = executarBD("update dia_hora_disp set diasemana='$dispDia', deH='$dispdH', deM='$dispdM', ateH='$dispaH', ateM='$dispaM' where idbronze=$idbronze;");
	
	return true;
}

// Função que obtém os dados do perfil de um usuário, baseado em seu apelido
function obterDadosPerfil($apelido=NULL)
{
	// Se é do usuário logado
	if ( $apelido == NULL )
		$apelido = obterApelido();
	
	// Obtém os dados no banco
	$sql = executarBD("select * from bronze B, dia_hora_disp D where B.idbronze=D.idbronze and apelido='$apelido';");
	// Retorna em um array
	return pg_fetch_array($sql);
}

// Função que obtém os dados do perfil de um usuário, baseado em seu ID
function obterDadosPerfilID($id=NULL)
{
	// Se é do usuário logado
	if ( $id == NULL )
		$apelido = obterApelido();
	else
		$apelido = obterApelido($id);
	
	return obterDadosPerfil($apelido);
}

// Função que verifica se dois usuários são amigos
function saoAmigos($bronze1=NULL, $bronze2=NULL)
{
	// Valida as entradas
	if ( $bronze1 == NULL || $bronze2 == NULL || $bronze1 == $bronze2 )
		return false;
	
	// Verifica no banco de dados
	$sql = pg_query("select * from amigo where (idbronze = (select idbronze from bronze where apelido='$bronze1') and idbronzeamigo = (select idbronze from bronze where apelido='$bronze2')) or (idbronze = (select idbronze from bronze where apelido='$bronze2') and idbronzeamigo = (select idbronze from bronze where apelido='$bronze1'));");
	
	if ( pg_num_rows($sql) == 1 )
		return true;
	else
		return false;
}

// Função que adiciona um usuário como amigo
function addAmigo($apelido=NULL)
{
	// Valida a entrada
	if ( $apelido == NULL )
		return false;
	
	// Se já são amigos, retorna falso
	//if ( saoAmigos(obterApelido(), $apelido) )
		//return false;
	
	// Obtém o ID do usuário logado
	$logado = obterID();
	// Obtém o ID do amigo
	$amigo = obterID($apelido);
	
	// Adiciona no banco de dados
	$sql = executarBD("insert into amigo (idbronze, idbronzeamigo) values ($logado, $amigo);");
	
	return true;
}

// Função que remove um usuário dos amigos
function removerAmigo($apelido=NULL)
{
	// Valida a entrada
	if ( $apelido == NULL )
		return false;
	
	// Se não são amigos, retorna falso
	//if ( !saoAmigos(obterApelido(), $apelido) )
		//return false;
	
	// Obtém o ID do usuário logado
	$logado = obterID();
	// Obtém o ID do amigo
	$amigo = obterID($apelido);
	
	// Apaga os possíveis registros do banco de dados
	$sql = executarBD("delete from amigo where (idbronze=$logado and idbronzeamigo=$amigo) or (idbronze=$amigo and idbronzeamigo=$logado);");
	
	return true;
}

// Função que retorna um array com os apelidos dos amigos
function obterAmigos($apelido=NULL)
{
	// Obtém o apelido do usuário logado
	if ( $apelido == NULL )
		$apelido = obterApelido();
	
	// Busca no banco de dados
	$sql = executarBD("select B.idbronze, A.apelido from bronze A, (select idbronzeamigo as idbronze from amigo where idbronze = (select idbronze from bronze where apelido='$apelido')) B where A.idbronze = B.idbronze;");
	$sql2 = executarBD("select B.idbronze, A.apelido from bronze A, (select idbronze from amigo where idbronzeamigo = (select idbronze from bronze where apelido='$apelido')) B where A.idbronze = B.idbronze;");
	
	// Obtém e une os resultados
	$res1 = pg_fetch_all($sql);
	$res2 = pg_fetch_all($sql2);
	
	if ( !is_array($res1) )
		$res1 = array();
	
	if ( !is_array($res2) )
		$res2 = array();
	
	$quantos = array('quantos' => count($res1) + count($res2));
	
	return array_merge($quantos, $res1, $res2);
}

// Função que pesquisa um usuário no banco de dados e retorna a lista de resultados
function pesquisarBronze($apelido=NULL)
{
	// Valida a entrada
	if ( $apelido == NULL )
		return false;
	
	// Executa a instrução no banco de dados
	$sql = executarBD("select apelido from bronze where apelido like '%$apelido%';");
	
	if ( pg_num_rows($sql) == 0 )
		return false;
	else
		return pg_fetch_all($sql);
}

// Função que obtém a equipe do usuário
function obterEquipe($idequipe=NULL)
{
	// Se recebeu o ID da equipe como parâmetro
	if ( $idequipe != NULL )
	{
		// Executa a instrução no banco de dados
		$sql = executarBD("select idequipe, nome from equipe where idequipe=$idequipe;");
	}
	else if ( $idequipe !== false )
	{
		// Obtém o ID do usuário logado
		$idbronze = obterID();
		
		// Executa a instrução no banco de dados
		$sql = executarBD("select idequipe, nome from equipe where lider=$idbronze;");
	}
	
	if ( pg_num_rows($sql) == 0 )
		return false;
	else
		return pg_fetch_array($sql);
}

// Função que obtém a equipe que o usuário só participa
function obterEquipeParticipa()
{
	// Obtém o apelido
	$apelido = obterApelido();
	
	// Executa a instrução no banco de dados
	$sql = executarBD("select idequipe from bronze where apelido='$apelido';");
	$row = pg_fetch_row($sql);
	
	// Obtém o ID da equipe
	$idequipe = $row[0];
	// Retorna com os dados dela
	return obterEquipe($idequipe);
}

// Função que adiciona uma pessoa à uma equipe
function addEquipe($apelido=NULL, $idequipe=NULL)
{
	// Valida as entradas
	if ( $apelido == NULL || $idequipe == NULL )
		return false;
	
	$sql = executarBD("update bronze set idequipe=$idequipe where apelido='$apelido';");
	
	return true;
}

// Função que remove uma pessoa de uma equipe
function removerEquipe($apelido=NULL, $idequipe=NULL)
{
	// Valida as entradas
	if ( $apelido == NULL || $idequipe == NULL )
		return false;
	
	$sql = executarBD("update bronze set idequipe=null where apelido='$apelido';");
	
	return true;
}

// Função que cadastra uma nova equipe no sistema
function cadastrarEquipe($nome=NULL, $integrantes=NULL)
{
	// Valida a entrada
	if ( $nome == NULL )
		return false;
	
	// Obtém o ID do usuário logado
	$idbronze = obterID();
	
	// Executa a instrução no banco de dados
	$sql = executarBD("insert into equipe (nome, lider) values ('$nome', $idbronze) returning idequipe;");
	// Obtém o seu ID
	$row = pg_fetch_row($sql);
	$idequipe = (int)$row[0];
	
	// Adiciona a equipe em seu registro
	$sql = executarBD("update bronze set idequipe=$idequipe where idbronze=$idbronze;");
	
	// Se há bronzes a serem adicionados, adiciona-os à equipe
	if ( is_array($integrantes) && count($integrantes) > 0 )
		foreach ( $integrantes as $integrante )
			addEquipe($integrante, $idequipe);
	
	return true;
}

// Função que atualiza o nome de uma equipe
function atualizarEquipe($nome=NULL, $idequipe=NULL)
{
	// Valida as entradas
	if ( $nome == NULL || $idequipe == NULL )
		return false;
	
	// Executa a instrução no banco de dados
	$sql = pg_query("update equipe set nome='$nome' where idequipe=$idequipe;");
	
	return true;
}

// Função que retorna com o número de participantes de uma equipe
function numParticipantes($idequipe=NULL)
{
	// Valida a entrada
	if ( $idequipe == NULL )
		return false;
	
	// Executa a instrução no banco de dados
	$sql = pg_query("select count(*) from bronze where idequipe=$idequipe;");
	$row = pg_fetch_row($sql);
	return (int) $row[0];
}

// Função que obtém a lista dos participantes de uma equipe
function obterParticipantes($idequipe=NULL)
{
	// Valida a entrada
	if ( $idequipe == NULL )
		return false;
	
	$participantes = array();
	
	// Obtém o líder da equipe
	$sql = executarBD("select apelido from bronze where idbronze = (select lider from equipe where idequipe=$idequipe);");
	$row = pg_fetch_row($sql);
	$participantes['lider'] = $lider = $row[0];
	
	// Obtém os demais participantes
	$sql = executarBD("select apelido from bronze where idequipe=$idequipe and apelido <> '$lider';");
	while ( $res = pg_fetch_array($sql) )
		$participantes[] = $res[0];
	
	return $participantes;
}

// Função que obtém a lista dos participantes de uma jogada
function obterParticipantesJogada($idjogada=NULL)
{
	// Valida a entrada
	if ( $idjogada == NULL )
		return false;
	
	// Obtém os participantes
	$sql = pg_query("select apelido from bronze B, jogadoresjogadaequipe J where B.idbronze=J.idbronze and J.idjogada=$idjogada order by J.id desc;");
	
	return pg_fetch_all($sql);
}

// Função que obtém a lista de amigos, exceto os que já foram citados, numa lista de participantes de equipe, por exemplo
function obterAmigosExceto($exceto=NULL)
{
	// Obtém a lista de amigos
	$amigos = obterAmigos();
	
	// Valida a entrada
	if ( $exceto == NULL || !is_array($exceto) )
		return $amigos;
	
	unset($amigos['quantos']);
	$res = array();
	$i = 0;
	
	// Percorre a lista
	foreach ( $amigos as $a )
	{
		foreach ( $a as $chave => $valor )
		{
			$res[$i][$chave] = $valor;
			if ( $chave == 'apelido' )
				$apelido = $valor;
		}
		
		if ( in_array($apelido, $exceto) )
			unset($res[$i]);
		else
			$i++;
	}
	
	$res['quantos'] = count($res);
	
	return $res;
}

// Função que adiciona uma bronzice no sistema
function addBronzice($idequipe=NULL, $idbronze=NULL, $titulo=NULL, $descricao=NULL)
{
	// Valida as entradas
	if ( $idequipe == NULL || $idbronze == NULL || $titulo == NULL || $descricao == NULL || strlen($titulo) < 5 || strlen($descricao) > 200 )
		return false;
	
	// Obtém dia e hora
	$dia = date('d/m/Y');
	$hora = date('H:i');
	
	// Executa a instrução no banco de dados
	$sql = executarBD("insert into post (idequipe, idbronze, assunto, texto, dia, hora) values ($idequipe, $idbronze, '$titulo', '$descricao', '$dia', '$hora');");
	
	return true;
}

// Função que obtém as bronzices
function obterBronzices($idequipe=NULL, $idbronzice=NULL, $extra=true)
{
	// Valida a entrada
	if ( $idequipe == NULL )
		return false;
	
	// Se é para pegar os dados de uma bronzice em específico
	if ( $idbronzice != NULL )
		$sql = executarBD("select * from post where idpost=$idbronzice and idequipe=$idequipe;");
	else
		$sql = executarBD("select * from post where idequipe=$idequipe order by idpost desc;");
	
	$res = pg_fetch_all($sql);
		$total = (int) pg_num_rows($sql);
	
	// Percorre cada uma das bronzices
	for ( $i=0; $i<$total; $i++ )
	{
		// Obtém o ID da bronzice
		$idpost = $res[$i]['idpost'];
		
		// Obtém a quantidade de curtidas
		$sql1 = executarBD("select id from curte where idpost=$idpost;");
		$res[$i]['curtidas'] = (int) pg_num_rows($sql1);
		
		// Se é para obter dados extras
		if ( $extra )
		{
			// Obtém a quantidade de respostas
			$sql2 = executarBD("select id from resposta where idpost=$idpost;");
			$res[$i]['respostas'] = (int) pg_num_rows($sql2) + 1; // Soma 1, pra contar a postagem original
			
			// Obtém a última resposta
			$sql3 = executarBD("select * from resposta where idpost=$idpost order by id desc limit 1;");
			
			if ( (int) pg_num_rows($sql3) == 1 )
			{
				$r = pg_fetch_array($sql3);
				// Obtém dia e hora da última resposta, caso haja pelo menos uma
				$res[$i]['dia'] = $r['dia'];
				$res[$i]['hora'] = $r['hora'];
			}
		}
	}
	
	return $res;
}

// Função que retorna com os dados de uma bronzice
function obterDadosBronzice($idbronzice=NULL)
{
	// Valida a entrada
	if ( $idbronzice == NULL )
		return false;
	
	// Obtém o ID da equipe na qual a bronzice pertence
	$sql = executarBD("select idequipe from post where idpost=$idbronzice;");
	$row = pg_fetch_row($sql);
	$idequipe = $row[0];
	
	// Obtém os dados e retorna
	$res = obterBronzices($idequipe, $idbronzice, false);
	
	return $res[0];
}

// Função que obtém as respostas de uma bronzice
function obterRespostas($idbronzice=NULL)
{
	// Valida a entrada
	if ( $idbronzice == NULL )
		return false;
	
	// Executa a instrução no banco de dados
	$sql = executarBD("select * from resposta where idpost=$idbronzice order by id asc;");
	$res = pg_fetch_all($sql);
	
	return $res;
}

// Função que adiciona uma resposta à uma bronzice
function addResposta($idbronzice=NULL, $idbronze=NULL, $resposta=NULL)
{
	// Valida as entradas
	if ( $idbronzice == NULL || $idbronze == NULL || $resposta == NULL )
		return false;
	
	// Obtém dia e hora
	$dia = date('d/m/Y');
	$hora = date('H:i');
	
	// Executa a instrução no banco de dados
	$sql = executarBD("insert into resposta (idpost, idbronze, texto, dia, hora) values ($idbronzice, $idbronze, '$resposta', '$dia', '$hora');");
	
	return true;
}

// Função que verifica se o usuário curtiu uma bronzice
function Curtiu($idbronzice=NULL, $idbronze=NULL)
{
	// Valida a entrada
	if ( $idbronzice == NULL || $idbronze == NULL )
		return NULL;
	
	// Executa a instrução no banco de dados
	$sql = pg_query("select id from curte where idpost=$idbronzice and idbronze=$idbronze;");
	
	if ( pg_num_rows($sql) == 0 )
		return false;
	else
		return true;
}

// Função que alterna o estado curtir de uma bronzice
function toggleCurtir($idbronzice=NULL, $idbronze=NULL)
{
	// Valida a entrada
	if ( $idbronzice == NULL || $idbronze == NULL )
		return NULL;
	
	// Obtém o estado de curtir
	$curtiu = Curtiu($idbronzice, $idbronze);
	
	// Executa a instrução no banco de dados
	if ( $curtiu )
		$sql = executarBD("delete from curte where idpost=$idbronzice and idbronze=$idbronze;");
	else
		$sql = executarBD("insert into curte (idpost, idbronze) values ($idbronzice, $idbronze);");
	
	return true;
}

// Função que valida uma URL do YouTube
function validYoutube($url=NULL)
{
	// Aplica a máscara
	$rx = '~
    ^(?:https?://)?              # Optional protocol
     (?:www\.)?                  # Optional subdomain
     (?:youtube\.com|youtu\.be)  # Mandatory domain name
     /watch\?v=([^&]+)           # URI with video id as capture group 1
     ~x';

	$verifica = preg_match($rx, $url, $res);
	
	// Se a URL é válida, retorna o ID do vídeo
	if ( $verifica )
		return $res[1];
	else
		return false;
}

// Função que adiciona jogadores à uma jogada
function addJogadoresJogada($jogadores=NULL, $jogada=NULL)
{
	// Valida as entradas
	if ( !is_numeric($jogada) || !is_array($jogadores) )
		return false;
	
	// Percorre a lista
	foreach ( $jogadores as $jogador )
	{
		// Executa a instrução no banco de dados
		$sql = executarBD("insert into jogadoresjogadaequipe (idbronze, idjogada) values ((select idbronze from bronze where apelido='$jogador'), $jogada);");
	}
}

// Função que adiciona uma jogada no sistema
function addJogada($idequipe=NULL, $titulo=NULL, $urlvideo=NULL, $dia=NULL, $hora=NULL, $jogadores=NULL)
{
	// Valida a URL do vídeo
	$videoid = validYoutube($urlvideo);
	
	// Valida as entradas
	if ( $idequipe == NULL || $titulo == NULL || $videoid == NULL || $dia == NULL || $hora == NULL || $jogadores == NULL || strlen($titulo) > 50 || !$videoid )
		return false;
	
	// Executa a instrução no banco de dados
	$sql = executarBD("insert into jogadaequipe (titulo, idequipe, idvideo, dia, hora) values ('$titulo', $idequipe, '$videoid', '$dia', '$hora') returning idjogada;");
	// Obtém o ID da jogada
	$row = pg_fetch_row($sql);
	$idjogada = (int) $row[0];
	
	// Adiciona os jogadores à jogada
	addJogadoresJogada($jogadores, $idjogada);
	
	return true;
}

// Função que retorna com os dados das jogadas
function obterJogadas($idequipe=NULL)
{
	// Valida a entrada
	if ( $idequipe == NULL )
		return false;
	
	// Instrução no banco de dados
	$sql = executarBD("select * from (select * from jogadaequipe natural join jogadoresjogadaequipe) A where A.idequipe=$idequipe order by A.id desc;");
	
	return pg_fetch_all($sql);
}

// Função que obtém os dados de uma jogada
function obterJogada($idjogada=NULL)
{
	// Valida a entrada
	if ( $idjogada == NULL )
		return false;
	
	// Instrução no banco de dados
	$sql = executarBD("select * from jogadaequipe where idjogada=$idjogada;");
	$res = pg_fetch_all($sql);
	
	return $res[0];
}

?>