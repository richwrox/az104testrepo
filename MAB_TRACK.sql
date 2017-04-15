CONNECT MAB_TRACK;

CREATE TABLE aca_mab_customer (
  Aca_ID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ACA_Name CHAR(50) NOT NULL,
  ACA_Bname CHAR(50) NOT NULL
);
CREATE TABLE aca_mab_user (
  User_ID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  Aca_ID INT UNSIGNED NOT NULL,
  Fname CHAR(50) NOT NULL,
  Lname CHAR(50) NOT NULL,
  Type SET('CUSTOMER', 'ADMINISTRATOR') NOT NULL,
  FOREIGN KEY (Aca_ID) REFERENCES aca_mab_customer (Aca_ID)
);
CREATE TABLE aca_mab (
  Mac_ID BIGINT UNSIGNED NOT NULL PRIMARY KEY,
  Aca_ID INT UNSIGNED NOT NULL,
  First_Seen DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  Last_Seen DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  Status SET('ACTIVE', 'PASSIVE') NOT NULL,
  FOREIGN KEY (Aca_ID) REFERENCES aca_mab_customer (Aca_ID)
);
CREATE TABLE aca_mab_note (
  Mac_ID BIGINT UNSIGNED NOT NULL,
  Note VARCHAR (1000) NOT NULL,
  PRIMARY KEY (Mac_ID),
  FOREIGN KEY (Mac_ID) REFERENCES aca_mab (Mac_ID)
);
