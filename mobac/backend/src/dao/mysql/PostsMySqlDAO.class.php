<?php
/**
 * Class that operate on table 'posts'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-15 11:09
 */
class PostsMySqlDAO implements PostsDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return PostsMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM posts WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function readAll(){
		$sql = 'SELECT * FROM posts';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM posts ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param post primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM posts WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param PostsMySql post
 	 */
	public function insert($post){
		$sql = 'INSERT INTO posts (ch_id, title, hashtag, share_count) VALUES (?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($post->getChId());
		$sqlQuery->set($post->getTitle());
		$sqlQuery->set($post->getHashtag());
		$sqlQuery->set($post->getShareCount());

		$id = $this->executeInsert($sqlQuery);	
		$post->setId($id);
		return $post;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param PostsMySql post
 	 */
	public function update($post){
		$sql = 'UPDATE posts SET ch_id = ?, title = ?, hashtag = ?, share_count = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($post->getChId());
		$sqlQuery->set($post->getTitle());
		$sqlQuery->set($post->getHashtag());
		$sqlQuery->set($post->getShareCount());

		$sqlQuery->set($post->getId());
		
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM posts';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByChId($value){
		$sql = 'SELECT * FROM posts WHERE ch_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByTitle($value){
		$sql = 'SELECT * FROM posts WHERE title = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByHashtag($value){
		$sql = 'SELECT * FROM posts WHERE hashtag = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByShareCount($value){
		$sql = 'SELECT * FROM posts WHERE share_count = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByChId($value){
		$sql = 'DELETE FROM posts WHERE ch_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByTitle($value){
		$sql = 'DELETE FROM posts WHERE title = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByHashtag($value){
		$sql = 'DELETE FROM posts WHERE hashtag = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByShareCount($value){
		$sql = 'DELETE FROM posts WHERE share_count = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return PostsMySql 
	 */
	protected function readRow($row){
		$post = new Post($row['ch_id'], $row['title'], $row['hashtag'], $row['share_count'], $row['id']);
		
		return $post;
	}
	
	protected function getList($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = $this->readRow($tab[$i]);
		}
		return $ret;
	}
	
	/**
	 * Get row
	 *
	 * @return PostsMySql 
	 */
	protected function getRow($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		if(count($tab)==0){
			return null;
		}
		return $this->readRow($tab[0]);		
	}
	
	/**
	 * Execute sql query
	 */
	protected function execute($sqlQuery){
		return QueryExecutor::execute($sqlQuery);
	}
	
		
	/**
	 * Execute sql query
	 */
	protected function executeUpdate($sqlQuery){
		return QueryExecutor::executeUpdate($sqlQuery);
	}

	/**
	 * Query for one row and one column
	 */
	protected function querySingleResult($sqlQuery){
		return QueryExecutor::queryForString($sqlQuery);
	}

	/**
	 * Insert row to table
	 */
	protected function executeInsert($sqlQuery){
		return QueryExecutor::executeInsert($sqlQuery);
	}
}
?>