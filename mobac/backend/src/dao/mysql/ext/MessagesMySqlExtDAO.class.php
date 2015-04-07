<?php
/**
 * Class that operate on table 'messages'. Database Mysql.
 *
 * @author: rajnish
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
	public function queryAllMessages($userId){
		$sql = 'SELECT * FROM messages WHERE user_id = ? AND status = 0 ORDER BY `time` DESC';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($userId);
		return $this->getList($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function loadMessageSummary($id, $userId){
		$sql = "SELECT messages.*, user_contacts.name, count(*) AS count FROM `messages` 
					LEFT OUTER JOIN user_contacts ON messages.from_to=user_contacts.phone 
					WHERE messages.id = ?  AND messages.from_to != '' AND messages.user_id = ? 
					AND messages.status=0 AND messages.time != '0000-00-00 00:00:00'
						GROUP BY messages.from_to";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		$sqlQuery->set($userId);
		return $this->getRowMessageSummary($sqlQuery);
	}

	public function queryAllMessagesSummary($userId, $start, $limit){
		        //echo $start . " " . $limit; exit;
		$sql = "SELECT messages.*, user_contacts.name, count(*) AS count FROM `messages` 
					LEFT OUTER JOIN user_contacts ON messages.from_to=user_contacts.phone 
					WHERE messages.user_id = ? AND messages.from_to != '' AND messages.status=0 
					AND messages.time != '0000-00-00 00:00:00'
						GROUP BY messages.from_to LIMIT $start, $limit";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($userId);
		return $this->getListMessageSummary($sqlQuery);
	}


	/**
	 * Read row
	 *
	 * @return Messages-summaryMySql 
	 */
	protected function readRowMessageSummary($row){
	
		$messageSummary = new Message($row['user_id'], $row['from_to'], $row['message_text'], $row['time'],$row['type'], $row['status'], $row['id'], $row['count'], $row['name']);
		return $messageSummary;

	}

	/**
	 * Get row
	 *
	 * @return Messages-UserContacts-MySql 
	 */
	protected function getRowMessageSummary($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		if(count($tab)==0){
			return null;
		}
		return $this->readRowMessageSummary($tab[0]);		
	}
	

	protected function getListMessageSummary($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = $this->readRowMessageSummary($tab[$i]);
		}
		return $ret;
	}
}
?>