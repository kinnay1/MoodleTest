<?php 

	//Le tableau est tab et on l'importe
	//$tab = array();
	$tab = array(); 	
	$tab[0] = array(time()+ (4 * 24 * 60 * 60),'CF','TCP/IP');
	$tab[1] = array(time()+ (4 * 24 * 60 * 60),'DM','TCP/IP');
	$tab[2] = array(time()+ (4 * 24 * 60 * 60),'CF','Math');
	$tab[3] = array(time()+ (8 * 24 * 60 * 60),'Devoir','BDD');
	$tab[4] = array(time()+ (26 * 24 * 60 * 60),'QCM','Physique');
	$tab[5] = array(time()+ (26 * 24 * 60 * 60),'CF','Math');
	
	//echo "{$tab[0][0]}";
	//echo "{$tab[2][3]}";
	
	//On creer s1 s2 s3 s4
	$s1=0; //nombre d'activitees pour la premiere semaine
	$s2=0; //nombre d'activitees pour la deuxieme semaine
	$s3=0; //nombre d'activitees pour la troisieme semaine
	$s4=0; //nombre d'activitees pour la quatrieme semaine
	
	//On définit la date actuel et les dates des semaines a venir
	$timenow = time();
	$timeaux = $timenow;
	$times1 = $timenow + (7 * 24 * 60 * 60);
	$times2	= $timenow + (14 * 24 * 60 * 60);
	$times3 = $timenow + (21 * 24 * 60 * 60);
	$times4 = $timenow + (28 * 24 * 60 * 60);
	
	//On remplit le nombre d'activitees pour chaques semaines (s1 s2 s3 s4)
	//On fait un while
	$i = 0;
	while (($i < count($tab)) && ($timeaux < $times4)) {
		//On fait un choix sur la date et on incremente la semaine correspondante
		$timeaux = $tab[$i][0];
		if ($timeaux < $times1) {
			$s1++;
		}
		elseif ($timeaux < $times2){
			$s2++;
		}
		elseif ($timeaux < $times3){
			$s3++;
		}
		elseif ($timeaux < $times4){
			$s4++;
		}
		$tab[$i][0] = date("F j, Y, g:i a",$timeaux);
		$i++;
	}
	//fin de la boucle
	
	//On affiche les lignes du tableau
	echo "
	<table border=\"1\">
		<tr>";
			//On met le titre du tableau
			echo "
			<td colspan=\"5\"><center>Tableau de bord Etudiant</center></td> 
		</tr>
		<tr>";
			//On définit les nom des colonnes
			echo "
			<td></td>
			<td><center>Date de fin</center></td>
			<td><center>Type de rendu</center></td>
			<td><center>Matiere</center></td>
		</tr>";
		//On commence la boucle
		for ($i = 0; $i < ($s1+$s2+$s3+$s4); $i++) {
			//On commence la semaine 1			
			if ($i==0){
				echo "
				<tr>
					<td rowspan=\"$s1\">Semaine 1</td>
					<td><center>{$tab[$i][0]}</center></td>
					<td><center>{$tab[$i][1]}</center></td>
					<td><center>{$tab[$i][2]}</center></td>
				</tr>";
				}
			//On affiche qu'une fois semaine 1
			elseif ($i<$s1){
				echo "
				<tr>
					<td><center>{$tab[$i][0]}</center></td>
					<td><center>{$tab[$i][1]}</center></td>
					<td><center>{$tab[$i][2]}</center></td>
				</tr>";
				}
			//On commence la semaine 2
			elseif (($i==$s1)&&($s2!=0)){
				echo "
				<tr>
					<td rowspan=\"$s2\">Semaine 2</td>
					<td><center>{$tab[$i][0]}</center></td>
					<td><center>{$tab[$i][1]}</center></td>
					<td><center>{$tab[$i][2]}</center></td>
				</tr>";
				}
			//On affiche qu'une fois semaine 2
			elseif ($i<($s1+$s2)){
				echo "
				<tr>
					<td><center>{$tab[$i][0]}</center></td>
					<td><center>{$tab[$i][1]}</center></td>
					<td><center>{$tab[$i][2]}</center></td>
				</tr>";
				}
			//On commence la semaine 3
			elseif (($i==$s1+$s2)&&($s3!=0)){
				echo "
				<tr>
					<td rowspan=\"$s3\">Semaine 3</td>
					<td><center>{$tab[$i][0]}</center></td>
					<td><center>{$tab[$i][1]}</center></td>
					<td><center>{$tab[$i][2]}</center></td>
				</tr>";
				}
			//On affiche qu'une fois semaine 3
			elseif ($i<($s1+$s2+$s3)){
				echo "
				<tr>
					<td><center>{$tab[$i][0]}</center></td>
					<td><center>{$tab[$i][1]}</center></td>
					<td><center>{$tab[$i][2]}</center></td>
				</tr>";
				}
			//On commence la semaine 4
			elseif (($i==$s1+$s2+$s3)&&($s4!=0)){
				echo "
				<tr>
					<td rowspan=\"$s4\">Semaine 4</td>
					<td><center>{$tab[$i][0]}</center></td>
					<td><center>{$tab[$i][1]}</center></td>
					<td><center>{$tab[$i][2]}</center></td>
				</tr>";
				}
			//On affiche qu'une fois semaine 4
			else{
				echo "
				<tr>
					<td><center>{$tab[$i][0]}</center></td>
					<td><center>{$tab[$i][1]}</center></td>
					<td><center>{$tab[$i][2]}</center></td>
				</tr>";
				}			
		}
		// fin de la boucle
	
	// L'affichage du tableau est terminer
	echo "</table>";
	


?>