<?php
/**
 * Class that operate on table 'locations'. Database Mysql.
 *
 * @author: http://dpower4.com build over (http://phpdao.com)
 * @date: 2015-03-18 23:07
 */
class LocationsMySqlDAO implements LocationsDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return LocationsMySql 
	 */
	public function load($id, $userId){
		$sql = 'SELECT * FROM locations WHERE id = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		$sqlQuery->set($userId);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll($userId){
		$sql = 'SELECT * FROM locations WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($userId);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn, $userId){
		$sql = 'SELECT * FROM locations WHERE user_id = ? ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($userId);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param location primary key
 	 */
	public function delete($id, $userId){
		//$sql = 'DELETE FROM locations WHERE id = ? AND user_id = ?';
		$sql = 'UPDATE locations SET status = 1 WHERE id = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery -> setNumber($id);
		$sqlQuery->set($userId);
		return $this -> executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param LocationsMySql location
 	 */
	public function insert($location){
		$sql = 'INSERT INTO locations (user_id, latitude, longitude, from_time, to_time) VALUES (?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($message->getUserId());
		$sqlQuery -> set($location-> getLatitude());
		$sqlQuery -> set($location-> getLongitude());
		$sqlQuery -> set($location-> getFromTime());
		$sqlQuery -> set($location-> getToTime());

		$id = $this -> executeInsert($sqlQuery);	
		$location -> setId($id);
		//$location-> id = $id;
		return $location;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param LocationsMySql location
 	 */
	public function update($location, $userId){
		$sql = 'UPDATE locations SET latitude = ?, longitude = ?, from_time = ?, to_time = ? WHERE id = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($location->latitude);
		$sqlQuery->set($location->longitude);
		$sqlQuery->set($location->fromTime);
		$sqlQuery->set($location->toTime);

		$sqlQuery->setNumber($location->id);
		$sqlQuery->set($userId);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean($userId){
		$sql = 'DELETE FROM locations WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($userId);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByLatitude($value, $userId){
		$sql = 'SELECT * FROM locations WHERE latitude = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		$sqlQuery->set($userId);
		return $this->getList($sqlQuery);
	}

	public function queryByLongitude($value, $userId){
		$sql = 'SELECT * FROM locations WHERE longitude = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		$sqlQuery->set($userId);
		return $this->getList($sqlQuery);
	}

	public function queryByFromTime($value, $userId){
		$sql = 'SELECT * FROM locations WHERE from_time = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		$sqlQuery->set($userId);
		return $this->getList($sqlQuery);
	}

	public function queryByToTime($value, $userId){
		$sql = 'SELECT * FROM locations WHERE to_time = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		$sqlQuery->set($userId);
		return $this->getList($sqlQuery);
	}


	public function deleteByLatitude($value, $userId){
		$sql = 'DELETE FROM locations WHERE latitude = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		$sqlQuery->set($userId);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByLongitude($value, $userId){
		$sql = 'DELETE FROM locations WHERE longitude = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		$sqlQuery->set($userId);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByFromTime($value, $userId){
		$sql = 'DELETE FROM locations WHERE from_time = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		$sqlQuery->set($userId);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByToTime($value, $userId){
		$sql = 'DELETE FROM locations WHERE to_time = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		$sqlQuery->set($userId);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return LocationsMySql 
	 */
	protected function readRow($row){
	/*	$location = new Location();
		
		$location->id = $row['id'];
		$location->latitude = $row['latitude'];
		$location->longitude = $row['longitude'];
		$location->time = $row['time'];
*/
		$location = new Location($row['user_id'], $row['latitude'], $row['longitude'], $row['from_time'],$row['to_time'], $row['status'], $row['id']);
		return $location;
	}
	
	protected function getList($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = $this->readRow($tab[$i]);
		}
		return $ret;
	}
	
	/**
	 * Get row
	 *
	 * @return LocationsMySql 
	 */
	protected function getRow($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		if(count($tab)==0){
			return null;
		}
		return $this->readRow($tab[0]);		
	}
	
	/**
	 * Execute sql query
	 */
	protected function execute($sqlQuery){
		return QueryExecutor::execute($sqlQuery);
	}
	
		
	/**
	 * Execute sql query
	 */
	protected function executeUpdate($sqlQuery){
		return QueryExecutor::executeUpdate($sqlQuery);
	}

	/**
	 * Query for one row and one column
	 */
	protected function querySingleResult($sqlQuery){
		return QueryExecutor::queryForString($sqlQuery);
	}

	/**
	 * Insert row to table
	 */
	protected function executeInsert($sqlQuery){
		return QueryExecutor::executeInsert($sqlQuery);
	}
}
?>
