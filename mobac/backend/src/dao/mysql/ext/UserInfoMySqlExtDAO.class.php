<?php
/**
 * Class that operate on table 'user_info'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-18 23:07
 */
class UserInfoMySqlExtDAO extends UserInfoMySqlDAO{

	public function queryByUsername($value){
		$sql = 'SELECT * FROM user_info WHERE phone_no = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getRow($sqlQuery);
	}
	
}
?>