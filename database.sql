drop database if exists verkkokauppa;
create database verkkokauppa;

use verkkokauppa;

create table category (
    id int primary key auto_increment,
    name varchar(30) not null
);

insert into category(name) value ('kitarat');
insert into category(name) value ('rummut');
insert into category(name) value ('bassot');
insert into category(name) value ('viulut');
insert into category(name) value ('muut');

create table product (
    id int primary key auto_increment,
    name varchar(100) not null,
    price double (10,2) not null,
    image varchar(50),
    category_id int not null,
    index category_id(category_id),
    foreign key (category_id) references category(id)
    on delete restrict
);

insert into product(name,price,category_id) value ('testi kitara',10,1);
insert into product(name,price,category_id) value ('testi kitara1',20,1);

insert into product(name,price,category_id) value ('testi kitara',10,2);
insert into product(name,price,category_id) value ('testi kitara1',20,2);

insert into product(name,price,category_id) value ('testi bassot',10,3);
insert into product(name,price,category_id) value ('testi bassot1',20,3);

insert into product(name,price,category_id) value ('testi viulu',10,4);
insert into product(name,price,category_id) value ('testi viulu1',20,4);

insert into product(name,price,category_id) value ('testi muut',10,5);
insert into product(name,price,category_id) value ('testi muut1',20,5);