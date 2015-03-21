<?php
/**
 * Class that operate on table 'user_info'. Database Mysql.
 *
 * @author: http://dpower4.com build over (http://phpdao.com)
 * @date: 2015-03-18 23:07
 */
class UserInfoMySqlDAO implements UserInfoDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return UserInfoMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM user_info WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM user_info';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM user_info ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param userInfo primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM user_info WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param UserInfoMySql userInfo
 	 */
	public function insert($userInfo){
		$sql = 'INSERT INTO user_info (first_name, last_name, email, phone_no, password) VALUES (?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($userInfo->firstName);
		$sqlQuery->set($userInfo->lastName);
		$sqlQuery->set($userInfo->email);
		$sqlQuery->setNumber($userInfo->phoneNo);
		$sqlQuery->set($userInfo->password);

		$id = $this->executeInsert($sqlQuery);	
		$userInfo-> setId($id);
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param UserInfoMySql userInfo
 	 */
	public function update($userInfo){
		$sql = 'UPDATE user_info SET first_name = ?, last_name = ?, email = ?, phone_no = ?, password = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($userInfo->firstName);
		$sqlQuery->set($userInfo->lastName);
		$sqlQuery->set($userInfo->email);
		$sqlQuery->setNumber($userInfo->phoneNo);
		$sqlQuery->set($userInfo->password);

		$sqlQuery->setNumber($userInfo->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM user_info';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByFirstName($value){
		$sql = 'SELECT * FROM user_info WHERE first_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByLastName($value){
		$sql = 'SELECT * FROM user_info WHERE last_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByEmail($value){
		$sql = 'SELECT * FROM user_info WHERE email = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByPhoneNo($value){
		$sql = 'SELECT * FROM user_info WHERE phone_no = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByPassword($value){
		$sql = 'SELECT * FROM user_info WHERE password = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByFirstName($value){
		$sql = 'DELETE FROM user_info WHERE first_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByLastName($value){
		$sql = 'DELETE FROM user_info WHERE last_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByEmail($value){
		$sql = 'DELETE FROM user_info WHERE email = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByPhoneNo($value){
		$sql = 'DELETE FROM user_info WHERE phone_no = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByPassword($value){
		$sql = 'DELETE FROM user_info WHERE password = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return UserInfoMySql 
	 */
	protected function readRow($row){
		$userInfo = new UserInfo();
		
		/*$userInfo->id = $row['id'];
		$userInfo->firstName = $row['first_name'];
		$userInfo->lastName = $row['last_name'];
		$userInfo->email = $row['email'];
		$userInfo->phoneNo = $row['phone_no'];
		$userInfo->password = $row['password'];
*/
		$userInfo = new UserInfo($row['first_name'], $row['last_name'], $row['email'], $row['phone_no'], $row['password'], $row['status'], $row['id']);
		return $userInfo;
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
	 * @return UserInfoMySql 
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
