<?php
/**
 * Class that operate on table 'call_details'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-18 23:07
 */
class CallDetailsMySqlExtDAO extends CallDetailsMySqlDAO{

		/**
	 * Get all records from table
	 */
	public function loadCallSummary($id, $userId){
		$sql = "SELECT *, count(*) AS count FROM `call_details`
					WHERE id = ? AND user_id = ? AND status=0 AND time != '0000-00-00 00:00:00'
						GROUP BY second_party";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		$sqlQuery->set($userId);
		return $this->getRowCallSummary($sqlQuery);
	}

	public function queryAllCallsSummary($userId){
		$sql = "SELECT *, count(*) AS count FROM `call_details`
					WHERE user_id = ? AND status=0 AND time != '0000-00-00 00:00:00'
						GROUP BY second_party";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($userId);
		return $this->getListCallsSummary($sqlQuery);
	}


	/**
	 * Read row
	 *
	 * @return Messages-summaryMySql 
	 */
	protected function readRowCallDetailSummary($row){
	
		$callDetailSummary = new CallDetail($row['user_id'], $row['second_party'], $row['call_duration'], $row['time'], $row['type'], $row['status'], $row['caller_name'], $row['id'], $row['count']);
		return $callDetailSummary;

	}

	/**
	 * Get row
	 *
	 * @return Messages-UserContacts-MySql 
	 */
	protected function getRowCallSummary($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		if(count($tab)==0){
			return null;
		}
		return $this->readRowCallDetailSummary($tab[0]);		
	}
	

	protected function getListCallsSummary($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = $this->readRowCallDetailSummary($tab[$i]);
		}
		return $ret;
	}
}
?>