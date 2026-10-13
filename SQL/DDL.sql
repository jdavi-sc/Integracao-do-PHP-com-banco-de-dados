create table cliente (
	id_cliente serial not null,
	nome_cliente varchar(255),
	cpf_cliente varchar(11),
	email_cliente varchar(255),
	data_nascimento_cliente timestamp,
	primary key (id_cliente)
);