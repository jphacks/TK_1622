create database jp_data;

use jp_data

create table delivery_record_5(
  id int not null auto_increment primary key,
  userName varchar(255) not null unique,
  userId char(64) not null unique,
  latitude float not null ,
  longitude float not null,
  totalDeliveryDays int default 0,
  useAppDays int default 0 ,
  time0 int default 0,
  time1 int default 0,
  time2 int default 0,
  time3 int default 0,
  time4 int default 0,
  time5 int default 0,
  time6 int default 0,
  time7 int default 0,
  time8 int default 0,
  time9 int default 0,
  time10 int default 0,
  time11 int default 0,
  time12 int default 0,
  time13 int default 0,
  time14 int default 0,
  time15 int default 0,
  time16 int default 0,
  time17 int default 0,
  time18 int default 0,
  time19 int default 0,
  time20 int default 0,
  time21 int default 0,
  time22 int default 0,
  time23 int default 0
);


create table delivery_5(
  id int not null auto_increment primary key,
  userName varchar(255) not null,
  companyflag int not null,
  deliverynumber int not null,
  deliveryname char(64),
  scheduleflag int default 0,
  scheduledday date,
  scheduletime time,
  starttime time,
  endtime time
);

create table user_record(
   id int not null auto_increment primary key,
   userName varchar(255) not null unique,
   userId varchar(255) not null unique,
   hashPassword varchar(255),
   latitude float not null ,
   longitude float not null,
   postal char(32) not null,
   prefecture char(32) not null,
   ward char(32) not null,
   address char(128),
   apartment char(128) not null,
   phonenumber char(32),
   created timestamp not null
 );
