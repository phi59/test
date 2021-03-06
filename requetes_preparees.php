<?php
//
// Ici se trouve la liste des requêtes préparées
// Pour chacune, indiquer son utilité et ses variables.
//
// Requete 0
// sert pour la vérification du mot de passe, des droits administrateur et donne le prénom
// variables
//		'email' => folie_membre.email
//		'password' => folie_membre.mot_de_passe
// requête appelée dans choristes.php
$requete[0]='
	SELECT
		id, prenom, administrateur
	FROM
		folie_membre
	WHERE 
		email LIKE :email AND mot_de_passe LIKE :password AND statut=4';

// Requete 1
//	Donne la liste des membres dont la date de sortie est supérieure à une date_reference
//  variable
//		'date_reference' : on ne prendra que les choristes dont la folie_membre.date_sortie est supérieure à date_reference
// requête appelée dans annuaire.php
$requete[1]='
	SELECT
		nom, prenom, email, administrateur, telephone, adresse_1, adresse_2, code_postal, ville
	FROM
		folie_membre
	WHERE
		date_sortie>:date_reference
	ORDER BY
		nom,prenom';

// Requete 2
// cherche s'il existe déjà un membre avec l'adresse mail en question
// variable
//		email : email que l'on souhaite tester
// Requête appelée dans creation_compte.php
$requete[2]='
	SELECT
		id
	FROM
		folie_membre
	WHERE
		email LIKE :email';

// Requete 3
// Insertion d'un futur nouveau membre (en attente de validation par l'administrateur)
// variable
//		'nom'
//		'prenom'
//		'email'
//		'mdp_tempo'
//		'telephone'
//		'adresse_1'
//		'adresse_2'
//		'code_postal'
//		'ville'
// requete appelée dans creation_compte.php
$requete[3]='
	INSERT INTO
		folie_membre
	(nom, prenom, email, mdp_tempo, administrateur, telephone, adresse_1, adresse_2, code_postal, ville, statut)
	VALUES
		(:nom , :prenom, :email, :mdp_tempo, 0, :telephone, :adresse_1, :adresse_2, :code_postal, :ville, 1)';

// Requete 4
// A définir

?>