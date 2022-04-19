Create table if not exists venue (
	venue_name varchar(80) not null primary key) engine=innodb;

create table if not exists garage(
	garage_id int not null auto_increment primary key,
    garage_name varchar(80) not null,
    address varchar(255) not null,
    max_spaces int not null) engine=innodb;

Create table if not exists distance (
	garage_id int not null,
	venue varchar(80),
	distance double not null,
	primary key(garage_id, venue),
    Foreign key(venue) references venue(venue_name)) engine=innodb;

Create table if not exists event_list (
	event_name varchar(80) not null primary key,
	start_date date not null,
	end_date date not null,
	venue varchar(80),
    Foreign key(venue) references venue(venue_name)) engine=innodb;

Create table if not exists pricing (
	event_name varchar(80) not null,
	garage_id int not null,
    price double not null,
	primary key (event_name, garage_id),
    foreign key (event_name) references event_list(event_name),
    foreign key (garage_id) references garage(garage_id)) engine=innodb;

create table if not exists users(
	username varchar(80) not null primary key,
    fname varchar(80) not null,
    lname varchar(80) not null,
    pass varchar(80) not null,
    phone_no varchar(10) not null) engine=innodb;

Create table if not exists Reservation (
	reservation_id int not null primary key auto_increment,
	r_date date not null,
	fee int not null,
	customer_user varchar(80) not null,
    garage_id int not null,
    event_name varchar(80) not null,
	primary key (Pnumber),
    foreign key (garage_id) references garage(garage_id),
    foreign key (event_name) references event_list(event_name),
    foreign key (customer_user) references users(username))engine=innodb;

create table if not exists spaces(
	garage_id int not null,
    s_date date not null,
    spaces_taken int not null,
    primary key (garage_id, s_date),
    foreign key (garage_id) references garage(garage_id)) engine=innodb;

insert into venue (venue_name) values ('Shottenstein Center');
insert into venue (venue_name) values ('Stadium');
insert into venue (venue_name) values ('Ice Rink');

insert into garage (garage_name, address, max_spaces) values ('Tuttle', '222 W Zany Ave', 20);
-- insert into garage (garage_name, address, max_spaces) values ('North', '364 E Bat Street', 20);
-- insert into garage (garage_name, address, max_spaces) values ('South', '464 Birdman Boulavard', 20);

insert into distance (garage_id, venue, distance) values (1, 'Shottenstein Center', 40);
insert into distance (garage_id, venue, distance) values (1, 'Stadium', 10);
insert into distance (garage_id, venue, distance) values (1, 'Ice Rink', 20);

insert into event_list (event_name, start_date, end_date, venue)
values ('Public skate with Tyler', '2022-4-28', '2022-4-30', 'Ice Rink');

insert into pricing (event_name, garage_id, price) values ('Public skate with Tyler', 1, 22.50);

insert into users (username, fname, lname, pass, phone_no)
values ('Sahil@osu.edu', 'Sahil', 'Tay', 'pass', '6146140987');


