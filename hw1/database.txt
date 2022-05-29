stewie_db

create table utenti(
	id 		integer primary key auto_increment,
	nome 		varchar(30) not null,
	cognome 	varchar(30) not null,
	email 	varchar(70) not null unique,
	telefono 	varchar(30) not null unique,
	pass 		varchar(255) not null

)engine=INNODB;

create table indirizzi(
	id 		integer primary key auto_increment,
	cap 		varchar(7) not null,
	citta 	varchar(30) not null,
	via 		varchar(30) not null,
	paese 	varchar(30) not null,
	telefono 	varchar(30) not null,
	utente 	integer not null,

	index idx_utente(utente),
	foreign key (utente) references utenti(id)
)engine=INNODB;

create table sconti(
	id 			integer primary key auto_increment,
	nome 			varchar(30) not null unique,
	descrizione 	varchar(500) not nunll,
	percentuale 	integer default '0',
	attivo 		boolean default '0'
)engine=INNODB;

create table categorie_prodotti(
	id 		integer primary key auto_increment,
	nome 		varchar(30) not null unique
)engine=INNODB;

create table prodotti(
	id 			integer primary key auto_increment,
	nome			varchar(30) not null,
	descrizione		varchar(500) not null,
	prezzo		decimal not null default '0.00',
	sku			varchar(10) not null,
	pic			varchar(255) not null,
	quantita		integer not null,
	categoria		integer not null,
	sconto		integer not null,

	index idx_categoria (categoria),
	index idx_sconto	(sconto),
	foreign key (categoria) references categorie_prodotti(id),
	foreign key (sconto) references sconti(id)

)engine=innoDB;

create table shopping_session(
	id		integer primary key auto_increment,
	utente	integer not null unique,
	totale	decimal not null default '0.00',

	index idx_utente	(utente),
	foreign key (utente) references utenti(id)
)engine=innodb;


create table carrello(
	id 			integer primary key AUTO_INCREMENT,
    	prodotto 		integer not null unique,
    	quantita 		integer not null,
    	sessione 		integer not null,

    	index idx_prodotto(prodotto),
	index idx_session(sessione),

	FOREIGN key (sessione) references shopping_session(id),
    	FOREIGN KEY(prodotto) REFERENCES prodotti(id)
)ENGINE=INNODB;

CREATE table dettagli_ordini(
	id 			integer PRIMARY KEY AUTO_INCREMENT,
    	utente 		integer not null,
    	totale 		decimal not null DEFAULT '0.00',
    	ordine_creato 	timestamp not null,

 	index idx_utente (utente),

    	FOREIGN KEY (utente) REFERENCES utenti(id)
)ENGINE=INNODB;


CREATE TABLE articoli_ordini(
	id 		integer PRIMARY KEY AUTO_INCREMENT,
    ordine 		integer not null,
    prodotto 	integer not null,
    quantita 	integer not null DEFAULT 0,
		unique (prodotto,ordine),

    index idx_ordine(ordine),
    index idx_prodotto(prodotto),

    FOREIGN key (ordine) REFERENCES dettagli_ordini(id),
    FOREIGN KEY (prodotto) REFERENCES prodotti(id)
)ENGINE=INNODB


/*create table carrello(
	id integer primary key AUTO_INCREMENT,
    prodotto integer not null,
    quantita integer not null,
    utente integer not null,
    index idx_prodotto(prodotto),
	index idx_utente(utente),
	FOREIGN key (utente) references utenti(id),
    	FOREIGN KEY(prodotto) REFERENCES prodotti(id)
)ENGINE=INNODB;
*/





DELIMITER //
create trigger remove_element_stock
after insert on carrello
for EACH ROW
BEGIN
	update prodotti
    set quantita=quantita-(SELECT quantita from carrello where prodotto=new.prodotto)
    where id=new.prodotto;
end //



delimiter//
create trigger add_totale
afer insert on carrello
for each row
BEGIN

    update shopping_session
    set totale=totale+((SELECT prezzo from prodotti where id=new.prodotto)*(SELECT quantita from carrello where prodotto=new.prodotto))
    where id=new.sessione;

end //

delimiter//
create trigger remove_totale
afer DELETE on carrello
for each row
BEGIN

    update shopping_session
    set totale=totale-((SELECT prezzo from prodotti where id=old.prodotto)*(SELECT quantita from carrello where prodotto=old.prodotto))
    where id=new.sessione;

end //

-------------------------------------------------------------------
-------------------------------------------------------------------
-------------------------------------------------------------------
-------------------------------------------------------------------
-------------------------------------------------------------------
-------------------------------------------------------------------
-------------------------------------------------------------------
-------------------------------------------------------------------
-------------------------------------------------------------------
-------------------------------------------------------------------
insert into sconti(nome,descrizione,percentuale,attivo)
values ('10benvenuto','10% per i nuovi clienti',10,0);

insert into sconti(nome,descrizione,percentuale,attivo)
values ('20pertutti','20% per tutti',20,1);

insert into categorie_prodotti(nome)
values('abbigliamento');

insert into categorie_prodotti(nome)
values('accessori');

insert into prodotti(nome, descrizione, prezzo,sku,quantita,sconto,categoria,pic)
values ('maglietta','maglietta personalizzata','12.5',001,5,1,1,'./css&img/img/shop/maglietta.webp')

insert into prodotti(nome, descrizione, prezzo,sku,quantita,sconto,categoria,pic)
values ('cappello','cappello personalizzato','50',002,2,2,2,'./css&img/img/shop/cappello.webp')
