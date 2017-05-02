<?php // définition de la page par défaut
	session_start();
	include_once("fonctions.php");
?>


<?php
$texte=	'
			<p><img src="images/en_travaux.jpg" alt="Page en construction" width="300px"></p>
			<p><strong>Folie Phonie</strong> est une <strong>chorale</strong> sur la ville de <strong>Villeneuve d\'ascq</strong> créée en 1993 qui pratique "la chanson contemporaine en expression".</p>
			<p>C\'est-à-dire que nous chantons sur de la <strong>variété française</strong> (voyez ici notre répertoire actuel) en ajoutant du déplacement chorégraphique. Bref, on chante et on bouge !</p>
			<p>La joie, la bonne humeur et la complicité sont des éléments importants pour Folie Phonie.</p>
			<p>Nous répétons chaque <strong>mardi soir</strong> en dehors des vacances scolaires à 20h30 dans la salle Marianne (rue de la station, 59650 Villeneuve d\'Ascq).</p>
			<p>Si vous aimez chanter, que notre répertoire vous plait et que vous êtes libre le mardi soir, n\'hésitez pas à venir nous voir pour essayer !</p>
		';

affiche_page($texte);	