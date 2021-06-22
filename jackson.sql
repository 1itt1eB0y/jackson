create database jackson;
use jackson;

create table user(
    id int AUTO_INCREMENT NOT NULL PRIMARY KEY,
    username varchar(20) NOT NULL,
    password varchar(1024) NOT NULL,
    etc varchar(200) DEFAULT NULL
);

create table drugs(
    id int AUTO_INCREMENT NOT NULL PRIMARY KEY,
    code varchar(20) not null,
    name VARCHAR(50) NOT NULL,
    price_in DOUBLE(10,2) NOT NULL,
    price_out DOUBLE(10,2) NOT NULL,
    amount int NOT NULL DEFAULT 0,
    note VARCHAR(200) DEFAULT NULL
);

create table record(
    id int AUTO_INCREMENT  NOT NULL PRIMARY KEY,
    time VARCHAR(20) NOT NULL,
    code varchar(20) not null,
    name VARCHAR(50) NOT NULL,
    drug_id int NOT NULL,
    price DOUBLE(10,2) NOT NULL,
    amount int NOT NULL DEFAULT 0,
    price_sum double(10,2) not null,
    seller VARCHAR(20) NOT NULL
);


insert INTO `user` VALUES(1,'admin',sha('admin'),DEFAULT);

insert INTO `drugs` VALUES(1, '44127712347', '医用酒精', 10.11, 15, 100,DEFAULT);
insert INTO `drugs` VALUES(id, '611457123774', '碘伏', 2.31, 5, 99,DEFAULT);
insert INTO `drugs` VALUES(id, '7799630814', '甘草片', 30, 45, 100,DEFAULT);
insert INTO `drugs` VALUES(id, '123456789', '茅草根', 10.11, 15, 100,DEFAULT);
insert INTO `drugs` VALUES(id, '22147815', '碘酒', 2.31, 5, 99,DEFAULT);
insert INTO `drugs` VALUES(id, '3112347844', '甘草', 30, 45, 100,DEFAULT);