<?php
function affiche_page($texte)
/*
	Affiche une page standard à partir d'un même modèle.
	le texte est inséré dans les balises <article>
	Le menu affiche déconnexion si l'utilisateur est connecté
*/
	{
		echo 	'<!DOCTYPE html>
				<html>
					<head>
						<meta charset="utf-8" />
						<link rel="stylesheet" href="style.css" />
						<meta name="viewport" content="width=500" /> <! pour les mobiles, la fenetre de visualisation est fixée à 320 px. On peut mettre content="width=device-width" >
						<link rel="icon" type="image/png" href="images/favicon_FoliePhonie.png">
						<title>Folie Phonie</title>
					</head>
					<body>
						<header>
							<div>
								<p class="image_flottante"><img src="images/LOGO_FoliePhonie.jpg" alt="Logo Folie Phonie" width="300px"></p>
								<h1>Folie Phonie</h1>
								<h2>Chorale sur Villeneuve d\' Ascq</h2>
							</div>
						</header>
						<section>
							<aside>
								<nav>
									<ul>
										<li><a href="index.php"         title="Retour à l\' accueil">accueil</a></li>
										<li><a href="repertoire.php"    title="Répertoire actuel">répertoire</a></li>
										<li><a href="prochainement.php" title="Prochains événements">agenda</a></li>
										<li><a href="contact.php"       title="Nous contacter">contact</a></li>
										<li><a href="choristes.php"     title="Pour les choristes uniquement">accès choriste</a></li>';
										
										if ( isset($_SESSION['user']) ) {		// si le client est connecté
											echo '<li><a href="annuaire.php"     title="Annuaire des choristes">Annuaire</a></li>';	// accès à l'annuaire
											echo '<li><a href="deconnexion.php"  title="Se déconnecter">déconnexion</a></li>';		// accès à la déconnexion
										}
		echo '
									</ul>
								</nav>
							</aside>							
							<article>
								'.$texte.'
							</article>
						</section>
						<footer>
							<p>footer</p>
						</footer>
					</body>
				</html>';
	}

function connexion_bdd()
/*
	Fonction qui se connecte à la BdD
	Les paramètres sont dans le fichier variables_privees.php
*/
	{
		include('variables_privees.php');
		try
			{
				$bdd = new PDO($bdd_local_host, $bdd_login, $bdd_password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
				return $bdd;
			}
		catch (Exception $e)
			{
				// die('Erreur : '.$e->getMessage());
				die('Connexion à la BdD impossible');
			}
	}

function faire_requete($num_requete,$array_variables)
/*
	Fonction qui exécute une requete préparée (définie par son numéro $num_requete)
	Le resultat est le tableau $tableau
	avec
		$tableau['nb_ligne']:nombre de résultats de la requête
		$tableau['valeur'][par exemple'id'][$i] : resultat i+1 de la requête pour la reponse id de la requête
*/
	{
		$bdd=connexion_bdd();
		include('requetes_preparees.php');
		$reponse_requete = $bdd->prepare($requete[$num_requete]);
		$reponse_requete->execute($array_variables);
		$nb_ligne=0;
		while ($donnees = $reponse_requete->fetch(PDO::FETCH_ASSOC)) // PDO::FETCH_ASSOC pour n'avoir que par association
				{
					foreach ($donnees as $key => $value)
						{ 
							$tableau['valeur'][$key][$nb_ligne]=$value;
						}
					$nb_ligne++;									// pour comptabiliser le nombre de résultats à la requête
				}
		$reponse_requete->closeCursor();
		$tableau['nb_ligne']=$nb_ligne;
		
		return $tableau;
	}

 ?> 