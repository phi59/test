<?php
/*
	Page de connexion pour les choristes.
	S'il y a déjà eu connexion, les variables suivantes sont définies
		$_SESSION['user']['id'] valeur de folie_membre.id sur la BdD
		$_SESSION['user']['prenom'] valeur de folie_membre.prenom sur la BdD
		$_SESSION['user']['admin'] qui vaut true pour un admin et false pour un membre classique
	Dans le cas contraire, affichage d'un formulaire de connexion
*/
	session_start();
	include_once("fonctions.php");
?>

<?php

$texte=''; // initialisation du texte à afficher
if ( isset($_POST['mail_utilisateur']) && isset($_POST['password_utilisateur']) && !isset($_SESSION['user']) ) {	// si utilisateur ayant envoyé login et mot de passe sans être déjà connecté
	$email=htmlspecialchars($_POST['mail_utilisateur']);
	$password=htmlspecialchars($_POST['password_utilisateur']);
	$password_hash=sha1('FP',$password);
	
	/*$texte.='<p>email='.$email.'</p>';
	$texte.='<p>mdp='.$password.'</p>';
	$texte.='<p>mdp_hash='.$password_hash.'</p>';*/
	
																		// Vérification que email+mot_de_passe (hachage sha1) correspond en BdD
	$test_connexion=faire_requete_select(0,array('email' => $email , 'password'=> $password ));
	if ($test_connexion['nb_ligne']==1) { 										// si (login+mot de passe) trouvé une seule fois en BdD
		$_SESSION['user']['id']		=$test_connexion['valeur']['id'][0];			// folie_membre.id
		$_SESSION['user']['prenom']	=$test_connexion['valeur']['prenom'][0];		// folie_membre.prenom
		$_SESSION['user']['admin']	= ($test_connexion['valeur']['administrateur'][0]==1?true:false); // =true si l'utilisateur est un administrateur
	} else {
		$texte.='<p class="non_reconnu">login et/ou mot de passe non reconnu...</p>';
	}
}



if ( isset($_SESSION['user']) ) {	// si utilisateur connecté => affichage espace choriste
	$texte.='<p>Bravo '.$_SESSION['user']['prenom'].' vous êtes connecté !!</p>';
} else {							// sinon (utilisateur non connecté) => affichage formulaire de login !
	$texte.='
			<form method="post" action="choristes.php">
				<label for="mail_utilisateur">Votre email : </label>
				<input type="email" name="mail_utilisateur" id="mail_utilisateur" size="15" maxlength="100" placeholder="a.a@gmail.com"/>
				<br />
				<label for="password_utilisateur">Votre mot de passe : </label>
				<input type="password" name="password_utilisateur" id="password_utilisateur" size="15" maxlength="100" placeholder="aaa"/>
				<br />
				<input type="submit" value="Se connecter"/>
			</form>
			<br />
			<p>Vous êtes membre de la chorale et vous n\'avez pas de compte ? <br/>Cliquez <a href="creation_compte.php" title="Demande d\'accès">ici</a> pour en faire la demande</p>
			';
}
	
affiche_page($texte);
?>