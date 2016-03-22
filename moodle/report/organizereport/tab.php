<?php 
	
	//Le tableau est tabimp et on l'importe
	
	$tabimp = array();
	$tabimp[0] = array(time()+ (1 * 24 * 60 * 60),'DM','TCP/IP','<a href="http://www.google.fr" target=blank> DM 0 </a>',0);
	$tabimp[1] = array(time()+ (4 * 24 * 60 * 60),'DM','TCP/IP','DM 3',1);
	$tabimp[2] = array(time()+ (4 * 24 * 60 * 60),'CF','Math','CF1',1);
	$tabimp[3] = array(time()+ (8 * 24 * 60 * 60),'DM','BDD','DM 1',0);
	$tabimp[4] = array(time()+ (26 * 24 * 60 * 60),'QCM','Physique','QCM 2',0);
	$tabimp[5] = array(time()+ (26 * 24 * 60 * 60),'CF','Math','CF2',0);
	$tabimp[6] = array(time()+ (26 * 24 * 60 * 60),'Choix','BDD','Choix SH',0);
	
	//On creer un tableau avec les différents parametres a afficher
	$affi = array('Semaine 1','Semaine 2','Semaine 3','Semaine 4');	
	
	//On creer un tableau part pour savoir le nombre d'activite par semaine
	$part = array(0,0,0,0);
		//part[i] = nombre d'activites pour la semaine i-1
	
	//On creer un tableau avec la date actuel et les dates des semaines a venir
	$timenow = time();
	$tabtime = array($timenow,$timenow + (7 * 24 * 60 * 60),$timenow + (14 * 24 * 60 * 60),$timenow + (21 * 24 * 60 * 60),$timenow + (28 * 24 * 60 * 60));
	
	//On exporte le tableau avec les preferences souhaites
	$tab = array();
	$j=0; // Indice du tableau tab
	for ($i=0;$i<count($tabimp);$i++){
		if ($tabimp[$i][4] == 0){ //On met nos conditions ici !
			$tab[$j]=$tabimp[$i];
			$j++;
		}
	}
	unset($j);
	
	//On remplit le nombre d'activitees pour chaques semaines $part
	//On fait un while pour compter le nombre d'activite par semaine
	$i = 0;
	$timeaux = $tabtime[0]; // On initialise la valeur de l'heure a l'heure actuel
	while (($i < count($tab)) && ($timeaux < $tabtime[4])) {
		//On fait un choix sur la date et on incremente la semaine correspondante
		$timeaux = $tab[$i][0]; //On recupere la date de l'evenement
		for ($j=1;$j<count($tabtime);$j++){ //On fait un for pour afficher tout les cas de $tabtime
			if ($timeaux < $tabtime[$j]){
				$part[$j-1]++;
				break;
				}
		}
		$tab[$i][0] = date("l d/m H:i",$timeaux);
		$i++;
	}
	unset($i);
	unset($timeaux);
	//fin de la boucle
	
	//On affiche les lignes du tableau
	
	//On commence par l'en-tete du tableau
	echo "
	<table>		
		<thead>
			<tr>
				<td colspan=\"5\" class=\"titre\"><center>Tableau de bord Etudiant</center></td> 
			</tr>
			<tr>
				<td></td>
				<td><center>Date de fin</center></td>
				<td><center>Type de rendu</center></td>
				<td><center>Matiere</center></td>
				<td><center>Nom</center></td>
			</tr>
		</thead>";
		// Si on veut faire le pied du tableau
		//<tfoot>
		//	<tr>
		//		<th>Nom</th>
		//		<th>Âge</th>
		//		<th>Pays</th>
		//	</tr>
		//</tfoot>
		
		//On affiche le reste du tableau ($tab) dans la partie corps
		echo"
			<tbody>
		";
		$l=0; //Indice pour savoir dans quel part on est
		$non_affi=True; //Boolean qui indique si la ligne du tableau $affi a été afficher
		//On fait une boucle for pour resortir toutes les infos du tableau
		for ($i = 0; $i < array_sum($part); $i++) { //On s'arrete lorsqu'on a sorti toutes les informations du tableau ($part)
			for ($j=0;$j<count($part);$j++){ //On fait un for pour afficher tout les cas de $part
				$sum=0; //Somme des j premiers elements du tableau $part
				for($k=0;$k<=$j;$k++){
					$sum=$sum+$part[$k];
				}
				if ($i<$sum){	//On regarde dans quel semaine on est
					if($j!=$l){	//On regarde si l'activite est dans la meme semaine que la precedente pour afficher ou non le semaine ($affi)
						$non_affi=True;
						$l=$j;
					}	
					//On ouvre la ligne du tableau
					echo " 
						<tr>
					";
					//On affiche ou non la semaine
					if ($non_affi){
						echo "
							<td rowspan=".$part[$j].">{$affi[$j]}</td>
						";
						$non_affi=False; //Une fois affiché on note celà
					}
					//On affiche les informations des activites
					echo"
						<td><center>{$tab[$i][0]}</center></td>
						<td class=".$tab[$i][1]."><center>{$tab[$i][1]}</center></td>
						<td class=".$tab[$i][1]."><center>{$tab[$i][2]}</center></td>
						<td class=".$tab[$i][1]."><center>{$tab[$i][3]}</center></td>
					</tr>						
					";
					$non_affi=False;					
					break;
				}
			}
		}
		// fin de la boucle
		unset($l);
		echo"
			</tbody>
		";
		
	
	// L'affichage du tableau est terminer
	echo "</table>";
?>