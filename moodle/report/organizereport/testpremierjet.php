<?php 

	//Le tableau est tab et on l'importe
	//$tab = array();
	include 'tabtest1.php';
	
	//On creer s1 s2 s3 s4
	$s1=1; //nombre d'activitees pour la premiere semaine
	$s2=0; //nombre d'activitees pour la deuxieme semaine
	$s3=0; //nombre d'activitees pour la troisieme semaine
	$s4=0; //nombre d'activitees pour la quatrieme semaine
	
	//On remplit le nombre d'activitees pour chaques semaines (s1 s2 s3 s4)
	//On fait un while
	// while ($i = 0; $i < ($s1+$s2+$s3+$s4); $i++) {
	//foreach ($tab as &$value) {
		//On fait un choix sur la date et on incremente la semaine correspondante
	//}
	//unset($value); //On détruit value qui persiste après la boucle
	
	//On affiche les lignes du tableau
	<table border="1">
		<tr>
			//On met le titre du tableau
			<td colspan="5">Tableau de bord Etudiant</td> 
		</tr>
		<tr>
			//On définit les nom des colonnes
			<td></td>
			<td>Date de fin</td>
			<td>Heure</td>
			<td>Type de rendu</td>
			<td>Matiere</td>
		</tr>
		//On commence la boucle
		for ($i = 0; $i < ($s1+$s2+$s3+$s4); $i++) {
			//On commence la semaine 1
			if ($i=0){
				<tr>
					<td rowspan="$S1">Semaine 1</td>
					<td>$tab[i][0]</td>
					<td>$tab[i][1]</td>
					<td>$tab[i][2]</td>
					<td>$tab[i][3]</td>
				</tr>}
			//On affiche qu'une fois semaine 1
			elseif ($i<$s1){
				<tr>
					<td>$tab[i][0]</td>
					<td>$tab[i][1]</td>
					<td>$tab[i][2]</td>
					<td>$tab[i][3]</td>
				</tr>}
			//On commence la semaine 2
			elseif ($i=$s1){
				<tr>
					<td rowspan="$S1">Semaine 2</td>
					<td>$tab[i][0]</td>
					<td>$tab[i][1]</td>
					<td>$tab[i][2]</td>
					<td>$tab[i][3]</td>
				</tr>}
			//On affiche qu'une fois semaine 2
			elseif ($i<($s1+$s2){
				<tr>
					<td>$tab[i][0]</td>
					<td>$tab[i][1]</td>
					<td>$tab[i][2]</td>
					<td>$tab[i][3]</td>
				</tr>}
			//On commence la semaine 3
			elseif ($i=$s1+$s2){
				<tr>
					<td rowspan="$S1">Semaine 3</td>
					<td>$tab[i][0]</td>
					<td>$tab[i][1]</td>
					<td>$tab[i][2]</td>
					<td>$tab[i][3]</td>
				</tr>}
			//On affiche qu'une fois semaine 3
			elseif ($i<($s1+$s2+$s3){
				<tr>
					<td>$tab[i][0]</td>
					<td>$tab[i][1]</td>
					<td>$tab[i][2]</td>
					<td>$tab[i][3]</td>
				</tr>}
			//On commence la semaine 4
			elseif ($i=$s1+$s2+$s3){
				<tr>
					<td rowspan="$S1">Semaine 4</td>
					<td>$tab[i][0]</td>
					<td>$tab[i][1]</td>
					<td>$tab[i][2]</td>
					<td>$tab[i][3]</td>
				</tr>}
			//On affiche qu'une fois semaine 4
			else{
				<tr>
					<td>$tab[i][0]</td>
					<td>$tab[i][1]</td>
					<td>$tab[i][2]</td>
					<td>$tab[i][3]</td>
				</tr>}			
		}
		// fin de la boucle
	
	// L'affichage du tableau est terminer
	</table>
	


?>