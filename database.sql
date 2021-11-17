-- Poistaa ja luo tietokannan
drop database if exists verkkokauppa;
create database verkkokauppa;

use verkkokauppa;

-- Tekee kategoriat taulun
create table category (
    id int primary key auto_increment,
    name varchar(30) not null
);

-- Lisää kategoriat tauluun tuoteryhmät
insert into category(name) value ('kitarat');
insert into category(name) value ('rummut');
insert into category(name) value ('bassot');
insert into category(name) value ('viulut');
insert into category(name) value ('muut');

-- luo tuote taulun
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

-- luo tarjous taulun
create table discount (
    id int primary key auto_increment,
    name varchar(100) not null,
    price double (10,2) not null,
    image varchar(50)
);

-- lisää tarjoustuotteita tarjoustauluun
insert into discount(name,price) value ('tarjous kitara',3500);
insert into discount(name,price) value ('tarjous rumpu',5800);
insert into discount(name,price) value ('tarjous basso',1200);
insert into discount(name,price) value ('tarjous viulu',10250);

-- Lisää testi tuotteita tuote tauluun
insert into product(name,price,category_id) value ('testi kitara',10,1);
insert into product(name,price,category_id) value ('testi kitara1',20,1);

insert into product(name,price,category_id) value ('testi rummut',10,2);
insert into product(name,price,category_id) value ('testi rummut1',20,2);

insert into product(name,price,category_id) value ('testi bassot',10,3);
insert into product(name,price,category_id) value ('testi bassot1',20,3);

insert into product(name,price,category_id) value ('testi viulu',10,4);
insert into product(name,price,category_id) value ('testi viulu1',20,4);

insert into product(name,price,category_id) value ('testi muut',10,5);
insert into product(name,price,category_id) value ('testi muut1',20,5);

-- Luo asiakas taulun
create table customers (
    cust_nro int auto_increment,
    first_name varchar(20) not null,
    last_name varchar(20) not null,
    mail_username varchar(50) not null,
    password varchar(200),
    address varchar(50) not null,
    zip INT(5) not null,
    city varchar(15) not null,
    phone INT(10) not null,
    PRIMARY KEY (cust_nro),
    index cust_nro(cust_nro)
)   auto_increment=1000;

-- Lisää pari esimerkki asiakasta
insert into customers(first_name,last_name,mail_username,password, address,zip,city,phone) value ('Esko','Esimerkki','epeli@eskondomain.ru','Kappasvaan1234','Erppakuja 1','99099','Inari','0453589541');
insert into customers(first_name,last_name,mail_username,password, address,zip,city,phone) value ('Pekka','Perusmerkki','peke@eskondomain.ru','Joopasenjoo1234','Erppakuja 100','99099','Inari','04012312312');

