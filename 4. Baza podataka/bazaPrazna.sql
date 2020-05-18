
CREATE TABLE Administrator
(
	IdKor                INTEGER NOT NULL
);

ALTER TABLE Administrator
ADD CONSTRAINT XPKAdministrator PRIMARY KEY (IdKor);

CREATE TABLE Cita
(
	Strana               INTEGER NOT NULL,
	IdTeksta             INTEGER NOT NULL,
	IdKor                INTEGER NOT NULL
);

ALTER TABLE Cita
ADD CONSTRAINT XPKCita PRIMARY KEY (IdTeksta,IdKor);

CREATE TABLE Citalac
(
	VrstaKartice         VARCHAR(20) NOT NULL,
	BrojKartice          CHAR(19) NOT NULL,
	MesecIsteka          CHAR(2) NOT NULL,
	GodinaIsteka         CHAR(2) NOT NULL,
	CVV                  CHAR(4) NOT NULL,
	IdKor                INTEGER NOT NULL
);

ALTER TABLE Citalac
ADD CONSTRAINT XPKCitalac PRIMARY KEY (IdKor);

CREATE TABLE Komentar
(
	IdKom                INTEGER NOT NULL,
	Tekst                TEXT NOT NULL,
	Datum                DATE NOT NULL,
	Vreme                TIME NOT NULL,
	IdKor                INTEGER NOT NULL,
	IdTeksta             INTEGER NOT NULL
);

ALTER TABLE Komentar
ADD CONSTRAINT XPKKomentar PRIMARY KEY (IdKom);

CREATE TABLE Korisnik
(
	Ime                  VARCHAR(30) NOT NULL,
	Prezime              VARCHAR(30) NOT NULL,
	email                VARCHAR(255) NOT NULL,
	username             VARCHAR(30) NOT NULL,
	password             VARCHAR(30) NOT NULL,
	DatumRodjenja        DATE NOT NULL,
	Pol                  CHAR(1) NOT NULL,
	IdKor                INTEGER NOT NULL
);

ALTER TABLE Korisnik
ADD CONSTRAINT XPKKorisnik PRIMARY KEY (IdKor);

CREATE TABLE Oblast
(
	IdObl                INTEGER NOT NULL,
	Naziv                VARCHAR(20) NOT NULL,
	BrojRecenzenata      INTEGER NOT NULL
);

ALTER TABLE Oblast
ADD CONSTRAINT XPKOblast PRIMARY KEY (IdObl);

CREATE TABLE Ocena
(
	Ocena                SMALLINT NOT NULL,
	IdKor                INTEGER NOT NULL,
	IdTeksta             INTEGER NOT NULL
);

ALTER TABLE Ocena
ADD CONSTRAINT XPKOcena PRIMARY KEY (IdKor,IdTeksta);

CREATE TABLE Pisac
(
	IdKor                INTEGER NOT NULL,
	PocetakKarijere      DATE NOT NULL
);

ALTER TABLE Pisac
ADD CONSTRAINT XPKPisac PRIMARY KEY (IdKor);

CREATE TABLE Recenzent
(
	IdKor                INTEGER NOT NULL,
	BrojZavrsenihRecenzija INTEGER NOT NULL,
	IdObl                INTEGER NOT NULL
);

ALTER TABLE Recenzent
ADD CONSTRAINT XPKRecenzent PRIMARY KEY (IdKor);

CREATE TABLE Recenzija
(
	IdTeksta             INTEGER NOT NULL,
	IdKor                INTEGER NOT NULL,
	Zavrsena             boolean NOT NULL
);

ALTER TABLE Recenzija
ADD CONSTRAINT XPKRecenzija PRIMARY KEY (IdTeksta);

CREATE TABLE Tekst
(
	IdTeksta             INTEGER NOT NULL,
	Naziv                VARCHAR(50) NOT NULL,
	Odobren              boolean NOT NULL,
	Tekst                VARCHAR(20) NOT NULL,
	IdKor                INTEGER NOT NULL,
	IdObl                INTEGER NOT NULL,
	Datum                DATE NOT NULL,
	Vreme                TIME NOT NULL
);

ALTER TABLE Tekst
ADD CONSTRAINT XPKTekst PRIMARY KEY (IdTeksta);

CREATE TABLE Zahtev
(
	IdZah                INTEGER NOT NULL,
	Odobren              boolean NOT NULL,
	Datum                DATE NOT NULL,
	Vreme                TIME NOT NULL,
	IdKor                INTEGER NOT NULL,
	IdObl                INTEGER NOT NULL
);

ALTER TABLE Zahtev
ADD CONSTRAINT XPKZahtev PRIMARY KEY (IdZah);

ALTER TABLE Administrator
ADD CONSTRAINT R_2 FOREIGN KEY (IdKor) REFERENCES Korisnik (IdKor)
		ON DELETE CASCADE;

ALTER TABLE Cita
ADD CONSTRAINT R_14 FOREIGN KEY (IdTeksta) REFERENCES Tekst (IdTeksta);

ALTER TABLE Cita
ADD CONSTRAINT R_15 FOREIGN KEY (IdKor) REFERENCES Korisnik (IdKor);

ALTER TABLE Citalac
ADD CONSTRAINT R_1 FOREIGN KEY (IdKor) REFERENCES Korisnik (IdKor)
		ON DELETE CASCADE;

ALTER TABLE Komentar
ADD CONSTRAINT R_9 FOREIGN KEY (IdKor) REFERENCES Korisnik (IdKor);

ALTER TABLE Komentar
ADD CONSTRAINT R_10 FOREIGN KEY (IdTeksta) REFERENCES Tekst (IdTeksta);

ALTER TABLE Ocena
ADD CONSTRAINT R_7 FOREIGN KEY (IdKor) REFERENCES Korisnik (IdKor);

ALTER TABLE Ocena
ADD CONSTRAINT R_8 FOREIGN KEY (IdTeksta) REFERENCES Tekst (IdTeksta);

ALTER TABLE Pisac
ADD CONSTRAINT R_3 FOREIGN KEY (IdKor) REFERENCES Korisnik (IdKor)
		ON DELETE CASCADE;

ALTER TABLE Recenzent
ADD CONSTRAINT R_4 FOREIGN KEY (IdKor) REFERENCES Korisnik (IdKor)
		ON DELETE CASCADE;

ALTER TABLE Recenzent
ADD CONSTRAINT R_11 FOREIGN KEY (IdObl) REFERENCES Oblast (IdObl);

ALTER TABLE Recenzija
ADD CONSTRAINT R_16 FOREIGN KEY (IdTeksta) REFERENCES Tekst (IdTeksta);

ALTER TABLE Recenzija
ADD CONSTRAINT R_17 FOREIGN KEY (IdKor) REFERENCES Recenzent (IdKor);

ALTER TABLE Tekst
ADD CONSTRAINT R_5 FOREIGN KEY (IdKor) REFERENCES Korisnik (IdKor);

ALTER TABLE Tekst
ADD CONSTRAINT R_6 FOREIGN KEY (IdObl) REFERENCES Oblast (IdObl);

ALTER TABLE Zahtev
ADD CONSTRAINT R_12 FOREIGN KEY (IdKor) REFERENCES Pisac (IdKor);

ALTER TABLE Zahtev
ADD CONSTRAINT R_13 FOREIGN KEY (IdObl) REFERENCES Oblast (IdObl);
