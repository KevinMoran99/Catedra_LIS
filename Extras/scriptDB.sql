CREATE DATABASE stoam; 
USE stoam;
	 
SET NAMES 'utf8';

CREATE TABLE publishers(
    id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) UNIQUE NOT NULL,
    state BOOL DEFAULT 1
); 
CREATE TABLE genres(
    id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) UNIQUE NOT NULL,
    state BOOL DEFAULT 1
);
/*
CREATE TABLE platforms(
    id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) UNIQUE NOT NULL,
    state BOOL DEFAULT 1
);*/
/*
create table os(
id int not null PRIMARY KEY AUTO_INCREMENT,
name varchar(50) not null);

create table cpu(
id int not null PRIMARY KEY AUTO_INCREMENT,
name varchar(50));
*/
CREATE TABLE type_specs(
    id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) UNIQUE NOT NULL,
    state BOOL DEFAULT 1
); 
CREATE TABLE specs(
    id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) UNIQUE NOT NULL,
    type_spec_id INT UNSIGNED NOT NULL,
    state BOOL DEFAULT 1,
    CONSTRAINT fk_type_specs_specs FOREIGN KEY(type_spec_id) references type_specs(id) ON DELETE RESTRICT ON UPDATE CASCADE
); 

ALTER TABLE specs add index(type_spec_id);

CREATE TABLE esrbs(
    id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) UNIQUE NOT NULL,
    state BOOL DEFAULT 1
); 
CREATE TABLE games(
    id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) UNIQUE NOT NULL,
    cover VARCHAR(1000) NOT NULL,
    banner VARCHAR(1000) NOT NULL,
    description VARCHAR(500) NOT NULL,
    esrb_id INT UNSIGNED NOT NULL,
    publisher_id INT UNSIGNED NOT NULL,
    genre_id INT UNSIGNED NOT NULL,
    -- platform_id INT UNSIGNED NOT NULL,
    state BOOL DEFAULT 1,
    CONSTRAINT fk_esrbs_games	FOREIGN KEY(esrb_id) REFERENCES esrbs(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_publishers_games FOREIGN KEY(publisher_id) REFERENCES publishers(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_genres_games FOREIGN KEY(genre_id) REFERENCES genres(id) ON DELETE RESTRICT ON UPDATE CASCADE
    -- CONSTRAINT	fk_platforms_games FOREIGN KEY(platform_id) REFERENCES platforms(id) ON DELETE RESTRICT ON UPDATE CASCADE
); 

ALTER TABLE games add index(esrb_id);
ALTER TABLE games add index(publisher_id);
ALTER TABLE games add index(genre_id);
-- ALTER TABLE games add index(platform_id);

CREATE TABLE store_pages(
    id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    game_id INT UNSIGNED NOT NULL,
    release_date DATE NOT NULL,
    visible BOOLEAN DEFAULT 1,
    price DECIMAL(5, 2) UNSIGNED NOT NULL DEFAULT 0.00,
    discount INT UNSIGNED NOT NULL DEFAULT 0,
    CONSTRAINT fk_games_store_pages FOREIGN KEY(game_id) REFERENCES games(id) ON DELETE RESTRICT ON UPDATE CASCADE
); 

ALTER TABLE store_pages add index(game_id);

CREATE TABLE page_specs(
    id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    store_page_id INT UNSIGNED NOT NULL,
    spec_id INT UNSIGNED NOT NULL,
    state BOOL DEFAULT 1,
    CONSTRAINT fk_store_pages_page_specs FOREIGN KEY(store_page_id) REFERENCES store_pages(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_specs_page_specs FOREIGN KEY(spec_id) REFERENCES specs(id) ON DELETE RESTRICT ON UPDATE CASCADE
); 

ALTER TABLE page_specs add index(store_page_id);
ALTER TABLE page_specs add index(spec_id);

CREATE TABLE user_types(
    id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) UNIQUE,
    state BOOL DEFAULT 1,
    games BOOL DEFAULT 0,
    users BOOL DEFAULT 0,
    support BOOL DEFAULT 0,
    stadistics BOOL DEFAULT 0,
    reviews BOOL DEFAULT 0,
    esrbs BOOL DEFAULT 0,
    publishers BOOL DEFAULT 0,
    genres BOOL DEFAULT 0,
    specs BOOL DEFAULT 0,
    type_specs BOOL DEFAULT 0
); 

CREATE TABLE users(
    id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    alias VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    pass VARCHAR(100) NOT NULL,
    user_type_id INT UNSIGNED NOT NULL,
    state BOOL DEFAULT 1,
    pass_date DATE NOT NULL,
    CONSTRAINT fk_user_types_users FOREIGN KEY(user_type_id) REFERENCES user_types(id) ON DELETE RESTRICT ON UPDATE CASCADE
); 

ALTER TABLE users add index(user_type_id);

CREATE TABLE faqs(
	 id INT UNSIGNED not null primary key auto_increment,
	 title varchar(500) UNIQUE not null,
	 description varchar(1000) not null,
	 user_id INT UNSIGNED not null,
	 state BOOL DEFAULT 1,
	 CONSTRAINT fk_user_faqs foreign key(user_id) references users(id) ON DELETE RESTRICT ON UPDATE CASCADE
); 

ALTER TABLE faqs add index(user_id);

CREATE TABLE bills(
    id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    bill_date DATE NOT NULL,
    CONSTRAINT fk_users_bills FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE RESTRICT ON UPDATE CASCADE
); 

ALTER TABLE bills add index(user_id);

CREATE TABLE bill_items(
    id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    bill_id INT UNSIGNED NOT NULL,
    store_page_id INT UNSIGNED NOT NULL,
    game_key CHAR(20) UNIQUE NOT NULL,
    price DECIMAL(5, 2) UNSIGNED NOT NULL DEFAULT 0.00,
    discount INT UNSIGNED NOT NULL DEFAULT 0,
    CONSTRAINT fk_bills_bill_items FOREIGN KEY(bill_id) REFERENCES bills(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_store_pages_bill_items FOREIGN KEY(store_page_id) REFERENCES store_pages(id) ON DELETE RESTRICT ON UPDATE CASCADE
); 

ALTER TABLE bill_items add index(bill_id);
ALTER TABLE bill_items add index(store_page_id);

CREATE TABLE ratings(
    id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    bill_item_id INT UNSIGNED UNIQUE NOT NULL,
    recommended BOOL NOT NULL DEFAULT 1,
    description varchar(500) NOT NULL,
    review_date DATE NOT NULL,
    visible BOOL NOT NULL DEFAULT 1,
    CONSTRAINT fk_bill_items_ratings FOREIGN KEY(bill_item_id) REFERENCES bill_items(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

ALTER TABLE ratings add index(bill_item_id);

CREATE TABLE actions(
    id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) UNIQUE NOT NULL,
    state BOOL DEFAULT 1
); 
CREATE TABLE audits(
    id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    action_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    audit_date DATE NOT NULL,
    CONSTRAINT fk_actions_audits FOREIGN KEY(action_id) REFERENCES actions(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_users_auditsstoam FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

alter table audits add index(action_id);
alter table audits add index(user_id);


-- INSERTS ------------------------------------------------------------------------

-- esrbs
INSERT INTO esrbs(name) VALUES("E");
INSERT INTO esrbs(name) VALUES("E10+");
INSERT INTO esrbs(name) VALUES("T");
INSERT INTO esrbs(name) VALUES("M");
INSERT INTO esrbs(name) VALUES("AO");

-- publishers
INSERT INTO publishers(name) VALUES("2K Games");
INSERT INTO publishers(name) VALUES("Activision");
INSERT INTO publishers(name) VALUES("Ark System Works");
INSERT INTO publishers(name) VALUES("Bethesda Softworks");
INSERT INTO publishers(name) VALUES("Blizzard Entertainment");

-- genres
INSERT INTO genres (name) VALUES ("RPG");
INSERT INTO genres (name) VALUES ("FPS");
INSERT INTO genres (name) VALUES ("Beat'em up");
INSERT INTO genres (name) VALUES ("Puzzle");
INSERT INTO genres (name) VALUES ("Platformer");

-- platforms
/*INSERT INTO platforms (name) VALUES ("Microsoft Windows");
INSERT INTO platforms (name) VALUES ("Mac OS X");*/

-- type_specs
INSERT INTO type_specs(name) VALUES("Procesador");
INSERT INTO type_specs(name) VALUES("Graficos");
INSERT INTO type_specs(name) VALUES("Sistema operativo");
INSERT INTO type_specs(name) VALUES("Memoria");
INSERT INTO type_specs(name) VALUES("Almacenamiento");


-- actions
INSERT INTO actions(name) VALUES("Catálogo creado");
INSERT INTO actions(name) VALUES("Catálogo modificado");
INSERT INTO actions(name) VALUES("Juego añadido");
INSERT INTO actions(name) VALUES("Juego modificado");
INSERT INTO actions(name) VALUES("Factura generada");
INSERT INTO actions(name) VALUES("Calificación añadida");

-- user_types
INSERT INTO user_types(name, games, users, support, stadistics, reviews, esrbs, publishers, genres, specs, type_specs) VALUES("Administrador", 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO user_types(name) VALUES("Cliente");

-- users
INSERT INTO users(alias, email, pass, user_type_id, pass_date) VALUES('root', 'admin@gmail.com', '$2y$10$kQDB6Dm0bdUXrSs6GvSI/eugF.88HuV9Kj8nAxj9gXo8u4dmnMePS', 1, CURDATE()); /*Contraseña: 123456*/
INSERT INTO users(alias, email, pass, user_type_id, pass_date) VALUES('Oscar98', 'oscar@gmail.com', 'bUHhaaUHxvzDcssdGGdNJNDdksdsOOda', 2, CURDATE());
INSERT INTO users(alias, email, pass, user_type_id, pass_date) VALUES('Kevin99', 'kevin@gmail.com', 'cUHhaaUHxvzDcssdGGdNJNDdksdsOOdb', 2, CURDATE());
INSERT INTO users(alias, email, pass, user_type_id, pass_date) VALUES('RaulEmoxitho', 'raul@gmail.com', 'dUHhaaUHxvzDcssdGGdNJNDdksdsOOdc', 2, CURDATE());

-- faqs
INSERT INTO faqs(title,description,user_id) VALUES("No puedo canjear mi juego","Verifique su codigo, si el problema persiste refierase a nuestros numeros de contacto",1);
INSERT INTO faqs(title,description,user_id) VALUES("El matchmaking se tarda demasiado","En ocasiones puede que no haya suficientes jugadores en linea, de no ser asi verifique su internet por cualquier irregularidad",1);
INSERT INTO faqs(title,description,user_id) VALUES("El juego no pasa de la pantalla de inicio","El problema puede provenir de su sistema no cumpliendo con las especificaciones correspondientes",1);
INSERT INTO faqs(title,description,user_id) VALUES("El descuento no fue aplicado","Refierase a nuestra informacion de contacto para ser atendido.",1);
INSERT INTO faqs(title,description,user_id) VALUES("Los inputs no responden correctamente","Verifique el estado de sus perifericos y si su periferico es compatible con el juego.",1);

-- specs
INSERT INTO specs(name, type_spec_id) VALUES('Pentium 4', 1);
INSERT INTO specs(name, type_spec_id) VALUES('Athlon XP', 1);
INSERT INTO specs(name, type_spec_id) VALUES('Tarjeta compatible con DirectX 9.0c y con 128MB RAM', 2);
INSERT INTO specs(name, type_spec_id) VALUES('NVIDIA 6600', 2);
INSERT INTO specs(name, type_spec_id) VALUES('ATI X1300', 2);
INSERT INTO specs(name, type_spec_id) VALUES('Windows XP', 3);
INSERT INTO specs(name, type_spec_id) VALUES('1 GB', 4);
INSERT INTO specs(name, type_spec_id) VALUES('8 GB', 5);
INSERT INTO specs(name, type_spec_id) VALUES('AMD FX-4350, 4.2 GHz', 1);
INSERT INTO specs(name, type_spec_id) VALUES('Intel Core i5-3470, 3.20 GHz', 1);
INSERT INTO specs(name, type_spec_id) VALUES('Radeon HD 6870, 1 GB', 2);
INSERT INTO specs(name, type_spec_id) VALUES('GeForce GTX 650 Ti, 1 GB', 2);
INSERT INTO specs(name, type_spec_id) VALUES('Windows 7 x64', 3);
INSERT INTO specs(name, type_spec_id) VALUES('4 GB', 4);
INSERT INTO specs(name, type_spec_id) VALUES('30 GB', 5);
INSERT INTO specs(name, type_spec_id) VALUES('Intel Core i5, 2.0 GHz', 1);
INSERT INTO specs(name, type_spec_id) VALUES('Nvidia GeForce GTX 560', 2);
INSERT INTO specs(name, type_spec_id) VALUES('Radeon HD 7770', 2);
INSERT INTO specs(name, type_spec_id) VALUES('Windows 7', 3);
INSERT INTO specs(name, type_spec_id) VALUES('2 GB', 4);
INSERT INTO specs(name, type_spec_id) VALUES('12 GB', 5);
INSERT INTO specs(name, type_spec_id) VALUES('Intel Core i3 3225, 3.3 GHz', 1);
INSERT INTO specs(name, type_spec_id) VALUES('AMD Ryzen 4 1400', 1);
INSERT INTO specs(name, type_spec_id) VALUES('Nvidia GeForce GTX 660, 2 GB', 2);
INSERT INTO specs(name, type_spec_id) VALUES('Nvidia GeForce GTX 1050', 2);
INSERT INTO specs(name, type_spec_id) VALUES('ATI Radeon HD 7850, 2 GB', 2);
INSERT INTO specs(name, type_spec_id) VALUES('AMD RX 550', 2);
INSERT INTO specs(name, type_spec_id) VALUES('90 GB', 5);
INSERT INTO specs(name, type_spec_id) VALUES('Intel Core i3', 1);
INSERT INTO specs(name, type_spec_id) VALUES('AMD Phenom X3 8650', 1);
INSERT INTO specs(name, type_spec_id) VALUES('Nvidia GeForce GTX 460', 2);
INSERT INTO specs(name, type_spec_id) VALUES('ATI Radeon HD 4850', 2);
INSERT INTO specs(name, type_spec_id) VALUES('Intel HD Graphics 4400', 2);
INSERT INTO specs(name, type_spec_id) VALUES('Windows Vista', 3);


-- audits
INSERT INTO audits(action_id, user_id, audit_date) VALUES(1, 1, "2017-12-01");
INSERT INTO audits(action_id, user_id, audit_date) VALUES(2, 1, "2017-12-01");
INSERT INTO audits(action_id, user_id, audit_date) VALUES(1, 1, "2017-12-01");
INSERT INTO audits(action_id, user_id, audit_date) VALUES(1, 1, "2017-12-01");
INSERT INTO audits(action_id, user_id, audit_date) VALUES(4, 1, "2017-12-01");
INSERT INTO audits(action_id, user_id, audit_date) VALUES(3, 1, "2017-12-01");
INSERT INTO audits(action_id, user_id, audit_date) VALUES(1, 1, "2017-12-01");
INSERT INTO audits(action_id, user_id, audit_date) VALUES(3, 1, "2017-12-01");
INSERT INTO audits(action_id, user_id, audit_date) VALUES(1, 1, "2017-12-01");
INSERT INTO audits(action_id, user_id, audit_date) VALUES(2, 1, "2017-12-01");
INSERT INTO audits(action_id, user_id, audit_date) VALUES(1, 1, "2017-12-02");
INSERT INTO audits(action_id, user_id, audit_date) VALUES(4, 1, "2017-12-02");
INSERT INTO audits(action_id, user_id, audit_date) VALUES(3, 1, "2017-12-02");
INSERT INTO audits(action_id, user_id, audit_date) VALUES(2, 1, "2017-12-02");
INSERT INTO audits(action_id, user_id, audit_date) VALUES(3, 1, "2017-12-02");
INSERT INTO audits(action_id, user_id, audit_date) VALUES(4, 1, "2017-12-02");
INSERT INTO audits(action_id, user_id, audit_date) VALUES(1, 1, "2017-12-02");
INSERT INTO audits(action_id, user_id, audit_date) VALUES(4, 1, "2017-12-02");
INSERT INTO audits(action_id, user_id, audit_date) VALUES(5, 2, "2018-01-30");
INSERT INTO audits(action_id, user_id, audit_date) VALUES(5, 2, "2018-02-01");
INSERT INTO audits(action_id, user_id, audit_date) VALUES(5, 3, "2018-01-12");
INSERT INTO audits(action_id, user_id, audit_date) VALUES(6, 2, "2018-01-12");
INSERT INTO audits(action_id, user_id, audit_date) VALUES(6, 2, "2018-02-24");
INSERT INTO audits(action_id, user_id, audit_date) VALUES(6, 2, "2018-02-24");
