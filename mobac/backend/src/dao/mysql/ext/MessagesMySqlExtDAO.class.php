<?php
/**
 * Class that operate on table 'messages'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-18 23:07
 */
class MessagesMySqlExtDAO extends MessagesMySqlDAO{

	public function loadMessage($id, $userId){
		$sql = 'SELECT * FROM messages WHERE id = ? AND user_id = ? AND status = 0';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		$sqlQuery->set($userId);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAllFirstMessages($userId){
		$sql = 'SELECT * FROM messages WHERE user_id = ? AND status = 0 ORDER BY `time` DESC LIMIT 0, 20';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($userId);
		return $this->getList($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAllMessages($userId){
		$sql = 'SELECT * FROM messages WHERE user_id = ? AND status = 0 ORDER BY `time` DESC';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($userId);
		return $this->getList($sqlQuery);
	}
}
?>