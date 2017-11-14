<?php
class Model {
    private static $connection = null;
    protected $affected_rows = 0;
    public $last_inserted_id = 0;
  
    private static function connect() {
        try {
            $db = array(
                'host' => 'localhost',
				'db' => 'ayfcamp',
				'user' => 'root',
				'password' => ''
            );
          
            self::$connection = new mysqli($db['host'], $db['user'], $db['password'],$db['db']);
            //mysql_select_db($db['db'], self::$connection);  
        }
        catch (Exception $e) {
            quickLog("MySQL error --> {$e->getMessage()}");
            return false;
        }
        return true;
    }
    
    protected function find($sql) {
        $result = array();
        if (!is_resource(self::$connection )) {
            $mysqli = self::connect();   
        }
        
        if ($result === false) {
            quickLog("Unable to connect to database connect method retured false.");
            return array();
        }
        
        $resource = mysqli_query(self::$connection,$sql);
        
        if (!$resource) {
            #print $sql;
            quicklog(mysqli_error(self::$connection));
            return array();
        }
        $result = array();
        
        while($row = mysqli_fetch_assoc($resource)) {
            $result[] = $row;
        }
        
        return $result;
    }
  
    protected function execute($sql) {
        $this->last_inserted_id = 0;
        $this->affected_rows = 0;
        $result = '';
        if (!is_resource(self::$connection)) {
            $mysqli = self::connect();   
        }
        
        if ($result === false) {
            quickLog("Unable to connect to database connect method retured false.");
            return false;
        }
        $result = mysqli_query(self::$connection,$sql);
        if (!$result) {
            quickLog("MySQL error --> " . mysqli_error(self::$connection));
            return false;
        }
        $this->last_inserted_id = mysqli_insert_id(self::$connection);
        $this->affected_rows = mysqli_affected_rows(self::$connection);
        return true; 
    }
    
    public static function escape($text) {
        if (!is_resource(self::$connection )) {
            $mysqli = self::connect();   
        }
        return  self::$connection->real_escape_string($text);
    }
}
?>
