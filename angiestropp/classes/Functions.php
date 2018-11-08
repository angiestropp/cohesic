<?php
require_once 'DB.php';
# ==============================================================================
# Author: Angie Stropp
# URL: http://www.angiestropp.com
#
# Namespace:
# Class: Functions
# Description: Class for various helper functions.
# Notes: All methods and properties are static.
# @param: 
# ==============================================================================
class Functions {

	/* 2.b) When an item is deselected, all of its descendants should be deselected */
	public static function unCheckDescendants($r){
		$db = new DB();
		$parentId = $r['id'];
		$parentLevel = $r['level'];
		$childLevel = ($parentLevel+1);
		$table = 'level'.$childLevel;
		$where = "parentId='$parentId'";

		$result = Functions::getRecord($table,$where);
		if(!empty($result)){ 
			foreach($result as $row){
				$id = $row['id'];
				$where = "parentId='$parentId' AND id='$id'";
				$row['checked'] = '0';
				Functions::updateRecord($row,$table,$where);
				if($row['hasChild'] == 1){
					Functions::unCheckDescendants($row);
				}
			}
		}
	}

	/* 2.a) When an item is selected, all of its ancestors should be selected */
	public static function checkAncestors($r){
		$db = new DB();
		$tmp = $r['parentId'];
		while($tmp > 0){
			$id = $r['parentId'];
			$table = 'level' . ($r['level'] - 1);
			$where = "id='$id'";
			$result = Functions::getRecord($table,$where);
			foreach($result as $r){
				$tmp = $r['parentId'];
				$r['checked'] = '1';
				Functions::updateRecord($r,$table,$where);
			}
		}
	}
	# ==========================================================================
	# Function: updateRecord
	# Description: Write the update to the database.
	# Notes: 
	# @param: array - the updated record
	# @param: string - the table name
	# @param: string - the WHERE clause
	# @return: 
	# ==========================================================================
	public static function updateRecord($r,$t,$w){
		$db = new DB(); # database object
		$db->update($r,$t,$w); # write to database
	}
	# ==========================================================================
	# Function: getRecord
	# Description: Get the record to be modified.
	# Notes: 
	# @param: string - the table name
	# @param: string - the WHERE clause
	# @return: array - the record
	# ==========================================================================
	public static function getRecord($t,$w){
		$db = new DB(); # database object
		$result = $db->select($t,$w);
		if(empty($result)){ 
			$result = array();
		}else{
			if(Functions::isMultidimensionalArray($result) === false){
				# make sure we have a multidimensional array
				$result = Functions::makeMultidimensionalArray($result);
			} # IF END
		}
		return $result;
	}
	# ==========================================================================
	# Function: writeLine
	# Description: Build the html to be output to the screen.
	# Notes: 
	# @param: array - the record
	# @return: string - the html output
	# ==========================================================================
	public static function writeLine($r){
		# variables
		$id = $r['id'];
		$title = $r['title'];
		$checked = ($r['checked'] == 1) ? 'checked' : '' ;
		$level = $r['level'];
		$hasChild = $r['hasChild'];
		$parentId = $r['parentId'];
		$class = 'level-'.$level;
		$identifier = $level.'-'.$id;
		/* 2) Allow for selecting or deselecting an item in the hierarchy (checkbox) */
		$html = "<div class='$class'>
						<input id='$identifier' name='$identifier' type='checkbox' $checked onclick='saveChange(id)'>
						<label for='$identifier'>$title</label>
						</div>
					 ";
		return $html;
	}
	# ==========================================================================
	# Function: getHierarchy
	# Description: Return the result set for given parameters.
	# Notes: 
	# @param: string - the level in the hierarchy
	# @param: array - the record
	# @return: array - the result set
	# ==========================================================================
	public static function getHierarchy($l,$r){
		# variables
		$table = 'level'.$l;
		$where = '1';
		if($r != null){
			$id = $r['id'];
			$where = "parentId='$id'";
		}
		$db = new DB(); # database object
		$result = $db->select($table,$where); # get the data
		if(empty($result)){ 
			$result = array(); # make sure we have an array even if empty
		}else{
			if(Functions::isMultidimensionalArray($result) === false){
				# make sure we have a multidimensional array
				$result = Functions::makeMultidimensionalArray($result);
			} # IF END
		} # ELSE END
		return $result;
	}
	# ==========================================================================
	# Function: makeMultidimensionalArray
	# Description: Transform regular array into multidimensional array.
	# Notes: 
	# @param: array - the array to transform
	# @return: array - multidimensional array
	# ==========================================================================
	public static function makeMultidimensionalArray($array) {
		$tmp = array();
		$tmp[0] = $array;
		$result = $tmp;
		return $result;
	}
	# ==========================================================================
	# Function: isMultidimensionalArray
	# Description: Determin if parameter is multidimensional.
	# Notes: 
	# @param: array - the array to test
	# @return: bool false - $array is NOT multidimensional
	#          bool true - $array IS multidimensional
	# ==========================================================================
	public static function isMultidimensionalArray($array) {
		if((count($array) == count($array,COUNT_RECURSIVE))){
			return false; # $array is NOT multidimensional
		}
		return true;
	}
}