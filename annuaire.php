<?php
/*
	Cette page affiche la liste des membres de la chorale si l'utilisateur est bien connecté
*/
session_start();
include_once("fonctions.php");

$texte='';
if (!isset($_SESSION['user'])) {
	// non connecté... retour à l'accueil
	$texte.='<p>Vous n\'êtes pas connecté.</p>';
} else {
	$liste_choriste=faire_requete(1,array('date_reference' => '2017-05-05' ));

	$texte.='<table>
		<caption>Liste des choristes</caption>'; // légende du tableau
	$texte.='<thead><tr>
		<th>Nom</th>
		<th>Prénom</th>
		<th>Mail</th>
		<th>Téléphone</th>
		<th>adresse</th>
		</tr></thead>';							// première ligne du tableau
	$texte.='<tfoot><tr>
		<th>Nom</th>
		<th>Prénom</th>
		<th>Mail</th>
		<th>Téléphone</th>
		<th>adresse</th>
		</tr></tfoot>';							// dernière ligne du tableau
	$texte.='<tbody>';							//Debut des données de l'annuaire

	//Liste des champs dans $liste_choriste['valeur'] : nom, prenom, email, administrateur, telephone, adresse_1, adresse_2, code_postal, ville
	for ($iter=0;$iter<=$liste_choriste['nb_ligne']-1;$iter++) {
		$texte.='<tr>
			<td>'.$liste_choriste['valeur']['nom'][$iter].'</td>
			<td>'.$liste_choriste['valeur']['prenom'][$iter].'</td>
			<td>'.$liste_choriste['valeur']['email'][$iter].'</td>
			<td>'.$liste_choriste['valeur']['telephone'][$iter].'</td>
			<td>'.$liste_choriste['valeur']['adresse_1'][$iter].'</br>'.$liste_choriste['valeur']['adresse_2'][$iter].'</br>'.$liste_choriste['valeur']['code_postal'][$iter].' '.$liste_choriste['valeur']['ville'][$iter].'</td>
			</tr>'; }

	$texte.='</tbody></table>'; // Fin des données de l'annuaire
}

affiche_page($texte);

?>