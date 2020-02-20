drop table myclientsession;
drop table myclient;

drop table myclientsession cascade constraints;
drop table myclient cascade constraints;

create table myclient (
  clientid varchar2(10) primary key,
  fname varchar2(30) not null,
  lname varchar2(30) not null,
  password varchar2(12) not null,
  adminflag number(1) not null,
  studentflag number(1) not null
);

create table myclientsession (
  sessionid varchar2(32) not null,
  clientid varchar2(10),
  sessiondate date,
  admin number(1),
  primary key (sessionid),
  foreign key (clientid) references myclient (clientid)
);

insert into myclient values ('JoeB', 'Joe', 'Blow', 'a', 1, 0);
insert into myclient values ('SusieQ', 'Susie', 'Q', 'a', 0, 1);
insert into myclient values ('JackS', 'Jack', 'Sprat', 'a', 1, 1);

commit;
