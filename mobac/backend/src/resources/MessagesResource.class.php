<?php

/**
 * @author Rahul Lahoria (rahul.lahoria@capillarytech.com)
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/Post.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class MessagesResource implements Resource {

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

    
    public function delete ($resourceVals, $data) {    }

    public function put ($resourceVals, $data) {    }

    public function post ($resourceVals, $data) {
        global $logger, $warnings_payload;

        $messageTextId = $resourceVals ['messages'];
        if (isset($messageTextId)) {
            $warnings_payload [] = 'POST call to /messages must not have ' . 
                                        '/messages_ID appended i.e. POST /messages';
            throw new UnsupportedResourceMethodException();
        }

        //$this -> sanitize($data);

        $messageTextObj = new Message($data ['from_to'], $data ['message_text'], $data ['time'],$data ['type'], 0);
        $logger -> debug ("POSTed message: " . $messageTextObj -> toString());

        $this -> mobacDAO -> insert($messageTextObj);

        $messageTexts = $messageTextObj -> toArray();
        
        if(! isset($messageTexts ['id'])) 
            return array('code' => '2011');

        $this -> messageTexts[] = $messageTexts;
        return array ('code' => '2001', 
                        'data' => array(
                            'messageTexts' => $this -> messageTexts
                        )
        );
    }

    public function get($resourceVals, $data) {

        $messageTextId = $resourceVals ['messages'];
        if (isset($messageTextId))
            $result = $this->getMessage($messageTextId);
        else
            $result = $this -> getListOfAllMessages();

        if (!is_array($result)) {
            return array('code' => '6004');
        }

        return $result;
    }

    private function getMessage($locationId) {
    
        global $logger;
        $logger->debug('Fetch message...');

        $messageTextObj = $this -> mobacDAO -> load($messageTextId);

        if(empty($messageTextObj)) 
                return array('code' => '2004');        
             
        $this -> messageTexts [] = $messageTextObj-> toArray();
        
        $logger -> debug ('Fetched list of Messages: ' . json_encode($this -> messageTexts));

        return array('code' => '2000', 
                     'data' => array(
                                'messages' => $this -> messageTexts
                            )
            );
    }

    private function getListOfAllMessages() {
    
        global $logger;
        $logger->debug('Fetch list of all messages...');

        $listOfmessageTextObjs = $this -> mobacDAO -> queryAll();
        
        if(empty($listOfmessageTextObjs)) 
                return array('code' => '2004');

        foreach ($listOfmessageTextObjs as $messageTextObj) {
                $messageText = $messageTextObj -> toArray();
                $this -> messages [] = $messageText;
        }
        $logger -> debug ('Fetched list of messages: ' . json_encode($this -> messages));

        return array('code' => '2000', 
                     'data' => array(
                                'messages' => $this -> messages
                            )
            );
    }
}