CREATE TABLE utilisateur (
  id int PRIMARY KEY,
  login varchar(200),
  password varchar(256),
  mail varchar(100),
  nom varchar(80),
  prenom varchar(80)
);
CREATE TABLE etudiant (
  id int PRIMARY KEY,
  user_id int ,
  nom varchar(80),
  prenom varchar(80),
  note float
);