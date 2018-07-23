create table bronze (
	idbronze serial,
	apelido varchar(50),
	senha varchar(50),
	descricao varchar(200),
	idequipe integer,
	humor integer,
	constraint PKbronze primary key (idbronze)
);

create table dia_hora_disp (
	idbronze integer,
	diasemana varchar(15),
	deh varchar(2),
	dem varchar(2),
	ateh varchar(2),
	atem varchar(2),
	constraint PKdia_hora_disp primary key (idbronze),
	constraint FKdia_hora_disp foreign key (idbronze) references bronze (idbronze) on update cascade on delete cascade
);

create table equipe (
	idequipe serial,
	nome varchar (50),
	lider integer not null,
	constraint PKequipe primary key (idequipe),
	constraint FKequipe foreign key(lider) references bronze(idbronze) on delete cascade,
	constraint SKequipe unique (nome)
);

alter table bronze add constraint FKbronze foreign key (idequipe) references equipe (idequipe) on delete set null;

create table post (
	idpost serial,
	idequipe integer,
	idbronze integer,
	assunto varchar (50),
	texto varchar (300),
	dia varchar(10),
	hora varchar(5),
	constraint PKpost primary key (idpost),
	constraint FKpost foreign key(idequipe) references equipe (idequipe) on delete cascade,
	constraint FKpost2 foreign key (idbronze) references bronze(idbronze) on delete cascade
);

create table resposta (
	id serial,
	idpost integer,
	idbronze integer,
	texto varchar (300),
	dia varchar(10),
	hora varchar(5),
	constraint PKresp primary key (id),
	constraint FKresp foreign key(idpost) references post (idpost) on delete cascade,
	constraint FKresp2 foreign key (idbronze) references bronze(idbronze) on delete cascade
);

create table curte (
	id serial,
	idpost integer,
	idbronze integer,
	constraint PKcurte primary key (id),
	constraint FKcurte foreign key (idpost) references post (idpost),
	constraint FKcurte2 foreign key (idbronze) references bronze (idbronze)	
);

create table amigo (
	id serial,
	idbronze integer,
	idbronzeamigo integer,
	constraint PKadiciona primary key (id),
	constraint FKadiciona foreign key (idbronze) references bronze (idbronze) on delete cascade,
	constraint FKadiciona2 foreign key(idbronzeamigo) references bronze(idbronze) on delete cascade
);


create table jogadaequipe (
	idjogada serial,
	titulo varchar(50),
	idequipe integer,
	idvideo varchar(50),
	dia varchar(10),
	hora varchar(5),
	constraint PKjogadaEquipe primary key (idjogada),
	constraint FKjogadaEquipe foreign key (idequipe) references equipe(idequipe) on delete cascade
);


create table jogadoresjogadaequipe (
	id serial,
	idbronze integer,
	idjogada integer,
	constraint PKjogadoresJogadaEquipe primary key (id),
	constraint FKjogadoresJogadaEquipe foreign key (idjogada) references jogadaequipe (idjogada),
	constraint FKjogadoresJogadaEquipe2 foreign key (idbronze) references bronze (idbronze) on delete cascade
);


--inserts
insert into bronze values ([apelido], [senha], [descricao], [idquipe], [humor]);
insert into dia_hora_disp values ([idbronze], [dia], [hora]);
insert into equipes values ([nome], [descricao], [lider]);
insert into post values ([idequipe], [idbronze], [assunto], [texto], [dia], [hora], [idvideo]);
insert into curte values ([dia], [hora], [idequipe], [idbronzepost], [idbronze]);
insert into amigo values ([idbronze], [idbronzeamigo]);
insert into jogadaEquipe values ([dia], [hora], [idequipe]);
insert into jogadoresJogadaEquipe([idbronze], [dia], [hora], [idequipe]);

--dados do perfil
select * from bronze where apelido = [apelido da pessoa logada];

--atualizar dados do perfil
update bronze set senha=[nova senha], descricao=[nova descricao], idquipe=[nova equipe], humor=[novo humor] where apelido=[apelido da pessoa logada];

--pesquisa
select * from bronze where nome like '%[nome para buscar]%';

-- exibir lista de bronzices
select * from post;

-- exibir bronzices
-- vai ta tudo na lista de bronzices

-- exibir jogadas
-- vai ta tudo na lista de bronzices

-- exibir vídeo
select idVideo from post where idpost=[id do post];

-- exibir lista de amigos
select B2.nome, B2.idbronze from bronze B1, amigo A, bronze B2 where A.idbronze=B1.idbronze and A.idbronzeamigo=B2.idbronze;

-- atualizar equipe
update equipe set nome=[novo nome], descricao=[nova descriçao], lider=[novo lider] where idquipe=[idequipe selecionada]

-- exibir lista de participantes de uma equipe
select * from bronze where idequipe=[idequipe da equipe]

-- remover bronze da equipe
update bronze set idquipe=0 where idbronze=[idbronze da pessoa a ser deletada];
