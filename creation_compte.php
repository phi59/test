<?php
session_start();
include_once("fonctions.php");


function statut_valeur($valeur,$format)
/*
	fonction qui associe un statut à chaque élémént du formulaire en fonction de son type
	Le statut est 'A remplir' si la valeur est vide=''
	Le statut est 'ok' si non vide et en cohérence avec $format, 'ERREUR' si non vide et non cohérent
*/
{
	if (strlen($valeur)==0) {	// valeur vide
		$statut='A remplir';
	} else {					// valeur non vide
		if (verifier_donnee($valeur,$format)) {  // valeur cohérente au format
			$statut='ok';
		} else {								// valeur non cohérente au format
			$statut='ERREUR';
		}
	}
	return $statut;
}
/*
	Page de demande de création d'accès à la BdD...
	Etape 0 : 	prérequis : aucun
				demande de création (formulaire)
	Etape 1 : 	prérequis : avoir rempli le formulaire de l'étape 0
				vérification des champs renseignés =>écriture des éléments en BdD au statut 1 + envoi d'un mail à l'admin pour demande de validation + message
	Etape 2 :	prérequis : Etape 1 faite (membre présent en BdD au statut 1) et l'admin a cliqué sur le lien d'activation
				validation de la demande par l'admin => Envoi d'un mail au futur membre pour choisir mdp (statut 2) + message
	Etape 3 : 	prérequis : Etape 2 faite (membre présent en BdD au statut 2) et le futur membre a cliqué sur le lien du mail
				Formulaire de choix de mot de passe
*/

?>

<?php

$texte='';

if (!isset($_GET['action']) || !isset($_GET['email']) || !isset($_GET['code'])) { // pas de demande de validation par administrateur
	// Récupération des dernières réponses si elles existent :
	$nom_par_defaut=(isset($_POST['membre_nom']))?htmlspecialchars($_POST['membre_nom']):'';
	$prenom_par_defaut= (isset($_POST['membre_prenom']))?htmlspecialchars($_POST['membre_prenom']):'';
	$email1_par_defaut= (isset($_POST['membre_email1']))?htmlspecialchars($_POST['membre_email1']):'';
	$email2_par_defaut= (isset($_POST['membre_email2']))?htmlspecialchars($_POST['membre_email2']):'';
	$telephone_par_defaut= (isset($_POST['membre_telephone']))?htmlspecialchars($_POST['membre_telephone']):'';
	$adresse1_par_defaut= (isset($_POST['membre_adresse1']))?htmlspecialchars($_POST['membre_adresse1']):'';
	$adresse2_par_defaut= (isset($_POST['membre_adresse2']))?htmlspecialchars($_POST['membre_adresse2']):'';
	$code_postal_par_defaut= (isset($_POST['membre_code_postal']))?htmlspecialchars($_POST['membre_code_postal']):'';
	$ville_par_defaut= (isset($_POST['membre_ville']))?htmlspecialchars($_POST['membre_ville']):'';

	// calcul du nombre de valeurs correctement remplies
	$nombre_criteres_OK=0;
	if (strlen($nom_par_defaut)>0&&verifier_donnee($nom_par_defaut,'alpha')) {$nombre_criteres_OK++;}
	if (strlen($prenom_par_defaut)>0&&verifier_donnee($prenom_par_defaut,'alpha')) {$nombre_criteres_OK++;}
	if (strlen($email1_par_defaut)>0&&verifier_donnee($email1_par_defaut,'email')) {$nombre_criteres_OK++;}
	if (strlen($email2_par_defaut)>0&&$email1_par_defaut==$email2_par_defaut) {$nombre_criteres_OK++;}
	if (strlen($telephone_par_defaut)>0&&verifier_donnee($telephone_par_defaut,'telephone')) {$nombre_criteres_OK++;}
	if (strlen($adresse1_par_defaut.$adresse2_par_defaut)>0&&verifier_donnee($adresse1_par_defaut.$adresse2_par_defaut,'alphanum')) {$nombre_criteres_OK++;}
	if (strlen($code_postal_par_defaut)>0&&verifier_donnee($code_postal_par_defaut,'code_postal')) {$nombre_criteres_OK++;}
	if (strlen($ville_par_defaut)>0&&verifier_donnee($ville_par_defaut,'alpha')) {$nombre_criteres_OK++;}

	if ($nombre_criteres_OK <8) {			// tous les critères de validation des données ne sont pas bons => Formulaire pour remplis tous les champs...
		$texte.='
				<h1>Formulaire de demande d\'accès à l\'espace des choristes</h1>
				<form method="post" action="creation_compte.php">
					<table><tbody>
						<tr>
							<td><label for="nom">Nom</label></td>
							<td><input type="text" name="membre_nom" id="nom" size="30" maxlength="30" value="'.$nom_par_defaut.'" placeholder="votre nom"/></td>
							<td>'.statut_valeur($nom_par_defaut,'alpha').'</td>
						</tr>
						<tr>
							<td><label for="prenom">Prénom</label></td>
							<td><input type="text" name="membre_prenom" id="prenom" size="30" maxlength="30" value="'.$prenom_par_defaut.'" placeholder="votre prénom"/></td>
							<td>'.statut_valeur($prenom_par_defaut,'alpha').'</td>
						</tr>
						<tr>
							<td><label for="email_1">Email</label></td>
							<td><input type="text" name="membre_email1" id="email_1" size="30" maxlength="30" value="'.$email1_par_defaut.'" placeholder="aaa@machin.fr"/></td>
							<td>'.statut_valeur($email1_par_defaut,'email').'</td>
						</tr>
						<tr>
							<td><label for="email_2">Email (vérification)</label></td>
							<td><input type="text" name="membre_email2" id="email_2" size="30" maxlength="30" value="'.$email2_par_defaut.'" placeholder="aaa@machin.fr"/></td>
							<td>'.(($email1_par_defaut==$email2_par_defaut&&strlen($email1_par_defaut)>0)?'ok':'ERREUR').'</td>
						</tr>
						<tr>
							<td><label for="telephone">Téléphone</label></td>
							<td><input type="text" name="membre_telephone" id="telephone" size="30" maxlength="30" value="'.$telephone_par_defaut.'" placeholder="0312345678"/></td>
							<td>'.statut_valeur($telephone_par_defaut,'telephone').'</td>
						</tr>
						<tr>
							<td><label for="adresse_1">Adresse (ligne 1)</label></td>
							<td><input type="text" name="membre_adresse1" id="adresse_1" size="30" maxlength="30" value="'.$adresse1_par_defaut.'" placeholder="rue de la musique"/></td>
							<td>'.statut_valeur($adresse1_par_defaut,'alphanum').'</td>
						</tr>
						<tr>
							<td><label for="adresse_2">Adresse (ligne 2)</label></td>
							<td><input type="text" name="membre_adresse2" id="adresse_2" size="30" maxlength="30" value="'.$adresse2_par_defaut.'" placeholder="Escalier B"/></td>
							<td>'.((statut_valeur($adresse1_par_defaut,'alphanum')=='ok'&&strlen($adresse2_par_defaut)==0)?'ok':statut_valeur($adresse2_par_defaut,'alphanum')).'</td>
						</tr>
						<tr>
							<td><label for="code_postal">Code postal</label></td>
							<td><input type="text" name="membre_code_postal" id="code_postal" size="30" maxlength="30" value="'.$code_postal_par_defaut.'" placeholder="59160"/></td>
							<td>'.statut_valeur($code_postal_par_defaut,'code_postal').'</td>
						</tr>
						<tr>
							<td><label for="ville">Commune</label></td>
							<td><input type="text" name="membre_ville" id="ville" size="30" maxlength="30" value="'.$ville_par_defaut.'" placeholder="Villeneuve d\'ascq"/></td>
							<td>'.statut_valeur($ville_par_defaut,'alpha').'</td>
						</tr>
					</table></tbody>
					<input type="submit" value="Demande de validation auprès de l\'administrateur"/>
				</form>';
	} else {													// toutes les valeurs sont OK => on ecrit cela en BdD, on envoie le mail à l'admin et on fait un massage à l'utilisateur
		// On cherche s'il n'existe pas déjà un membre ou une demande avec cet email
		$test_presence_email=faire_requete_select(2,array('email' => $email1_par_defaut));
		if ($test_presence_email['nb_ligne']>0) {				// il existe déjà un membre (en cours de validation ou validé) avec cet email
			$texte.='<p>Il y a déjà une demande en cours... Attendez patiemment la validation par l\'administrateur</p>';
		} else {												// il n'y a pas de membre avec cet email
			// définition du mot de passe temporaire
			$mdp_tempo=substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 25);
			$lien='https://www.foliephonie.fr/creation_compte.php&action=valider_admin_tempo&email='.$email_par_defaut.'&code='.$mdp_tempo;
			// insertion en Bdd
			faire_requete_non_select(3,array(
				'nom'			=> $nom_par_defaut,
				'prenom'		=> $prenom_par_defaut,
				'email'			=> $email1_par_defaut,
				'mdp_tempo'		=> $mdp_tempo,
				'telephone'		=> $telephone_par_defaut,
				'adresse_1'		=> $adresse1_par_defaut,
				'adresse_2'		=> $adresse2_par_defaut,
				'code_postal'	=> $code_postal_par_defaut,
				'ville'			=> $ville_par_defaut
				));
			// envoi du mail à l'administrateur
			$message.="
				Demande de validation d'un choriste sur foliephonie.fr :\r\n
				nom=".$nom_par_defaut."\r\n
				prenom=".$prenom_par_defaut."\r\n
				email=".$email1_par_defaut."\r\n
				telephone=".$telephone_par_defaut."\r\n
				adresse1=".$adresse1_par_defaut."\r\n
				adresse2=".$adresse2_par_defaut."\r\n
				code postal=".$code_postal_par_defaut."\r\n
				ville=".$ville_par_defaut."\r\n
				lien=".$lien."\r\n\r\n
				
				En attente de validation.";
			$message = wordwrap($message, 70, "\r\n");
			if (mail('ph.couche.pro@gmail.com', 'Demande accès Folie Phonie '.$email1_par_defaut, $message)) {		// si envoi du mail OK => message au futur membre
				$texte.='<p>Votre demande a été transmise à l\'administrateur.<br/>A sa validation, vous recevrez un mail qui vous permettra de définir votre mot de passe et de vous connecter ensuite !</p>';
			} else {															// si envoi du mail KO => message au futur membre
				$texte.='<p>Le mail à l\'administrateur n\'a pas pu être envoyé (le pourquoi est un mystère...)</p>';
			}
		}
	}
} else {					// $_GET['action'], $_GET['email'] ou $_GET['code'] existe(nt) : demande validation par l'admin => chgt statut + mail choriste
	if ( !(isset($_GET['action']) && isset($_GET['email']) && isset($_GET['code']))) { // l'un des argument est manquant
		$texte.='<p>Erreur dans les arguments</p>';
	} else { // tous les arguments sont présents
		$action=htmlspecialchars($_GET['action']);
		$email=htmlspecialchars($_GET['email']);
		$code=htmlspecialchars($_GET['code']);
	}

}
affiche_page($texte);
?>