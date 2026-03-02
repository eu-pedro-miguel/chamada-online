/* CRIAÇÃO DO BANCO DE DADOS */


drop database if exists siteCO;

create database if not exists siteCO default character set utf8mb4 collate utf8mb4_general_ci;

use siteCO;


/*

PARA VERIFICAR COMO A TABELA FOI CRIADA E TODOS OS SEUS CAMPOS, INCLUSIVE CONSTRAINTS, USE:

show create table <NOME_DA_TABELA>;


SEMELHANTE PARA O BANCO DE DADOS

show create database <NOME_DO_BANCO_DA_DADOS>;

*/


create table if not exists alunos (
  matricula varchar(10) not null,
  nome_aluno varchar(100) not null,
  senha varchar(200) not null,
  primary key (matricula)
) engine=InnoDB default charset=utf8mb4 collate utf8mb4_general_ci;


create table if not exists professores (
  matricula varchar(10) not null,
  nome_professor varchar(100) not null,
  senha varchar(200) not null,
  primary key (matricula)
) engine=InnoDB default charset=utf8mb4 collate utf8mb4_general_ci;


create table presencas (
  id_presenca int not null auto_increment,
  matricula varchar(10) not null,
  data_aula date not null,
  presenca int default 0,
  constraint presenca_fk_1 foreign key (matricula) references alunos(matricula) on delete cascade,
  constraint presenca_unique_1 unique (matricula, data_aula),
  primary key (id_presenca)
) engine=InnoDB AUTO_INCREMENT=1 default charset=utf8mb4 collate utf8mb4_general_ci;


/* PERMISSIONAMENTO DE ACESSO AO BANDO DE DADOS */

drop user if exists 'adminsiteCO'@'127.0.0.1';
drop user if exists 'adminsiteCO'@'localhost';
drop user if exists 'adminsiteCO'@'::1';
create user 'adminsiteCO'@'127.0.0.1' identified by '1QAZXSW23EDCvcxzasdfrewq1234';
create user 'adminsiteCO'@'::1' identified by '1QAZXSW23EDCvcxzasdfrewq1234';
create user 'adminsiteCO'@'localhost' identified by '1QAZXSW23EDCvcxzasdfrewq1234';
grant insert, select, update on siteCO.* to 'adminsiteCO'@'127.0.0.1';
grant insert, select, update on siteCO.* to 'adminsiteCO'@'localhost';
grant insert, select, update on siteCO.* to 'adminsiteCO'@'::1';
grant insert, select, update, delete on siteCO.presencas to 'adminsiteCO'@'127.0.0.1';
grant insert, select, update, delete on siteCO.presencas to 'adminsiteCO'@'localhost';
grant insert, select, update, delete on siteCO.presencas to 'adminsiteCO'@'::1';
flush privileges;


insert into alunos (matricula, nome_aluno, senha) values
("A849942","Adam Johnson","e10adc3949ba59abbe56e057f20f883e"),
("A963214","Bella White","e10adc3949ba59abbe56e057f20f883e"),
("A363794","Charlie Davis","e10adc3949ba59abbe56e057f20f883e"),
("A486086","Diana Miller","e10adc3949ba59abbe56e057f20f883e"),
("A799210","Evan Brown","e10adc3949ba59abbe56e057f20f883e"),
("A853361","Fiona Wilson","e10adc3949ba59abbe56e057f20f883e"),
("A864950","George Taylor","e10adc3949ba59abbe56e057f20f883e"),
("A688579","Hannah Moore","e10adc3949ba59abbe56e057f20f883e"),
("A532117","Isaac Clark","e10adc3949ba59abbe56e057f20f883e"),
("A490658","Julia Lewis","e10adc3949ba59abbe56e057f20f883e"),
("A174710","Kevin Harris","e10adc3949ba59abbe56e057f20f883e"),
("A827595","Lily Robinson","e10adc3949ba59abbe56e057f20f883e"),
("A429362","Michael Hall","e10adc3949ba59abbe56e057f20f883e"),
("A348411","Nancy Young","e10adc3949ba59abbe56e057f20f883e"),
("A311854","Owen King","e10adc3949ba59abbe56e057f20f883e"),
("A285219","Penny Scott","e10adc3949ba59abbe56e057f20f883e"),
("A504556","Quinn Walker","e10adc3949ba59abbe56e057f20f883e"),
("A196957","Ryan Allen","e10adc3949ba59abbe56e057f20f883e"),
("A324749","Samantha Green","e10adc3949ba59abbe56e057f20f883e"),
("A309517","Thomas Adams","e10adc3949ba59abbe56e057f20f883e"),
("A629741","Uma Parker","e10adc3949ba59abbe56e057f20f883e"),
("A131985","Victor Mitchell","e10adc3949ba59abbe56e057f20f883e"),
("A494529","Wendy Carter","e10adc3949ba59abbe56e057f20f883e"),
("A573740","Xavier Harris","e10adc3949ba59abbe56e057f20f883e"),
("A561930","Yvonne Lee","e10adc3949ba59abbe56e057f20f883e"),
("A238594","Zack Nelson","e10adc3949ba59abbe56e057f20f883e"),
("A480997","Abigail Thompson","e10adc3949ba59abbe56e057f20f883e"),
("A377297","Benjamin Hall","e10adc3949ba59abbe56e057f20f883e"),
("A312379","Chloe Wright","e10adc3949ba59abbe56e057f20f883e"),
("A908172","Derek Martin","e10adc3949ba59abbe56e057f20f883e");

insert into professores (matricula, nome_professor, senha) values ("P123456","José da Silva","c33367701511b4f6020ec61ded352059");

