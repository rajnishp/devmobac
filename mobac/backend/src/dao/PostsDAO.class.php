<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2015-03-15 11:09
 */
interface PostsDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Posts 
	 */
	public function load($id);

	/**
	 * Get all records from table
	 */
	public function readAll();
	
	/**
	 * Get all records from table ordered by field
	 * @Param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn);
	
	/**
 	 * Delete record from table
 	 * @param post primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Posts post
 	 */
	public function insert($post);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Posts post
 	 */
	public function update($post);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByChId($value);

	public function queryByTitle($value);

	public function queryByHashtag($value);

	public function queryByShareCount($value);


	public function deleteByChId($value);

	public function deleteByTitle($value);

	public function deleteByHashtag($value);

	public function deleteByShareCount($value);


}
?>