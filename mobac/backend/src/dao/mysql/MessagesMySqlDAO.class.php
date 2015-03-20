<?php
/**
 * Class that operate on table 'messages'. Database Mysql.
 *
 * @author: http://dpower4.com build over (http://phpdao.com)
 * @date: 2015-03-18 23:07
 */
class MessagesMySqlDAO implements MessagesDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return MessagesMySql 
	 */
	public function load($id, $user_id){
		$sql = 'SELECT * FROM messages WHERE id = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		$sqlQuery->set($user_id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll($user_id){
		$sql = 'SELECT * FROM messages WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($user_id);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn, $user_id){
		$sql = 'SELECT * FROM messages WHERE user_id = ? ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param message primary key
 	 */
	public function delete($id, $user_id){

		//$sql = 'DELETE FROM messages WHERE id = ? AND user_id = ?';
		$sql = "UPDATE messages SET status = '2' WHERE id = ? AND user_id = ?";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		$sqlQuery->setNumber($user_id);

	/*	$sqlUpdate = 'UPDATE messages SET status = '2' WHERE id = ? AND user_id = ?';
		$sqlQueryUpdate = new SqlQuery($sqlUpdate);
		$sqlQueryUpdate -> set($id);
		$sqlQueryUpdate -> set($user_id);
		return $this -> executeUpdate ($sqlQueryUpdate);
	*/
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param MessagesMySql message
 	 */
	public function insert($message){
		$sql = 'INSERT INTO messages (user_id, from_to, message_text, time, type) VALUES (?, ?, ?, ?, ?)';
		
		$sqlQuery = new SqlQuery($sql);

		$sqlQuery->set($message->getUserId());
		$sqlQuery->set($message->getFromTo());
		$sqlQuery->set($message->getMessageText());
		$sqlQuery->set($message->getTime());
		$sqlQuery->set($message->getType());


		$id = $this->executeInsert($sqlQuery);	
		$message-> setId($id);
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param MessagesMySql message
 	 */
	public function update($message, $user_id){
		$sql = 'UPDATE messages SET from_to = ?, message_text = ?, time = ?, type = ? WHERE id = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($message->fromTo);
		$sqlQuery->set($message->messageText);
		$sqlQuery->set($message->time);
		$sqlQuery->set($message->type);

		$sqlQuery->setNumber($message->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean($user_id){
		$sql = 'DELETE FROM messages WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByFromTo($value, $user_id){
		$sql = 'SELECT * FROM messages WHERE from_to = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByMessageText($value, $user_id){
		$sql = 'SELECT * FROM messages WHERE message_text = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByTime($value, $user_id){
		$sql = 'SELECT * FROM messages WHERE time = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByType($value, $user_id){
		$sql = 'SELECT * FROM messages WHERE type = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByFromTo($value, $user_id){
		$sql = 'DELETE FROM messages WHERE from_to = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByMessageText($value, $user_id){
		$sql = 'DELETE FROM messages WHERE message_text = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByTime($value, $user_id){
		$sql = 'DELETE FROM messages WHERE time = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByType($value, $user_id){
		$sql = 'DELETE FROM messages WHERE type = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return MessagesMySql 
	 */
	protected function readRow($row, $user_id){
		/*$message = new Message();
		
		$message->id = $row['id'];
		$message->fromTo = $row['from_to'];
		$message->messageText = $row['message_text'];
		$message->time = $row['time'];
		$message->type = $row['type'];*/

		$message = new Message($row['from_to'], $row['message_text'], $row['time'],$row['type'], $row['status'], $row['id']);
		return $message;

//		return $message;
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
	 * @return MessagesMySql 
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
