CREATE DATABASE IF NOT EXISTS userDB;
CREATE USER IF NOT EXISTS 'admin'@'%' IDENTIFIED BY 'Franklin5';
GRANT SELECT,UPDATE,INSERT,DELETE ON userDB.* TO 'admin'@'%';
FLUSH PRIVILEGES;

USE userDB;
CREATE TABLE IF NOT EXISTS auth (
  ID INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(20) NOT NULL,
  actual VARCHAR(20) NOT NULL,
  pass VARCHAR(60) NOT NULL,
  PRIMARY KEY (ID)
);

INSERT INTO auth (name, actual, pass)
SELECT * FROM (SELECT 'ADMIN1', 'Franklin5', '$apr1$JgJRg.Ty$fsEt1P/h8xANdyNGcDwHN1') AS tmp
WHERE NOT EXISTS (
    SELECT name FROM auth WHERE name = 'ADMIN1' AND actual = 'Franklin5' AND pass = '$apr1$JgJRg.Ty$fsEt1P/h8xANdyNGcDwHN1'
) LIMIT 1;

INSERT INTO auth (name, actual, pass)
SELECT * FROM (SELECT 'ADMIN2', 'Franklin52', '$apr1$7fJtjfQQ$r2Eld4b7dsIOZRmPOouPX.') AS tmp
WHERE NOT EXISTS (
    SELECT name FROM auth WHERE name = 'ADMIN2' AND actual = 'Franklin52' AND pass = '$apr1$7fJtjfQQ$r2Eld4b7dsIOZRmPOouPX.'
) LIMIT 1;