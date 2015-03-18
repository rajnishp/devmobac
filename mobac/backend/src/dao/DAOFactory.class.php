<?php

/**
 * DAOFactory
 * @author: http://phpdao.com
 * @date: ${date}
 */

require_once('utils/sql/Connection.class.php');
	require_once('utils/sql/ConnectionFactory.class.php');
	require_once('utils/sql/ConnectionProperty.class.php');
	require_once('utils/sql/QueryExecutor.class.php');
	require_once('utils/sql/Transaction.class.php');
	require_once('utils/sql/SqlQuery.class.php');
	require_once('utils/ArrayList.class.php');
	
class DAOFactory{
	
	/**
	 * @return PostsDAO
	 */
	public static function getPostsDAO(){
		require_once('PostsDAO.class.php');
	require_once('models/Post.class.php');
	require_once('mysql/PostsMySqlDAO.class.php');
	require_once('mysql/ext/PostsMySqlExtDAO.class.php');
		return new PostsMySqlExtDAO();
	}


}
?>
