<?php

/**
 * @author rajnish
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/Message.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class MessagesSummaryResource implements Resource {

    private $mobacDAO;
    private $messages;

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

    public function post ($resourceVals, $data, $userId) {    }

    public function get($resourceVals, $data, $userId) {

        $messageId = $resourceVals ['messages-summary'];
        if (isset($messageId))
            $result = $this->getMessageSummary($messageId, $userId);
        else
            $result = $this -> getListOfAllMessagesSummary($userId);

        if (!is_array($result)) {
            return array('code' => '2004');
        }

        return $result;
    }

    private function getMessageSummary($messageId, $userId) {
    
        global $logger;
        $logger->debug('Fetch message...');

        $messageObj = $this -> mobacDAO -> loadMessageSummary($messageId, $userId);

        if(empty($messageObj)) 
                return array('code' => '2004');        
             
        $this -> messages [] = $messageObj-> toArray();
        
        $logger -> debug ('Fetched list of Messages: ' . json_encode($this -> messages));

        return array('code' => '2000', 
                     'data' => array(
                                'messages' => $this -> messages
                            )
            );
    }

    private function getListOfAllMessagesSummary($userId) {
    
        global $logger;
        $logger->debug('Fetch list of all messages...');


        $listOfmessageObjs = $this -> mobacDAO -> queryAllMessagesSummary($userId);
        
        if(empty($listOfmessageObjs)) 
                return array('code' => '2004');
        
        foreach ($listOfmessageObjs as $messageObj) {
        
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