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
	public function load($id, $user_id);

	/**
	 * Get all records from table
	 */
	public function queryAll($user_id);
	
	/**
	 * Get all records from table ordered by field
	 * @Param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn, $user_id);
	
	/**
 	 * Delete record from table
 	 * @param message primary key
 	 */
	public function delete($id, $user_id);
	
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
	public function update($message, $user_id);	

	/**
	 * Delete all rows
	 */
	public function clean($user_id);

	public function queryByFromTo($value, $user_id);

	public function queryByMessageText($value, $user_id);

	public function queryByTime($value, $user_id);

	public function queryByType($value, $user_id);


	public function deleteByFromTo($value, $user_id);

	public function deleteByMessageText($value, $user_id);

	public function deleteByTime($value, $user_id);

	public function deleteByType($value, $user_id);


}
?>