<?php
# ==============================================================================
# Author: Angie Stropp
# URL: http://www.angiestropp.com
#
# 1) Display the hierarchy of the gross chest anatomy as a checklist.
# ==============================================================================
require_once 'classes/Functions.php';

$result = Functions::getHierarchy(1,null);
foreach($result as $row){
	//level 1
	echo Functions::writeLine($row);
	//level 2
	$resultLevel2 = Functions::getHierarchy(2,$row);
	foreach($resultLevel2 as $rowLevel2){
		echo Functions::writeLine($rowLevel2);
		//level 3
		$resultLevel3 = Functions::getHierarchy(3,$rowLevel2);
		foreach($resultLevel3 as $rowLevel3){
			echo Functions::writeLine($rowLevel3);
			//level 4
			$resultLevel4 = Functions::getHierarchy(4,$rowLevel3);
			foreach($resultLevel4 as $rowLevel4){
				echo Functions::writeLine($rowLevel4);
			} # FOREACH END
		} # FOREACH END
	} # FOREACH END
}; # FOREACH END
?>