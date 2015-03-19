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
	public function load($id){
		$sql = 'SELECT * FROM locations WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM locations';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM locations ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param location primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM locations WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery -> setNumber($id);
		return $this -> executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param LocationsMySql location
 	 */
	public function insert($location){
		$sql = 'INSERT INTO locations (latitude, longitude, time) VALUES (?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery -> set($location-> getLatitude());
		$sqlQuery -> set($location-> getLongitude());
		$sqlQuery -> set($location-> getTime());

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
	public function update($location){
		$sql = 'UPDATE locations SET latitude = ?, longitude = ?, time = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($location->latitude);
		$sqlQuery->set($location->longitude);
		$sqlQuery->set($location->time);

		$sqlQuery->setNumber($location->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM locations';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByLatitude($value){
		$sql = 'SELECT * FROM locations WHERE latitude = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByLongitude($value){
		$sql = 'SELECT * FROM locations WHERE longitude = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByTime($value){
		$sql = 'SELECT * FROM locations WHERE time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByLatitude($value){
		$sql = 'DELETE FROM locations WHERE latitude = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByLongitude($value){
		$sql = 'DELETE FROM locations WHERE longitude = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByTime($value){
		$sql = 'DELETE FROM locations WHERE time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
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
		$location = new Location($row['latitude'], $row['longitude'], $row['time'], $row['id']);
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
