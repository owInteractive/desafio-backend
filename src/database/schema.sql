drop table if exists transactions;

drop table if exists users;

create table users (
  	id bigint primary key auto_increment,
	name varchar(255) not null,
  	email text not null,
  	birthday date not null,
  	created_at datetime not null,
  	updated_at datetime
);

create table transactions (
	id bigint primary key auto_increment,
  	user_id bigint not null,
  	type varchar(50) not null,
  	amount bigint not null,
  	description text,
  	moment datetime not null,
  	foreign key (user_id) references users(id)
);

alter table users add column opening_balance int default 0 not null