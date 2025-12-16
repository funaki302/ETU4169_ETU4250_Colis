-- tp_flight
create database tp_flight;
use  tp_flight;

drop table produits;
create table produits(
    id int primary key auto_increment,
    p_name varchar(200),
    p_price decimal(12,2),
    p_image varchar(200),
    p_description text
);


insert into produits (p_name , p_image , p_price , p_description) values
('Produit 1' , '1.jpg' , 160000 , 'Description du produit 1'),
('Produit 2' , '2.jpg' , 120000 , 'Description du produit 2'),
('Produit 3' , '3.jpg' , 110000 , 'Description du produit 3');

