<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2015-03-18 23:07
 */
interface UserInfoDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return UserInfo 
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
 	 * @param userInfo primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param UserInfo userInfo
 	 */
	public function insert($userInfo);
	
	/**
 	 * Update record in table
 	 *
 	 * @param UserInfo userInfo
 	 */
	public function update($userInfo);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByFirstName($value);

	public function queryByLastName($value);

	public function queryByEmail($value);

	public function queryByPhoneNo($value);

	public function queryByPassword($value);


	public function deleteByFirstName($value);

	public function deleteByLastName($value);

	public function deleteByEmail($value);

	public function deleteByPhoneNo($value);

	public function deleteByPassword($value);


}
?>