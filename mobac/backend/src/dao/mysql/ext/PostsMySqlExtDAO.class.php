<?php
/**
 * Class that operate on table 'posts'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-15 11:09
 */
class PostsMySqlExtDAO extends PostsMySqlDAO{

	/**
	 * Get all records from table
	 */
	public function getPostToShare(){
		$sql = 'SELECT *
				FROM `posts`
				ORDER BY `posts`.`share_count` ASC
				LIMIT 0 , 10';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}

	public function updateShareCount($post){
		$sql = 'UPDATE posts SET share_count = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($post->getChId());
		$sqlQuery->set($post->getTitle());
		$sqlQuery->set($post->getHashtag());
		$sqlQuery->set($post->getShareCount());

		$id = $this->executeInsert($sqlQuery);	
		$post->setId($id);
		return $post;
	}

	protected function executeInsert($sqlQuery){
		return QueryExecutor::executeInsert($sqlQuery);
	}

	public function getUpdateShareCount($posts) {
		$sql = 'UPDATE posts SET share_count = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($post->getShareCount());

		$sqlQuery->set($post->getId());
		
		return $this->executeUpdate($sqlQuery);
	}
}
?>