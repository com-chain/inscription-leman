IF (SELECT  count(*) from mysql.user WHERE User='myDbName_user')=0
BEGIN
	CREATE USER 'myDbUser';
        set password for 'myDbUser'=password('myDbPassword');
END




CREATE DATABASE IF NOT EXISTS myDbName;

GRANT SELECT, INSERT, UPDATE, DELETE ON myDbName.* TO 'myDbUser';

USE myDbName;

CREATE TABLE  Reg_SiteUser (
  Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  CreatedOn TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  LastLoggedIn DATETIME NULL ,
  EMail VARCHAR( 255 ) NOT NULL ,
  Salt VARCHAR( 255 ) NOT NULL ,
  Password VARCHAR( 32 ) NOT NULL ,
  IsAdmin TINYINT NOT NULL DEFAULT 0,
  CanEdit TINYINT NOT NULL DEFAULT 0,
  CanLogIn TINYINT NOT NULL DEFAULT 0
);

INSERT Reg_SiteUser (EMail,Salt,Password,IsAdmin,CanEdit,CanLogIn)
VALUES('florian@dubath.org','2015-12-11','tttttttttttttttttttttttttttttttt',1,1,1);

--------------------------------------------------------------------------------

CREATE TABLE Reg_RecordType (
   Id INT NOT NULL PRIMARY KEY ,
   Name VARCHAR( 255 ) NOT NULL
);

INSERT Reg_RecordType (Id,Name) 
VALUES (1,'Entreprise');

INSERT Reg_RecordType (Id,Name) 
VALUES (2,'Individuelle');

--------------------------------------------------------------------------------

CREATE TABLE Reg_Status (
   Id INT NOT NULL PRIMARY KEY ,
   Name VARCHAR( 255 ) NOT NULL
);

INSERT Reg_Status (Id,Name) 
VALUES (1,'Sousmis');

INSERT Reg_Status (Id,Name) 
VALUES (2,'Demande de Complément');


INSERT Reg_Status (Id,Name) 
VALUES (3,'Accepté');


INSERT Reg_Status (Id,Name) 
VALUES (100,'Rejeté');

--------------------------------------------------------------------------------

CREATE TABLE  Reg_Person (
  Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  RecordTypeId INT NOT NULL,
  StatusId INT NOT NULL, 

  Email VARCHAR( 255 ) NOT NULL ,
  Phone VARCHAR( 255 ) NOT NULL ,
  
  Address VARCHAR( 255 ) NOT NULL ,
  AddressComplement VARCHAR( 255 ) NULL ,
  NPA VARCHAR( 255 ) NOT NULL ,
  City VARCHAR( 255 ) NOT NULL ,
  Country VARCHAR( 255 ) NOT NULL ,
  
  PostalAddress VARCHAR( 255 ) NULL ,
  PostalAddressComplement VARCHAR( 255 ) NULL ,
  PostalNPA VARCHAR( 255 )  NULL ,
  PostalCity VARCHAR( 255 )  NULL ,
  PostalCountry VARCHAR( 255 )  NULL ,
  
  
  Membership VARCHAR( 255 ) NOT NULL ,
  AccountRequest TINYINT NOT NULL DEFAULT 1,
  DataUsage TINYINT NOT NULL,
  Newsletter TINYINT NOT NULL,
  
  
  PEP VARCHAR( 255 )  NULL,
  PEPRelated VARCHAR( 255 )  NULL,
  FINMA TINYINT  NULL,
  
  AED VARCHAR( 255 )  NULL,
  
  AED_1_FirstName VARCHAR( 255 ) NULL ,
  AED_1_LastName VARCHAR( 255 ) NULL ,
  AED_1_Address VARCHAR( 255 ) NULL ,
  AED_1_AddressComplement VARCHAR( 255 ) NULL,
  AED_1_NPA VARCHAR( 255 )  NULL,
  AED_1_City VARCHAR( 255 )  NULL,
  AED_1_Country VARCHAR( 255 )  NULL,
  AED_1_Citizenship VARCHAR( 255 ) NULL,
  AED_1_BirthDate DATE NULL ,
  
  
  AED_2_FirstName VARCHAR( 255 ) NULL ,
  AED_2_LastName VARCHAR( 255 ) NULL ,
  AED_2_Address VARCHAR( 255 ) NULL ,
  AED_2_AddressComplement VARCHAR( 255 ) NULL,
  AED_2_NPA VARCHAR( 255 )  NULL,
  AED_2_City VARCHAR( 255 )  NULL,
  AED_2_Country VARCHAR( 255 )  NULL,
  AED_2_Citizenship VARCHAR( 255 ) NULL,
  AED_2_BirthDate DATE NULL ,
  
  AED_3_FirstName VARCHAR( 255 ) NULL ,
  AED_3_LastName VARCHAR( 255 ) NULL ,
  AED_3_Address VARCHAR( 255 ) NULL ,
  AED_3_AddressComplement VARCHAR( 255 ) NULL,
  AED_3_NPA VARCHAR( 255 )  NULL,
  AED_3_City VARCHAR( 255 )  NULL,
  AED_3_Country VARCHAR( 255 )  NULL,
  AED_3_Citizenship VARCHAR( 255 ) NULL,
  AED_3_BirthDate DATE NULL ,
  
  
  AED_4_FirstName VARCHAR( 255 ) NULL ,
  AED_4_LastName VARCHAR( 255 ) NULL ,
  AED_4_Address VARCHAR( 255 ) NULL ,
  AED_4_AddressComplement VARCHAR( 255 ) NULL,
  AED_4_NPA VARCHAR( 255 )  NULL,
  AED_4_City VARCHAR( 255 )  NULL,
  AED_4_Country VARCHAR( 255 )  NULL,
  AED_4_Citizenship VARCHAR( 255 ) NULL,
  AED_4_BirthDate DATE NULL ,
  
  
  CGU TINYINT NULL,
  Charte TINYINT  NULL,
  Engagment TINYINT  NULL,
  Attestation TINYINT  NULL,
  
  CONSTRAINT R_Person_type_fk FOREIGN KEY (RecordTypeId) REFERENCES Reg_RecordType(Id),
  CONSTRAINT R_Person_status_fk FOREIGN KEY (StatusId) REFERENCES Reg_Status(Id)

);

CREATE TABLE  Reg_Individual (
  Id INT NOT NULL PRIMARY KEY ,
  FirstName VARCHAR( 255 ) NOT NULL ,
  LastName VARCHAR( 255 ) NOT NULL ,
  Gender VARCHAR( 255 ) NULL ,
  Citizenship VARCHAR( 255 ) NOT NULL,
  BirthDate DATE NOT NULL ,
  IdCard VARCHAR( 255 )  NULL,
  CONSTRAINT R_individual_fk FOREIGN KEY (Id) REFERENCES Reg_Person(Id)
);

CREATE TABLE  Reg_Legal (
  Id INT NOT NULL PRIMARY KEY ,
  Name VARCHAR( 255 ) NOT NULL ,
  RefName VARCHAR( 255 ) NULL ,
  Contact VARCHAR( 255 ) NOT NULL ,
  ContactSurname VARCHAR( 255 ) NULL ,
  ContactGender VARCHAR( 255 ) NULL ,
  LegalForm VARCHAR( 255 ) NOT NULL ,
  CreationDate DATE NOT NULL ,
  ActivityField VARCHAR( 255 ) NOT NULL ,
  ActivityFieldSeg VARCHAR( 255 ) NULL,
  ActivityDescription VARCHAR( 255 ) NOT NULL ,
  EFT FLOAT NOT NULL ,
  Website VARCHAR( 255 ) NULL,
  
  
  ST_1_FirstName VARCHAR( 255 ) NULL ,
  ST_1_LastName VARCHAR( 255 ) NULL ,
  ST_1_Address VARCHAR( 255 ) NULL ,
  ST_1_AddressComplement VARCHAR( 255 ) NULL,
  ST_1_NPA VARCHAR( 255 )  NULL,
  ST_1_City VARCHAR( 255 )  NULL,
  ST_1_Country VARCHAR( 255 )  NULL,
  ST_1_Citizenship VARCHAR( 255 ) NULL,
  ST_1_BirthDate DATE NULL ,
  
  
  ST_2_FirstName VARCHAR( 255 ) NULL ,
  ST_2_LastName VARCHAR( 255 ) NULL ,
  ST_2_Address VARCHAR( 255 ) NULL ,
  ST_2_AddressComplement VARCHAR( 255 ) NULL,
  ST_2_NPA VARCHAR( 255 )  NULL,
  ST_2_City VARCHAR( 255 )  NULL,
  ST_2_Country VARCHAR( 255 )  NULL,
  ST_2_Citizenship VARCHAR( 255 ) NULL,
  ST_2_BirthDate DATE NULL ,
  
  ST_3_FirstName VARCHAR( 255 ) NULL ,
  ST_3_LastName VARCHAR( 255 ) NULL ,
  ST_3_Address VARCHAR( 255 ) NULL ,
  ST_3_AddressComplement VARCHAR( 255 ) NULL,
  ST_3_NPA VARCHAR( 255 )  NULL,
  ST_3_City VARCHAR( 255 )  NULL,
  ST_3_Country VARCHAR( 255 )  NULL,
  ST_3_Citizenship VARCHAR( 255 ) NULL,
  ST_3_BirthDate DATE NULL ,
  
  
  ST_4_FirstName VARCHAR( 255 ) NULL ,
  ST_4_LastName VARCHAR( 255 ) NULL ,
  ST_4_Address VARCHAR( 255 ) NULL ,
  ST_4_AddressComplement VARCHAR( 255 ) NULL,
  ST_4_NPA VARCHAR( 255 )  NULL,
  ST_4_City VARCHAR( 255 )  NULL,
  ST_4_Country VARCHAR( 255 )  NULL,
  ST_4_Citizenship VARCHAR( 255 ) NULL,
  ST_4_BirthDate DATE NULL ,
 
 
  IdCard_1 VARCHAR( 255 )  NULL,
  IdCard_2 VARCHAR( 255 )  NULL,
  IdCard_3 VARCHAR( 255 )  NULL,
  IdCard_4 VARCHAR( 255 )  NULL,
  IdCard_5 VARCHAR( 255 )  NULL,
  IdCard_6 VARCHAR( 255 )  NULL,
  IdCard_7 VARCHAR( 255 )  NULL,
  IdCard_8 VARCHAR( 255 )  NULL,
  IdCard_9 VARCHAR( 255 )  NULL,
  IdCard_10 VARCHAR( 255 )  NULL,
  IdCard_11 VARCHAR( 255 )  NULL,
  IdCard_12 VARCHAR( 255 )  NULL,
  FinState_1 VARCHAR( 255 )  NULL,
  FinState_2 VARCHAR( 255 )  NULL,
  FinState_3 VARCHAR( 255 )  NULL,
  Registration_1 VARCHAR( 255 )  NULL,
  Registration_2 VARCHAR( 255 )  NULL,
  Registration_3 VARCHAR( 255 )  NULL,
  
  CONSTRAINT R_legal_fk FOREIGN KEY (Id) REFERENCES Reg_Person(Id)
  
);

CREATE TABLE Reg_StatusHistory (
   Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
   PersonId INT NOT NULL,
   NewStatusId INT NOT NULL,
   UserId INT NULL,
   EventDate DATE NOT NULL ,
   CONSTRAINT R_hist_person_fk FOREIGN KEY (PersonId) REFERENCES Reg_Person(Id),
   CONSTRAINT R_hist_status_fk FOREIGN KEY (NewStatusId) REFERENCES Reg_Status(Id),
   CONSTRAINT R_hist_user_fk FOREIGN KEY (UserId) REFERENCES Reg_SiteUser(Id)
);


CREATE TABLE Reg_UnlockRequest (
   Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
   address VARCHAR( 255 ) NOT NULL,
   EventDate DATE NOT NULL
);

--------------------
CREATE USER 'myDbUser';
        set password for 'myDbUser'=password('myDbPassword');

GRANT SELECT, INSERT, UPDATE, DELETE ON myDbName.* TO 'myDbUser';

--------------------


--------------------

CREATE TABLE  Reg_Code (
  Id INT NOT NULL  AUTO_INCREMENT PRIMARY KEY ,
  PersonId INT  NULL,
  Code VARCHAR( 32 ) NOT NULL,
  CONSTRAINT R_code_fk FOREIGN KEY (PersonId) REFERENCES Reg_Person(Id)
);



CREATE TABLE  Reg_Wallet (
  Id INT NOT NULL  AUTO_INCREMENT PRIMARY KEY ,
  address VARCHAR( 255 ) NOT NULL,
  PersonId INT NULL,
  CodeId INT NULL,
  Validated INT NOT NULL DEFAULT 0,
  CONSTRAINT R_wallet_p_fk FOREIGN KEY (PersonId) REFERENCES Reg_Person(Id),
  CONSTRAINT R_wallet_c_fk FOREIGN KEY (CodeId) REFERENCES Reg_Code(Id)
);

--------------------


ALTER TABLE Reg_Wallet ADD COLUMN link_date timestamp DEFAULT current_timestamp; 

ALTER TABLE Reg_Wallet ADD COLUMN valid_date DATE; 

--------------------
ALTER TABLE Reg_Wallet ADD COLUMN MainWallet INT DEFAULT 0; 

--------------------
ALTER TABLE Reg_Individual ADD COLUMN IdCard2 VARCHAR( 255 )  NULL;


--------------------
create view lastStatusChange as select PersonId, max(EventDate) as EventDate from Reg_StatusHistory Group by PersonId;

