<?php // page de déconnexion
	session_start();
	include_once("fonctions.php");
?>


<?php
session_destroy();
$texte=	'
			<p>Déconnexion effectuée !!</p>
		';

affiche_page($texte);

?>