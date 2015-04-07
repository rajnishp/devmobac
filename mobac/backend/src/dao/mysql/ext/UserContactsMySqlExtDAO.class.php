<?php
/**
 * Class that operate on table 'user_contacts'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-29 06:38
 */
class UserContactsMySqlExtDAO extends UserContactsMySqlDAO{

	public function loadUserContact($id, $userId){
		$sql = 'SELECT * FROM user_contacts WHERE id = ? and user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		$sqlQuery->setNumber($userId);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAllUserContacts($userId, $start, $limit){
		$sql = "SELECT * FROM user_contacts WHERE user_id = ? LIMIT $start, $limit";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($userId);
		return $this->getList($sqlQuery);
	}
}
?>