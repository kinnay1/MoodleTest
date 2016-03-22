<?php
	//Le tableau est tab et on l'importe
	//$tab = array();
	$tab = array(); 	
	$tab[0] = array('Date de fin','Type de rendu','Matiere'); //On définit les valeurs affichies sur la premiere ligne du table
	$tab[1] = array(time()+ (4 * 24 * 60 * 60),'DM','TCP/IP');
	$tab[2] = array(time()+ (4 * 24 * 60 * 60),'CF','Math');
	$tab[3] = array(time()+ (8 * 24 * 60 * 60),'Devoir','BDD');
	$tab[4] = array(time()+ (26 * 24 * 60 * 60),'QCM','Physique');
	$tab[5] = array(time()+ (26 * 24 * 60 * 60),'CF','Math');
	
	//On creer un tableau avec les différents parametres a afficher
	$affi = array('','Semaine 1','Semaine 2','Semaine 3','Semaine 4');	
	
	//On creer un tableau part pour savoir le nombre d'activite par semaine
	$part = array(1,0,0,0,0);
		//part[i] = nombre d'activites pour la semaine i 
		//part[O]=1 Pour pouvoir remonter la premiere ligne du tableau qui ne correspond pas a une activite
	
	//On creer un tableau avec la date actuel et les dates des semaines a venir
	$timenow = time();
	$tabtime = array($timenow,$timenow + (7 * 24 * 60 * 60),$timenow + (14 * 24 * 60 * 60),$timenow + (21 * 24 * 60 * 60),$timenow + (28 * 24 * 60 * 60));
	
	//On remplit le nombre d'activitees pour chaques semaines $part
	//On fait un while pour compter le nombre d'activite par semaine
	$i = 1; //On ne compte pas la permiere ligne du tableau (qui n'est pas une activite)
	$timeaux = $tabtime[0]; // On initialise la valeur de l'heure a l'heure actuel
	while (($i < count($tab)) && ($timeaux < $tabtime[4])) {
		//On fait un choix sur la date et on incremente la semaine correspondante
		$timeaux = $tab[$i][0]; //On recupere la date de l'evenement
		for ($j=1;$j<count($tabtime);$j++){ //On fait un for pour afficher tout les cas de $tabtime
			if ($timeaux < $tabtime[$j]){
				$part[$j]++;
				break;
				}
		}
		$tab[$i][0] = date("F j, Y, g:i a",$timeaux);
		$i++;
	}
	
	
	print_r ($part);
?>