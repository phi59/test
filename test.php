<?php
session_start();
include_once("fonctions.php");

if (!isset($_SESSION['user'])) {	// si non connecté, retour sur la page principale
	header('Location: index.php');
}

$texte='<p>résultat des tests</p>';

// Le message
$message = "Line 1\r\nLine 2\r\nLine 3";

// Dans le cas où nos lignes comportent plus de 70 caractères, nous les coupons en utilisant wordwrap()
$message = wordwrap($message, 70, "\r\n");

// Envoi du mail
if (mail('ph.couche.pro@gmail.com', 'Mon Sujet', $message)) {
	$texte.='<p>envoi OK</p>';
} else {
	$texte.='<p>envoi KO</p>';
}
affiche_page($texte);
?>