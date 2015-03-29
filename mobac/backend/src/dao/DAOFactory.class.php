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
//require_once('utils/dao/DAOFactory.class.php');

class DAOFactory{
	
	/**
	 * @return CallDetailsDAO
	 */
	
	public static function getCallDetailsDAO(){
		require_once('CallDetailsDAO.class.php');
		require_once('models/CallDetail.class.php');
		require_once('mysql/CallDetailsMySqlDAO.class.php');
		require_once('mysql/ext/CallDetailsMySqlExtDAO.class.php');
		
		return new CallDetailsMySqlExtDAO();
	}

	/**
	 * @return LocationsDAO
	 */
	
	public static function getLocationsDAO(){
		require_once('LocationsDAO.class.php');
		require_once('models/Location.class.php');
		require_once('mysql/LocationsMySqlDAO.class.php');
		require_once('mysql/ext/LocationsMySqlExtDAO.class.php');
		
		return new LocationsMySqlExtDAO();
	}

	/**
	 * @return MessagesDAO
	 */
	
	public static function getMessagesDAO(){
		require_once('MessagesDAO.class.php');
		require_once('models/Message.class.php');
		require_once('mysql/MessagesMySqlDAO.class.php');
		require_once('mysql/ext/MessagesMySqlExtDAO.class.php');
		
		return new MessagesMySqlExtDAO();
	}

	/**
	 * @return UserInfoDAO
	 */
	
	public static function getUserInfoDAO(){
		require_once('UserInfoDAO.class.php');
		require_once('models/UserInfo.class.php');
		require_once('mysql/UserInfoMySqlDAO.class.php');
		require_once('mysql/ext/UserInfoMySqlExtDAO.class.php');

		return new UserInfoMySqlExtDAO();
	}

	/**
	 * @return ContactsDAO
	 */
	
	public static function getContactsDAO(){
		require_once('ContactsDAO.class.php');
		require_once('models/Contact.class.php');
		require_once('mysql/ContactsMySqlDAO.class.php');
		require_once('mysql/ext/ContactsMySqlExtDAO.class.php');
		
		return new ContactsMySqlExtDAO();
	}

	/**
	 * @return UserContactsDAO
	 */
	
	public static function getUserContactsDAO(){
		require_once('UserContactsDAO.class.php');
		require_once('models/UserContact.class.php');
		require_once('mysql/UserContactsMySqlDAO.class.php');
		require_once('mysql/ext/UserContactsMySqlExtDAO.class.php');
		
		return new UserContactsMySqlExtDAO();
	}
}
?>