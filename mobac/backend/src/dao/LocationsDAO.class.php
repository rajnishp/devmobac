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
 	 * @param location primary key
 	 */
	public function delete($id);
	
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
	public function update($location);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByLatitude($value);

	public function queryByLongitude($value);

	public function queryByTime($value);


	public function deleteByLatitude($value);

	public function deleteByLongitude($value);

	public function deleteByTime($value);


}
?>