create database siga;
use siga;

create table atividade(
id int auto_increment primary key,
descricao varchar(250),
peso decimal(16,2),
anexo varchar(250) );


create table usuario(
id int auto_increment primary key,
nome varchar(250),
email varchar(250),
senha varchar(250),
matricula varchar(250),
contato varchar(250) );

create table aula(
    id int auto_increment primary key,
    instrutor varchar(250),
    aluno VARCHAR(150) NOT NULL,
    data_aula DATE NOT NULL,
    hora TIME NOT NULL,
    veiculo VARCHAR(50) NOT NULL,
    arquivo VARCHAR(255)
);
select * from aula;
-- script de criação do banco de dados