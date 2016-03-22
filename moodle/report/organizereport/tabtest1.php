<?php
	$tab = array(); 	
	$tab[0] = array(time()+ (4 * 24 * 60 * 60),'CF','TCP/IP');
	$tab[1] = array(time()+ (4 * 24 * 60 * 60),'DM','TCP/IP');
	$tab[2] = array(time()+ (4 * 24 * 60 * 60),'CF','Math');
	
	echo "{$tab[0][0]}";
	echo $tab[2][2];
?>