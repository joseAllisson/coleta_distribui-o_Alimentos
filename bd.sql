drop database if exists entrega_alimentos;
create database if not exists entrega_alimentos;
use entrega_alimentos;

create table entregadores(
	id_entregador int primary key AUTO_INCREMENT not null,
	nome varchar(60) not null,
	cpf varchar(14) not null unique,
	email varchar(80) not null unique,
    senha varchar(32) not null,
    telefone varchar(20) not null
);

create table empresas(
	id_empresa int primary key AUTO_INCREMENT not null,
	empresa varchar(60) not null,
	email varchar(80) not null unique,
    senha varchar(32) not null,
    telefone varchar(20) not null
);

create table alimentos(
	id_alimento int primary key AUTO_INCREMENT not null,
	fk_empresa int not null,
	nome varchar(60) not null,
	data_validade date not null,
    local_coleta varchar(60)not null,
	img varchar(60),
    id_status int not null default 0,
	foreign key(fk_empresa) references empresas(id_empresa) on delete cascade
);

create table area_entregador (
    id_area_entregador int primary key AUTO_INCREMENT not null,
	fk_alimento int not null,
	fk_entregador int not null,
    foreign key(fk_alimento) references alimentos(id_alimento)on delete cascade,
	foreign key(fk_entregador) references entregadores(id_entregador)on delete cascade
)

