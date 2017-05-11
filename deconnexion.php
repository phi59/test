<?php
/*
	Page de déconnexion
	On fait un session_destroy() pour vider les variables dans $_SESSION dont $_SESSION['user']
*/
	session_start();
	include_once("fonctions.php");
?>


<?php
session_destroy();
header('Location: index.php');

?>