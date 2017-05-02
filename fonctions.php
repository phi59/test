<?php
function affiche_page($texte)
/*
	Affiche une page standard à partir d'un même modèle.
	le texte est inséré dans les balises <article>
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
											echo '<li><a href="deconnexion.php"     title="Se déconnecter">déconnexion</a></li>';
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