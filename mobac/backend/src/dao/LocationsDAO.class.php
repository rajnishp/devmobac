<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2015-03-18 23:07
 */
interface LocationsDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Locations 
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
 	 * @param location primary key
 	 */
	public function delete($id, $userId);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Locations location
 	 */
	public function insert($location);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Locations location
 	 */
	public function update($location, $userId);	

	/**
	 * Delete all rows
	 */
	public function clean($userId);

	public function queryByLatitude($value, $userId);

	public function queryByLongitude($value, $userId);

	public function queryByFromTime($value, $userId);

	public function queryByToTime($value, $userId);


	public function deleteByLatitude($value, $userId);

	public function deleteByLongitude($value, $userId);

	public function deleteByFromTime($value, $userId);

	public function deleteByToTime($value, $userId);


}
?>