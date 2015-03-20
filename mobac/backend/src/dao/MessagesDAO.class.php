<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2015-03-18 23:07
 */
interface MessagesDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Messages 
	 */
	public function load($id, $userId);

	/**
	 * Get all records from table
	 */
	public function queryAll($userId);
	
	/**
	 * Get all records from table ordered by field
	 * @Param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn, $userId);
	
	/**
 	 * Delete record from table
 	 * @param message primary key
 	 */
	public function delete($id, $userId);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Messages message
 	 */
	public function insert($message);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Messages message
 	 */
	public function update($message, $userId);	

	/**
	 * Delete all rows
	 */
	public function clean($userId);

	public function queryByFromTo($value, $userId);

	public function queryByMessageText($value, $userId);

	public function queryByTime($value, $userId);

	public function queryByType($value, $userId);


	public function deleteByFromTo($value, $userId);

	public function deleteByMessageText($value, $userId);

	public function deleteByTime($value, $userId);

	public function deleteByType($value, $userId);


}
?>