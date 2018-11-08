<?php
# ==============================================================================
# Author: Angie Stropp
# URL: http://www.angiestropp.com
#
# Save any changes made by the user.
# ==============================================================================
require_once 'classes/Functions.php';
# parameters
$id = $_REQUEST['id'];
$level = $_REQUEST['level'];
$checked = $_REQUEST['checked'];
# variables
$table = "level".$level;
$where = "id='$id'";
$result = Functions::getRecord($table,$where); # the record that was clicked on
if(!empty($result)){ 
	foreach($result as $row){
		$row['checked'] = $checked; # the new value
		Functions::updateRecord($row,$table,$where); # write the new value to the database
		if($checked == 1){
			# if the record was checked, deal with the ancestors
			Functions::checkAncestors($row);
		}else{
			# if the record was un-checked and has children, deal with the descendants
			if($row['hasChild'] == 1){
				Functions::unCheckDescendants($row);
			}
		}
	}
}
?>