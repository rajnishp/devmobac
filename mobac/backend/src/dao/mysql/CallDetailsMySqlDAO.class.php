<?php
/**
 * Class that operate on table 'call_details'. Database Mysql.
 *
 * @author: http://dpower4.com build over (http://phpdao.com)
 * @date: 2015-03-18 23:07
 */
class CallDetailsMySqlDAO implements CallDetailsDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return CallDetailsMySql 
	 */
	public function load($id, $userId){
		$sql = 'SELECT * FROM call_details WHERE id = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		$sqlQuery->set($userId);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll($userId){
		$sql = 'SELECT * FROM call_details WHERE user_id = ?';
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
		$sql = 'SELECT * FROM call_details WHERE user_id = ? ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($userId);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param callDetail primary key
 	 */
	public function delete($id, $userId){
		//$sql = 'DELETE FROM call_details WHERE id = ? AND user_id = ?';
		$sql = 'UPDATE call_details SET status = 1 WHERE id = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		$sqlQuery->set($userId);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param CallDetailsMySql callDetail
 	 */
	public function insert($callDetail){
		
		$sql = 'INSERT INTO call_details (user_id, second_party, call_duration, time, type) VALUES (?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($callDetail->getUserId());
		$sqlQuery->set($callDetail->getSecondParty());
		$sqlQuery->set($callDetail->getCallDuration());
		$sqlQuery->set($callDetail->getTime());
		$sqlQuery->set($callDetail->getType());
	
		$id = $this->executeInsert($sqlQuery);	
		$callDetail -> setId($id);	
	
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param CallDetailsMySql callDetail
 	 */
	public function update($callDetail, $userId){
		$sql = 'UPDATE call_details SET second_party = ?, call_duration = ?, time = ?, type = ? WHERE id = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($callDetail -> secondParty);
		$sqlQuery->set($callDetail -> callDuration);
		$sqlQuery->set($callDetail -> time);
		$sqlQuery->set($callDetail -> type);

		$sqlQuery->setNumber($callDetail -> id);
		$sqlQuery->set($callDetail -> userId);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean($userId){
		$sql = 'DELETE FROM call_details AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($userId);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryBySecondParty($value, $userId){
		$sql = 'SELECT * FROM call_details WHERE second_party = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery -> setNumber($value);
		$sqlQuery -> set($userId);
		return $this -> getList($sqlQuery);
	}

	public function queryByCallDuration($value, $userId){
		$sql = 'SELECT * FROM call_details WHERE call_duration = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		$sqlQuery->set($userId);
		return $this->getList($sqlQuery);
	}

	public function queryByTime($value, $userId){
		$sql = 'SELECT * FROM call_details WHERE time = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		$sqlQuery->set($userId);
		return $this->getList($sqlQuery);
	}

	public function queryByType($value, $userId){
		$sql = 'SELECT * FROM call_details WHERE type = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		$sqlQuery->set($userId);
		return $this->getList($sqlQuery);
	}


	public function deleteBySecondParty($value, $userId){
		$sql = 'DELETE FROM call_details WHERE second_party = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		$sqlQuery->set($userId);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCallDuration($value, $userId){
		$sql = 'DELETE FROM call_details WHERE call_duration = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		$sqlQuery->set($userId);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByTime($value, $userId){
		$sql = 'DELETE FROM call_details WHERE time = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		$sqlQuery->set($userId);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByType($value, $userId){
		$sql = 'DELETE FROM call_details WHERE type = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		$sqlQuery->set($userId);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return CallDetailsMySql 
	 */
	protected function readRow($row){
		/*$callDetail = new CallDetail();
		
		$callDetail->id = $row['id'];
		$callDetail->secondParty = $row['second_party'];
		$callDetail->callDuration = $row['call_duration'];
		$callDetail->time = $row['time'];
		$callDetail->type = $row['type'];
*/
		$callDetail = new CallDetail($row['user_id'], $row['second_party'], $row['call_duration'], $row['time'],$row['type'], $row['status'], $row['id']);
//		print_r($callDetail); exit;
		return $callDetail;
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
	 * @return CallDetailsMySql 
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
