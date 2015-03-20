<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2015-03-18 23:07
 */
interface CallDetailsDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return CallDetails 
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
 	 * @param callDetail primary key
 	 */
	public function delete($id, $userId);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param CallDetails callDetail
 	 */
	public function insert($callDetail);
	
	/**
 	 * Update record in table
 	 *
 	 * @param CallDetails callDetail
 	 */
	public function update($callDetail, $userId);	

	/**
	 * Delete all rows
	 */
	public function clean($userId);

	public function queryBySecondParty($value, $userId);

	public function queryByCallDuration($value, $userId);

	public function queryByTime($value, $userId);

	public function queryByType($value, $userId);


	public function deleteBySecondParty($value, $userId);

	public function deleteByCallDuration($value, $userId);

	public function deleteByTime($value, $userId);

	public function deleteByType($value, $userId);


}
?>