<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2015-03-29 06:38
 */
interface UserContactsDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return UserContacts 
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
 	 * @param userContact primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param UserContacts userContact
 	 */
	public function insert($userContact);
	
	/**
 	 * Update record in table
 	 *
 	 * @param UserContacts userContact
 	 */
	public function update($userContact);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByUserId($value);

	public function queryByName($value);

	public function queryByPhone($value);

	public function queryByLastUpdateTime($value);

	public function queryByEmailContact($value);

	public function queryByEmailType($value);

	public function queryByImageLink($value);


	public function deleteByUserId($value);

	public function deleteByName($value);

	public function deleteByPhone($value);

	public function deleteByLastUpdateTime($value);

	public function deleteByEmailContact($value);

	public function deleteByEmailType($value);

	public function deleteByImageLink($value);


}
?>