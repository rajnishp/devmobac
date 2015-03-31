<?php

/**
 * @author Rahul Lahoria (rahul.lahoria@capillarytech.com)
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/Message.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class MessageDetailsResource implements Resource {

    private $mobacDAO;
    private $message;

    public function __construct() {
		$DAOFactory = new DAOFactory();
		$this -> mobacDAO = $DAOFactory -> getMessagesDAO();
    }

    public function checkIfRequestMethodValid($requestMethod) {
		return in_array($requestMethod, array('get', 'put', 'post', 'delete', 'options'));
    }

    public function options() {    }

    
    public function delete ($resourceVals, $data, $userId) {    }

    public function put ($resourceVals, $data, $userId) {    }

    public function post ($resourceVals, $data, $userId) {      }

    public function get($resourceVals, $data, $userId) {

        $phoneNo = $resourceVals ['message-details'];
        if (isset($phoneNo))
            $result = $this->getMessageDetails($phoneNo, $userId);
        else
            //$result = $this -> getListOfAllMessages($phoneNo, userId);

        if (!is_array($result)) {
            return array('code' => '2004');
        }

        return $result;
    }

    private function getMessageDetails($phoneNo, $userId) {
    
        global $logger;
        $logger->debug('Fetch message...');

        $messageDetailObj = $this -> mobacDAO -> queryByFromTo($phoneNo, $userId);
//print_r($messageObj); exit;
        if(empty($messageDetailObj)) 
                return array('code' => '2004');        
             
        foreach ($messageDetailObj as $messageObj) {
        
                $this -> messages [] = $messageObj -> toArray();
                $newLength = intval( $messageObj ->getId() );
        
                $old = $messageObj -> toArray();
        }

        $logger -> debug ('Fetched list of messages: ' . json_encode($this -> messages));

        return array('code' => '2000', 
                     'data' => array(
                                'messages' => $this -> messages
                            )
            );
    }
}