<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Displays some overview statistics for the site
 *
 * @package     report_organizereport
 * @school      Télécom SudParis France
 * @copyright   2015 BAKARI Houssem <baccarihoucem21@gmail.com>
				     ALIMI Marwa <>
					 BEN CHEIKH BRAHIM Amine <>
					 CHOUCHANE Rania <chouchene.rania2013@gmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require(__DIR__.'/../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->dirroot.'/report/organizereport/locallib.php');

include($CFG->dirroot.'/report/organizereport/pChart2.1.4/class/pData.class.php');
include($CFG->dirroot.'/report/organizereport/pChart2.1.4/class/pDraw.class.php');
include($CFG->dirroot.'/report/organizereport/pChart2.1.4/class/pRadar.class.php');
include($CFG->dirroot.'/report/organizereport/pChart2.1.4/class/pImage.class.php');

global $PAGE;

echo "<!DOCTYPE html> 
<html> 
    <head> 
        <script src=\"charts4php/lib/js/jquery.min.js\"></script> 
        <script src=\"charts4php/lib/js/chartphp.js\"></script> 
        <link rel=\"stylesheet\" href=\"charts4php/lib/js/chartphp.css\"> 
		<link rel=\"stylesheet\" href=\"design.css\"> 
		
		<script type=\"text/javascript\">
                 function unhide(divID) {
                 var item = document.getElementById(divID);
                 if (item) {
                       item.className=(item.className=='hidden')?'unhidden':'hidden';
                 }
                }
        </script>
			
    </head> 
    <body> ";
	

	
	
	
	
$userid = optional_param('userid', null, PARAM_INT);

if (is_null($userid)) {
    // extract student id
    $userid=$USER->id;
} 
require_login();


    // check that the user has the right to access this page
    $theuser = $DB->get_record('user', array('id' => $userid), '*', MUST_EXIST);  //does the id exists in the database
    $usercontext = CONTEXT_USER::instance($theuser->id);

	$PAGE->set_pagelayout('report');
	$PAGE->set_context(context_system::instance());
    $PAGE->set_url(new moodle_url('/report/organizereport/index.php', array('userid' => $theuser->id)));
	$PAGE->set_title(get_string('pluginname', 'report_organizereport'));
	$PAGE->set_heading(get_string('pluginname', 'report_organizereport'));
    echo $OUTPUT->header();
    


	/*extaction of all courses (id and names) that this user is rolled in */
    $courseListDisplay = report_course_manager::get_course_list($theuser->id,$DB);
	/*extaction of all domaines */
	$courseListDomaine = report_course_manager::extract_list_domaine( $courseListDisplay,$DB);
	/*mapping courses et domaines*/
	$courseListFinal = report_course_manager::mapping_final_course_domaine($courseListDisplay,$courseListDomaine);
		
	/*extraction of the activities related to the course : id,name,maximum_mark, student_mark*/
	$listiditems=report_activities_manager::extract_items_id_list_from_db($courseListDisplay,$DB);
	$listname=report_activities_manager::extract_info_grades_list_from_db($listiditems,$DB);
	$listgradeuser=report_activities_manager::extract_user_grades_list_from_db($listiditems,$theuser->id,$DB);
	
	/*Final table with activities information and the student's marks in every activity*/
	$listitems=report_activities_manager::mapping_data_activities($listiditems,$listname,$listgradeuser,$DB);
	
	
    /*arrays for the radar chart*/
	$tabModule=array();
	$tabNote=array();
	$tabMoyenne=array();
	
	
	foreach($courseListDomaine as $key1=>$var1){
		echo "<div id=\"cadreDomaine\"><a href=\"javascript:unhide('__".$key1."');\"><font color=\"white\">$var1</font></a><br /></div>\n"; // affichage nom domaine
		echo "<div id=\"__".$key1."\" class=\"hidden\">";
		
		if(is_array($courseListFinal) and $courseListFinal!=null){
			$count_cor=0;// calculer nombre de module dans le domaine courant
		foreach($courseListFinal as $var2){
			if($var2["domaine"]==$var1){
				$count_cor++;
				$id_course=$var2["id"];
				echo "<div id=\"cadreModule\"><a href=\"javascript:unhide('".$id_course."');\"><img src=\"graphix/staticon.png\" height=\"15\" width=\"15\"><font color=\"white\">".$var2["shortname"] ." : " .$var2["fullname"] ."</font></a><br /></div>\n"; //affichage nom du module
				
			
			
				if(is_array($listitems) and $listitems!=null){
					
				$stringOutPut="<table class=\"tg\"><tr><th class=\"tg-s6z2\">N°</th><th class=\"tg-s6z2\">nom activité</th><th class=\"tg-s6z2\">activité noté sur</th><th class=\"tg-s6z2\">moyenne</th><th class=\"tg-s6z2\">note finale</th><th class=\"tg-s6z2\">note min</th><th class=\"tg-s6z2\">note max</th></tr>";

					$count_act=0;// Number of activities in every course
					$nbSupMoy=0; // Number of activities with a mark higher than the average
					foreach($listitems as $var3){
						if($var3["courseid"]==$var2["id"]){
							$stringOutPut=$stringOutPut."<tr>";
							$count_act++;
							$userGrade=$var3["finalgrade"];
							$Gavg=$var3["avgg"];
							$ecartType=$var3["ecart"];
							$itemname=$var3["itemname"];
							
                            $tabNote[]=$userGrade;							
							$tabModule[]=$itemname;
							$tabMoyenne[]=$Gavg;
							
							
							$stringOutPut=$stringOutPut."<td class=\"tg-s6z2\">".$count_act."</td>";
							$stringOutPut=$stringOutPut."<td class=\"tg-s6z2\">".$itemname."</td>";
							$stringOutPut=$stringOutPut."<td class=\"tg-s6z2\">".number_format($var3["grademax"], 2, ',', '')."</td>";
							$stringOutPut=$stringOutPut."<td class=\"tg-s6z2\">".number_format($var3["avgg"], 2, ',', '')."</td>";
														if($userGrade<$Gavg-$ecartType){ 
															$stringOutPut=$stringOutPut."<td class=\"coloring\">".number_format($userGrade, 2, ',', '')."  <img src=\"graphix/level0.png\" height=\"20\" width=\"20\"></td>";}
														else if($userGrade>=$Gavg-$ecartType and $userGrade<$Gavg-($ecartType/3)){
															$stringOutPut=$stringOutPut."<td class=\"coloring\">".number_format($userGrade, 2, ',', '')."  <img src=\"graphix/level1.png\" height=\"20\" width=\"20\"></td>";
															$nbSupMoy+=0.25;}
														else if($userGrade>=$Gavg-($ecartType/3) and $userGrade<=$Gavg+($ecartType/3)){
															$stringOutPut=$stringOutPut."<td class=\"coloring\">".number_format($userGrade, 2, ',', '')."  <img src=\"graphix/level2.png\" height=\"20\" width=\"20\"></td>";
															$nbSupMoy+=0.5;}
														else if($userGrade>$Gavg+($ecartType/3) and $userGrade<=$Gavg+$ecartType){
															$stringOutPut=$stringOutPut."<td class=\"coloring\">".number_format($userGrade, 2, ',', '')."  <img src=\"graphix/level3.png\" height=\"20\" width=\"20\"></td>";
															$nbSupMoy+=0.75;}
														else {
															$stringOutPut=$stringOutPut."<td class=\"coloring\">".number_format($userGrade, 2, ',', '')."  <img src=\"graphix/level4.png\" height=\"20\" width=\"20\"></td>";
															$nbSupMoy+=1;
														}
							
							$stringOutPut=$stringOutPut."<td class=\"tg-s6z2\">".number_format($var3["maxg"], 2, ',', '')."</td>";
							$stringOutPut=$stringOutPut."<td class=\"tg-s6z2\">".number_format($var3["ming"], 2, ',', '')."</td>";

							
						}
					}
					$stringOutPut=$stringOutPut."</table>";
					
					if($count_act==0){
						echo "<div id=\"".$id_course."\" class=\"hidden\">".get_string('S_noact', 'report_organizereport')."</div>";////
					}else{
									
									
									$perfor=$nbSupMoy/$count_act;
									$string_perfor="";
									if($perfor<0.2){$string_perfor=$string_perfor."<div>Faible    <img src=\"graphix/level0.png\" height=\"40\" width=\"40\"></div>";}
									else if($perfor>=0.2 and ($perfor<0.4)){$string_perfor=$string_perfor."<div>Passable   <img src=\"graphix/level1.png\" height=\"40\" width=\"40\"></div>";}
									else if($perfor>=0.4 and ($perfor<0.6)){$string_perfor=$string_perfor."<div>Assez Bien   <img src=\"graphix/level2.png\" height=\"40\" width=\"40\"></div>";}
									else if($perfor>=0.6 and ($perfor<0.8)){$string_perfor=$string_perfor."<div>Bien   <img src=\"graphix/level3.png\" height=\"40\" width=\"40\"></div>";}
									else{$string_perfor=$string_perfor."<div>Excellent   <img src=\"graphix/level4.png\" height=\"40\" width=\"40\"></div>";}
						  
									
									
									
									
									
									$stringOutFinal="<div style=\"margin-left: 150px\" id=\"".$id_course."\" class=\"hidden\">".$stringOutPut."<img style=\"margin: 20px 0px 20px 0px\" src=\"".$pictureName."\" height=\"399\" width=\"799\"></div>";
									echo $stringOutFinal;
									
					}
					
					
				}else{
					echo "<div id=\"".$id_course."\" class=\"hidden\">".get_string('S_noact', 'report_organizereport')."</div>";////
				}
				
				
				
				
			}
		}
			 if($count_cor==0){
				 echo get_string('S_nocourse', 'report_organizereport');////
			 }
		}else{
			echo get_string('S_nocourse', 'report_organizereport');////
		}
	
     echo "</div>";
	
	}


echo $OUTPUT->footer();
echo "</body> 
</html>"	;
 
