<?php

class WebsiteUser {
    /* Host address for the database */
    protected static $DB_HOST = "127.0.0.1";
    /* Database username */
    protected static $DB_USERNAME = "ukgvehvrmw4he";
    /* Database password */
    protected static $DB_PASSWORD = "Bhavay@123";
    /* Name of database */
    protected static $DB_DATABASE = "dberbcw9dgkvwt";

    private $mysqli;
    private $dbError = false;
    private $authenticated = false;
    private $username;

    function __construct() {
        $this->mysqli = new mysqli(self::$DB_HOST, self::$DB_USERNAME, 
                self::$DB_PASSWORD, self::$DB_DATABASE);
        if($this->mysqli->errno){
            $this->dbError = true;
        }else{
            $this->dbError = false;
        }
    }

    public function authenticate($username, $password){
    // Prepare the SQL query with placeholders
    $loginQuery = "SELECT * FROM adminusers WHERE Username = ? AND Password = ?";
    
    // Prepare the statement
    $stmt = $this->mysqli->prepare($loginQuery);
    
    if (!$stmt) {
        // Query preparation failed
        error_log("Query preparation failed: " . $this->mysqli->error);
        return null;
    }
    
    // Bind the parameters
    $stmt->bind_param('ss', $username, $password);
    
    // Execute the query
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    if($result->num_rows == 1){
        // Authentication successful
        $this->username = $username;
        $this->authenticated = true;
    } else {
        // Authentication failed
        return null;
    }
    
    $stmt->free_result();
}

    public function updateLoginTime($username) {
        $sqlQuery = "UPDATE adminusers SET Lastlogin = NOW() WHERE Username = ?";
        $stmt = $this->mysqli->prepare($sqlQuery);
        $stmt->bind_param('s', $username);
        $stmt->execute();
    }

    public function isAuthenticated() {
        return $this->authenticated;
    }

    public function hasDbError() {
        return $this->dbError;
    }

    public function getUsername() {
        return $this->username;
    }
}

?>
