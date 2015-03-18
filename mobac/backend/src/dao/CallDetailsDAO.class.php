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
	public function load($id);

	/**
	 * Get all records from table
	 */
	public function queryAll();
	
	/**
	 * Get all records from table ordered by field
	 * @Param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn);
	
	/**
 	 * Delete record from table
 	 * @param callDetail primary key
 	 */
	public function delete($id);
	
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
	public function update($callDetail);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryBySecondParty($value);

	public function queryByCallDuration($value);

	public function queryByTime($value);

	public function queryByType($value);


	public function deleteBySecondParty($value);

	public function deleteByCallDuration($value);

	public function deleteByTime($value);

	public function deleteByType($value);


}
?>