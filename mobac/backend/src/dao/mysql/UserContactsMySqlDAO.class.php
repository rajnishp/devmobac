<?php
/**
 * Class that operate on table 'user_contacts'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-29 06:38
 */
class UserContactsMySqlDAO implements UserContactsDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return UserContactsMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM user_contacts WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM user_contacts';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM user_contacts ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param userContact primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM user_contacts WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param UserContactsMySql userContact
 	 */
	public function insert($userContact){
		$sql = 'INSERT INTO user_contacts (user_id, name, `number`, last_update_time, email_contact, email_type, image_link) VALUES (?, ?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($userContact->getUserId());
		$sqlQuery->set($userContact->getName());
		$sqlQuery->set($userContact->getNumber());
		$sqlQuery->set($userContact->getLastUpdateTime());
		$sqlQuery->set($userContact->getEmailContact());
		$sqlQuery->set($userContact->getEmailType());
		$sqlQuery->set($userContact->getImageLink());

		$id = $this->executeInsert($sqlQuery);	
		$userContact-> setId($id);
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param UserContactsMySql userContact
 	 */
	public function update($userContact){
		$sql = 'UPDATE user_contacts SET user_id = ?, name = ?, number = ?, last_update_time = ?, email_contact = ?, email_type = ?, image_link = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($userContact->userId);
		$sqlQuery->set($userContact->name);
		$sqlQuery->set($userContact->number);
		$sqlQuery->set($userContact->lastUpdateTime);
		$sqlQuery->set($userContact->emailContact);
		$sqlQuery->set($userContact->emailType);
		$sqlQuery->set($userContact->imageLink);

		$sqlQuery->setNumber($userContact->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM user_contacts';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByUserId($value){
		$sql = 'SELECT * FROM user_contacts WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByName($value){
		$sql = 'SELECT * FROM user_contacts WHERE name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByNumber($value){
		$sql = 'SELECT * FROM user_contacts WHERE number = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByLastUpdateTime($value){
		$sql = 'SELECT * FROM user_contacts WHERE last_update_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByEmailContact($value){
		$sql = 'SELECT * FROM user_contacts WHERE email_contact = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByEmailType($value){
		$sql = 'SELECT * FROM user_contacts WHERE email_type = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByImageLink($value){
		$sql = 'SELECT * FROM user_contacts WHERE image_link = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByUserId($value){
		$sql = 'DELETE FROM user_contacts WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByName($value){
		$sql = 'DELETE FROM user_contacts WHERE name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByNumber($value){
		$sql = 'DELETE FROM user_contacts WHERE number = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByLastUpdateTime($value){
		$sql = 'DELETE FROM user_contacts WHERE last_update_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByEmailContact($value){
		$sql = 'DELETE FROM user_contacts WHERE email_contact = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByEmailType($value){
		$sql = 'DELETE FROM user_contacts WHERE email_type = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByImageLink($value){
		$sql = 'DELETE FROM user_contacts WHERE image_link = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return UserContactsMySql 
	 */
	protected function readRow($row){
		$userContact = new UserContact();
		
		/*$userContact->id = $row['id'];
		$userContact->userId = $row['user_id'];
		$userContact->name = $row['name'];
		$userContact->number = $row['number'];
		$userContact->lastUpdateTime = $row['last_update_time'];
		$userContact->emailContact = $row['email_contact'];
		$userContact->emailType = $row['email_type'];
		$userContact->imageLink = $row['image_link'];*/

		$userContact = new UserContact($row['user_id'], $row['name'], $row['number'], $row['last_update_time'], $row['email_contact'], $row['email_type'], $row['image_link'], $row['id']);
		
		return $userContact;
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
	 * @return UserContactsMySql 
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