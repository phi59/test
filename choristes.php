<?php // inclusion du header commun
	session_start();
	include_once("fonctions.php");
?>

<?php

$texte=''; // initialisation du texte à afficher
if ( isset($_POST['mail_utilisateur']) && isset($_POST['password_utilisateur']) ) {		// si utilisateur ayant envoyé login et mot de passe
	$password_a_tester=htmlspecialchars($_POST['password_utilisateur']);
	if ($password_a_tester=="bbb") { 													// si mot de passe correct
		$_SESSION['user']='philippe';													// alors utilisateur connecté
	} else {
		$texte=$texte.'<p class="non_reconnu">login et/ou mot de passe non reconnu...</p>';
	}
}



if ( isset($_SESSION['user']) ) {	// si utilisateur connecté => affichage espace choriste
	$texte=	$texte.'
			<p>Vous êtes connecté !!</p>
			';
} else {							// sinon (utilisateur non connecté) => formulaire de login !
	$texte=$texte.'
			<form method="post" action="choristes.php">
				<label for="mail_utilisateur">Votre email : </label>
				<input type="email" name="mail_utilisateur" id="mail_utilisateur" size="15" maxlength="100" placeholder="a.a@gmail.com"/>
				<br />
				<label for="password_utilisateur">Votre mot de passe : </label>
				<input type="password" name="password_utilisateur" id="password_utilisateur" size="15" maxlength="100" placeholder="aaa"/>
				<br />
				<input type="submit" value="OK"/> <! envoi des données>
			</form>
			';
}
	
affiche_page($texte);
?>