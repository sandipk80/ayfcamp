<?php
class GlobalManager extends Model {
	private static $instance = null;
	public $user_where = '1';  
	protected function __construct() {
	}  
  
	public static function getInstance() {
		if (self::$instance == null) {
		  self::$instance = new self();
		}
		return self::$instance;
	}
	
	/**
	 * Function for get paging list
	 *
	 *  @param $table Table name
	 *  @param $fields Table fields to be updated
	 *  @param $count if result count needed
	 *  @param $where condition for search
	 *  @param $limit limit per page
	 *  @param $sortBy sort order field
	 *  @param $sortOrder order by eg. DESC or ASC	 * 
	 *  @return true on success, or false on error
	 */        
	public function getPagingRecord($table, $fields, $count=false, $where='', $limit='', $sortBy='', $sortOrder='',$groupBy='') { 	
		if($count == true){
			$query = "SELECT count(".$fields.") as total FROM ".$table;
			if($where !=""){
				$query .= " WHERE ". $where;
			}
		} else{
			$query = "SELECT ".$fields." FROM ".$table;		
			if($where !=""){
				$query .= " WHERE ". $where;
			}
			if($groupBy !="" && $groupBy != ""){
				$query .= " GROUP BY ". $groupBy;
			}
			if($sortBy !="" && $sortOrder != ""){
				$query .= " ORDER BY ". $sortBy . "  ". $sortOrder;
			}	
			if($limit !=""){
				$query .= " LIMIT  ". $limit;
			}			
		}
		//pr($query);
		$result = $this->find($query);
		if (count($result) > 0) {
			return $result;
		} else {	
			return false;
		}
	}
		
	/**
	 * create and executes an SELECT query in the database 
	 *
	 * @access public	 * @param $table Table name
	 * @param $fields Table fields to be updated
	 * @param $values Coressponding values
	 * @param $where Where statement	
	 *
	 * @return true on success, or false on error
	 */
	public function runSelectQuery($table, $fields, $where) {
		$query = "SELECT ".$fields." FROM ".$table;	
		if($where !=""){
			$query .= " WHERE ". $where;
		}
		//pr($query);
		$result = $this->find($query);
		if (count($result) > 0) {
			return $result;
		}
		else {
			return false;
		}
	}
	
	/**
	 * executes an DELETE query in the database
	 * @access public
	 * @param $where The SQL condition query to execute	
	 *
	 * @return true on success, or false on error
	 */
	public function runDeleteQuery($table,$where) {
		if($table!=='' && $where!=='') {
			$query = "DELETE FROM ".$table." WHERE ".$where;
			//prx($query);
			$result = parent::execute($query);
			if ($result) {
				return true;
			}
			else {
				return false;
			}
		}
		else {	
			return false;
		}
	}	
	/**
	 * create and executes an UPDATE query in the database 
	 *
	 * @access public
	 * @param $table Table name
	 * @param $valuesfields Table fields array to be updated	 
	 * @param $where Where statement	
	 *
	 * @return true on success, or false on error
	 */
	public function runUpdateQuery($table, $valuesfields, $where) {	
		$cond='';
		if(is_array($valuesfields) && count($valuesfields)>0) {
			$query = "UPDATE ".$table." SET ";
			foreach($valuesfields as $key=>$val) {
				$cond .=$key."='".addslashes($val)."',";
			}			
			$query .=rtrim($cond,",")." WHERE ".$where;
			//prx($query); 
			$result = parent::execute($query);
			if ($result) {				
				return true;
			}
			else {	
				return false;
			}	
		}		
		else {	
			return false;
		}		
	}
	public function runUpdateQuery2($table, $valuesfields, $where) {	
		$cond='';
		if(is_array($valuesfields) && count($valuesfields)>0) {
			$query = "UPDATE ".$table." SET ";
			foreach($valuesfields as $key=>$val) {
				$cond .=$key."='".addslashes($val)."',";
			}			
			$query .=rtrim($cond,",")." WHERE ".$where;
			prx($query); 
			$result = parent::execute($query);
			if ($result) {				
				return true;
			}
			else {	
				return false;
			}	
		}		
		else {	
			return false;
		}		
	}

	/**
	 * create and executes an INSERT query in the database 
	 *
	 * @access public
	 * @param $table Table name
	 * @param $fields Table fields in key and values array to be updated	
	 *
	 * @return true on success, or false on error
	 */
	public function runInsertQuery($table, $valuesfields) {	
		$cond='';
		if(is_array($valuesfields) && count($valuesfields)>0) {
			$query = "INSERT INTO ".$table." SET ";
			foreach($valuesfields as $key=>$val) {
				$cond .=$key."='".addslashes($val)."',";
			}			
			$query .=rtrim($cond,",");
            //prx($query);
			$result = parent::execute($query);
			if ($result) {
				return  $this->last_inserted_id;
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
	}

	/**
	* create and executes an SELECT query in the database
	*
	* @access public
	* @param $query full query to get data
	*
	* @return true on success, or false on error
	*/	
	public function runDirectSelectQuery($query) {
		$result = $this->find($query);
		if (count($result) > 0) {
			return $result;
		}else {
			return false;
		}
	}
	
	
	
	public function runDirectQuery($query) {
		$result = parent::execute($query);
		if (count($result) > 0) {
			return true;
		}else {
			return false;
		}
	}
	
	
	
	/**
	 * GET PAGE SEO KEYWORDS
	 *	
	 * @return true on success, or false on error
	 */
	public function getWebsiteSeo($pageName) {	
		$table="seo";		
		$field="id,title,keywords,description";		
		if($pageName=='index.php') {
			$where="code='home'";
		} else {
			$where="code='home'";
		}
		$result = $this->runSelectQuery($table,$field,$where);
		if (count($result) > 0) {
			return $result;
		}
		else {	
			return false;
		}
	}
    
    /**
     * CHECK PERMISSION OF ADMIN
     * 
     * @return true on allowed, or false on not allow
     */
	public function checkAdminPermission($role, $model, $action) {
        $where = "module='".$model."' AND action='".$action."' AND role='".$role."'";
        $result = $this->runSelectQuery("admin_permissions", "allow", $where);
        if(isset($result[0]['allow']) && $result[0]['allow'] == '1'){
            return true;
        }else{
            return false;
        }
    }
	
    /**
     * Find out the count of total reviews
     * 
     */
    function totalReviewsCount(){
        $where = "";
        $rvwQuery = $this->runSelectQuery('reviews','count(id) as total',$where);
        $totalReviews = $rvwQuery[0]['total'];
        return $totalReviews;
    }
    
    /**
     * find out the count of total pending approval of restaurant owners
     * 
     */
    function totalPendingOwners(){
        $where = "parent_id='0' AND approved='0'";
        $userQuery = $this->runSelectQuery('owners','count(id) as total',$where);
        $totalPendingUsers = $userQuery[0]['total'];
        return $totalPendingUsers;
    }
    
    /**
     * find out total number of restaurant branches
     * 
     */
    function totalRestaurantBranches(){
        $where = "";
        $branchQuery = $this->runSelectQuery('branches','count(id) as total',$where);
        $totalBranches = $branchQuery[0]['total'];
        return $totalBranches;
    }
    
    /**
     * find out the count of total restaurant owners
     * 
     */
    function totalRestaurantOwners(){
        $where = "status='1'";
        $ownerQuery = $this->runSelectQuery('owners','count(id) as total',$where);
        $totalOwners = $ownerQuery[0]['total'];
        return $totalOwners;
    }
}
?>