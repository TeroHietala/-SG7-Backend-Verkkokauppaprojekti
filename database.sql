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
    id int auto_increment,
    name varchar(100) not null,
    price double (10,2) not null,
    image varchar(50),
    PRIMARY KEY (id)
    ) AUTO_INCREMENT=10000;

-- lisää tarjoustuotteita tarjoustauluun
insert into discount(name,price,image) value ('Fender Stratocaster',700,'tarjouskitara.jpg');
insert into discount(name,price,image) value ('Yamaha rumpusetti',500,'tarjousrumpu.jpg');
insert into discount(name,price,image) value ('Ibanez sähköbasso',200,'tarjousbasso.jpg');
insert into discount(name,price,image) value ('Stagg viulu',400,'tarjousviulu.jpg');



-- Lisää testi tuotteita tuote tauluun
insert into product(name,price,image,category_id) value ('Les Paul sähkökitara',400,'kitara1.jpg',1);
insert into product(name,price,image,category_id) value ('Teräskielinen akustinen kitara',300,'kitara2.jpg',1);

insert into product(name,price,image,category_id) value ('Rumpusetti',500,'akustinenrumpu1.jpg',2);
insert into product(name,price,image,category_id) value ('Sähkörumpusetti',400,'sähkörumpu1.jpg',2);

insert into product(name,price,image,category_id) value ('Fender sähköbasso',350,'basso1.jpg',3);
insert into product(name,price,image,category_id) value ('Yamaha sähköbasso',250,'basso2.jpg',3);

insert into product(name,price,image,category_id) value ('Yamaha viulu',500,'viulu1.jpg',4);
insert into product(name,price,image,category_id) value ('Höfner viulu',600,'viulu2.jpg',4);

insert into product(name,price,image,category_id) value ('Akustinen piano',1000,'grandpiano1.jpg',5);
insert into product(name,price,image,category_id) value ('Digitaalipiano',200,'electricpiano.jpg',5);

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

-- Luodaan taulu ContactUs palautteille
create table Contacts (
    idnro int auto_increment,
    fname varchar(20) not null,
    responsemail varchar(50),
    feedback varchar(10000) not null,
    PRIMARY KEY (idnro),
    index idnro(idnro)
);   

-- Lisätään esimerkkejä palautteeseen
insert into Contacts(fname,responsemail,feedback) value ('Pave','pave@gmail.ru','Tämä minun tuotteeni ei nyt toimi niinkuin pitäisi....');
insert into Contacts(fname,responsemail,feedback) value ('Maija','','Asiakaspalvelu toimii hyvin, sain tuotteen jonka halusin ja se tuli perille nopeasti');

-- Lisätään esimerkkejä palautteeseen
insert into Contacts(fname,responsemail,feedback) value ('Pave','pave@gmail.ru','Tämä minun tuotteeni ei nyt toimi niinkuin pitäisi....');
insert into Contacts(fname,responsemail,feedback) value ('Maija','','Asiakaspalvelu toimii hyvin, sain tuotteen jonka halusin ja se tuli perille nopeasti');

-- Luo admin taulun
create table admin (
    id int PRIMARY KEY auto_increment,
    first_name varchar(20) not null,
    last_name varchar(20) not null,
    username varchar(50) not null UNIQUE,
    password varchar(200)
)   auto_increment=100;

-- Luo yksi testikäyttäjä ilman salasanan hashiä
insert into admin(first_name,last_name,username,password) value ('admin','Testi','admin','erittäinsalainen123');

-- Lisää product tauluun description sarakkeen
ALTER TABLE product
ADD description varchar(3600);

-- Lisää product tauluun description sarakkeen
ALTER TABLE discount
ADD description varchar(3600);

-- Luo tilaus taulun
create table `order` (
    id INT primary key auto_increment,
    customers_cust_nro int not null,
    FOREIGN KEY (customers_cust_nro) REFERENCES customers(cust_nro)
    on delete restrict
)   auto_increment=1000;

-- Luo tilausrivi taulun
create table order_row (
    order_id int not null, 
    index order_id(order_id),
    foreign key (order_id) references `order`(id)
    on delete restrict,
    product_id int not null, 
    amount int not null,
    index product_id(product_id),
   	FOREIGN KEY (product_id) references product(id)
       on delete restrict
)