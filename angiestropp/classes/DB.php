<?php
# ==============================================================================
# Author: Angie Stropp
# URL: http://www.angiestropp.com
#
# Namespace:
# Class: DB
# Description: Class to handle database operations.
# Notes: Database credentials are located in config.ini file.
#        Debugging Tool: $this->consoleLog($data)
# @param: 
# ==============================================================================
class DB {
	// ============================== PROPERTIES ===============================
  // The database connection
  protected static $connection;
  // The last ID created by insert() function
  protected $last_insert_id;

	// ============================ PUBLIC METHODS =============================
  # ==========================================================================
	# Function: connect
	# Description: Connect to the database.
	# Notes:
	# @param: 
	# @return: bool false on failure / mysqli object instance on success.
	# ==========================================================================
  public function connect() {    
    // Try and connect to the database
    if(!isset(self::$connection)) {
      // Get current directory to determine path to ini file
      $dir = substr(getcwd(),strrpos(getcwd(),DIRECTORY_SEPARATOR)+1);
      // Load configuration as an array.
      if($dir == 'include' || $dir == 'php' || $dir == 'forms' || $dir == 'admin'){
        $config = parse_ini_file('../ini/config.ini');
      }else{
        $config = parse_ini_file('ini/config.ini');
      }
      self::$connection = new mysqli($config['host'],$config['username'],$config['password'],$config['database']);
    }

    // If connection was not successful
    if(self::$connection === false) {
      // TODO: Handle error - notify administrator, log to a file, show an error screen, etc.
      return false;
    }
    return self::$connection;
  }

  # ==========================================================================
  # Function: getLastInsertId
  # Description: Return the last ID created by the insert() function.
  # Notes:
  # @param: 
  # @return: Last insert id.
  # ==========================================================================
  public function getLastInsertId() {
    return $this->last_insert_id;
  }

	# ==========================================================================
	# Function: processResult
	# Description: Turns a result set into an associative array where the keys
	#              in the array are the column names of the table.
	# Notes:
	# @param: $result - The result set.
	# @return: associative array containing the result set.
	# ==========================================================================
  public function processResult($result) {
		$resultArray = array();
    while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
      array_push($resultArray, $row);
    }
    if(mysqli_num_rows($result) == 1){
      return $resultArray[0];
    }
    return $resultArray;
  }   

  # ==========================================================================
  # Function: queryDB
  # Description: Query the database.
  # Notes:
  # @param: string - The query.
  # @return: The result set.
  # ==========================================================================
  public function queryDB($query) {
    // Connect to the database
    $con = $this->connect();
    // Query the database
    $success = mysqli_query($con,$query);
    return $success;
  }

  # ==========================================================================
  # Function: encodeString
  # Description: Create a legal SQL string to use in an SQL statement.
  # Notes: The given string is encoded to an escaped SQL string, taking into
  #        account the current character set of the connection. (To protect
  #        from MySQL injections.) The string is also put in quotes before
  #        being returned.
  # @param: string - The value.
  # @return: string - The encoded value.
  # ==========================================================================
  public function encodeString($value) {
    $dbh = $this->connect();
    $value = trim($value," ");
    $value = stripslashes($value);
    $value = mysqli_real_escape_string($dbh, $value);
    $value = "'$value'";
    return $value;
  }

  # ==========================================================================
  # Function: distinctSelect
  # Description: Select row(s) from the database where the column is distinct.
  # Notes:
  # @param: $columns - The table column.
  # @param: $table - The table name.
  # @param: $where - The where clause.
  # @return: associative array - empty on failure OR where the keys in the
  #                              array are the column names of the table.
  # ==========================================================================
  public function distinctSelect($column, $table, $where) {
    if($where == "") {
      $query = "SELECT DISTINCT $column FROM $table";
    }else {
      $query = "SELECT DISTINCT $column FROM $table WHERE $where";
    }
    return $this->processResult($this->queryDB($query));
  }

  # ==========================================================================
  # Function: joinedSelect
  # Description: Select row(s) from the database where tables are joined.
  # Notes:
  # @param: $columns - The table columns.
  # @param: $table - The table name.
  # @param: $join - The join statement.
  # @param: $where - The where clause.
  # @return: associative array - empty on failure OR where the keys in the
  #                              array are the column names of the table.
  # ==========================================================================
  public function joinedSelect($columns, $table, $join, $where) {
    $query = "SELECT $columns FROM $table $join";
    if($where != ''){$query .= " WHERE $where";}

    return $this->processResult($this->queryDB($query));
  }

  # ==========================================================================
  # Function: customSelect
  # Description: Select row(s) from the database.
  # Notes:
  # @param: $columns - The table columns.
  # @param: $table - The table name.
  # @param: $where - The where clause.
  # @return: associative array - empty on failure OR where the keys in the
  #                              array are the column names of the table.
  # ==========================================================================
  public function customSelect($columns, $table, $where) {
    if($where == "") {
      $query = "SELECT $columns FROM $table";
    }else {
      $query = "SELECT $columns FROM $table WHERE $where";
    }
    return $this->processResult($this->queryDB($query));
  }

	# ==========================================================================
	# Function: select
	# Description: Select row(s) from the database.
	# Notes:
	# @param: $table - The table name.
	# @param: $where - The where clause.
  # @return: associative array - empty on failure OR where the keys in the
  #                              array are the column names of the table.
	# ==========================================================================
  public function select($table, $where) {
    if($where == "") {
    	$query = "SELECT * FROM $table";
    }else {
    	$query = "SELECT * FROM $table WHERE $where";
    }
    return $this->processResult($this->queryDB($query));
  }

	# ==========================================================================
	# Function: update
	# Description: Update a row in the database.
	# Notes:
	# @param: $data - Associative array of data.
	#				  Key = Column Name.
	#				  Value = Data.
	# @param: $table - The table name.
	# @param: $where - The where clause.
	# @return: bool false - on failure.
	#          bool true - on success.
	# ==========================================================================
  public function update($data, $table, $where) {
    foreach ($data as $column => $value) {
      # To protect from MySQL injections
      $value = $this->encodeString($value);
      $query = "UPDATE $table SET $column=$value WHERE $where";
      $update = $this->queryDB($query);
      if($update === false) {
        // return the error
        $error = mysqli_error($this->connect());
        return $error;
      }
    }
    return true;
  }

  # ==========================================================================
  # Function: insert
  # Description: Create a row in the database.
  # Notes: This function also retrieves the last insert id created and saves
  #        that value in the last_insert_id variable.
  # @param: $data - Associative array of data.
  #                 Key = Column Name.
  #                 Value = Data.
  # @param: $table - The table name.
  # @return: bool false - on failure.
  #          bool true - on success.
  # ==========================================================================
  public function insert($data, $table) {
    $columns = ''; $values = '';
    foreach ($data as $column => $value) {
      if($column == 'id' && $value == ''){
        # Skip id if blank or we get error:
        # incorrect integer value '' for column 'id' at row 1
        continue;
      }
      $columns .= ($columns == "") ? "" : ", ";
      $columns .= $column;
      $values .= ($values == "") ? "" : ", ";
      # To protect from MySQL injections
      $value = $this->encodeString($value);
      $values .= $value;
    }
    $query = "INSERT INTO $table ($columns) VALUES ($values)";
    $insert = $this->queryDB($query);
    if($insert === false) {
      // return the error
      $error = mysqli_error($this->connect());
      return $error;
    }
    $this->last_insert_id = mysqli_insert_id($this->connect());
    return true;
  }

  # ==========================================================================
  # Function: delete
  # Description: Delete row(s) from the database.
  # Notes:
  # @param: $table - The table name.
  # @param: $where - The where clause.
  # @return: bool false - on failure.
  #          bool true - on success.
  # ==========================================================================
  public function delete($table, $where) {
    // Connect to the database
    $con = $this->connect();
    // Build the query string
    $query = "DELETE FROM $table WHERE $where";
    // Query the database
    $delete = mysqli_query($con,$query);
    if($delete === false) {
      // return the error
      $error = mysqli_error($this->connect());
      return $error;
    }
    return true;
  }

  # ==========================================================================
  # Function: joinedCount
  # Description: Count row(s) from the database.
  # Notes:
  # @param: $table - The table name.
  # @param: $where - The where clause.
  # @return: integer - The number of records
  # ==========================================================================
  public function joinedCount($table, $join, $where) {
    // Connect to the database
    $con = $this->connect();
    // Build the query string
    if($where == "") {
      $query = "SELECT count(*) FROM $table $join";
    }else {
      $query = "SELECT count(*) FROM $table $join WHERE $where";
    }
    // Query the database
    $result = mysqli_query($con,$query);
    $row = $result->fetch_row();
    return $row[0];
  }

  # ==========================================================================
  # Function: count
  # Description: Count row(s) from the database.
  # Notes:
  # @param: $table - The table name.
  # @param: $where - The where clause.
  # @return: integer - The number of records
  # ==========================================================================
  public function count($table, $where) {
    // Connect to the database
    $con = $this->connect();
    // Build the query string
    if($where == "") {
      $query = "SELECT count(*) FROM $table";
    }else {
      $query = "SELECT count(*) FROM $table WHERE $where";
    }
    // Query the database
    $result = mysqli_query($con,$query);
    $row = $result->fetch_row();
    return $row[0];
  }

  # ==========================================================================
  # Function: average
  # Description: Get average of specified column.
  # Notes: 
  # @param: $column - the column to calculate the average for.
  # @return: decimal - the average rating.
  # ==========================================================================
  public function average($table, $column) {
    // Connect to the database
    $con = $this->connect();
    // Build the query string
    $query = "SELECT avg($column) FROM $table";
    // Query the database
    $result = mysqli_query($con,$query);
    $row = $result->fetch_row();
    return $row[0];
  }


  // ============================ PRIVATE METHODS ============================
  # ==========================================================================
  # Function: consoleLog
  # Description: Print out to the browsers Javascript console.
  # Notes: Debugging Tool
  # @param: 
  # @return: 
  # ==========================================================================
  private function consoleLog($data) {
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
  }
  # ==========================================================================
  # Function: toConsole
  # Description: Print out to the browsers Javascript console.
  # Notes: Debugging Tool choice # 2
  # @param: 
  # @return: 
  # ==========================================================================
  private function toConsole($data) {
    if(is_array($data) || is_object($data)) {
      echo("<script>console.log('PHP: ".json_encode($data)."');</script>");
    } else {
      echo("<script>console.log('PHP: ".$data."');</script>");
    }
  }
}
?>