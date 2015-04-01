<?php

/**
 * @author Rahul Lahoria (rahul.lahoria@capillarytech.com)
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/Message.class.php';
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

    
    public function delete ($resourceVals, $data, $userId) {
        
        global $logger, $warnings_payload;
         
        $messageId = $resourceVals ['messages'];

        if (! isset($messageId)) {
            $warnings_payload [] = 'DELETE call to /messages must be succeeded ' .  
                                        'by /messageId i.e. DELETE /messages/messageId';
            throw new UnsupportedResourceMethodException();
        }
        $logger -> debug ("Delete message with Id: " . $messageId);-
        
        $result = $this -> mobacDAO -> delete($messageId, $userId);
        $logger -> debug ("Message Deleted? " . $result);

        if ($result) 
            $result = array('code' => '2003');
        else 
            $result = array('code' => '2004');

        return $result;
    }

    public function put ($resourceVals, $data, $userId) {    }

    public function post ($resourceVals, $data, $userId) {
        global $logger, $warnings_payload;

        $messageId = $resourceVals ['messages'];
        if (isset($messageId)) {
            $warnings_payload [] = 'POST call to /messages must not have ' . 
                                        '/messages_ID appended i.e. POST /messages';
            throw new UnsupportedResourceMethodException();
        }

        if( isset( $data["messages"] ) ){
            
            foreach ($data["messages"] as $key => $value) {

                $value['fromTo'] = str_replace(array(' ', '-'), array('', ''), $value['fromTo']);

                $messageObj = new Message(
                                                $userId, 
                                                $value ['fromTo'],
                                                $value ['messageText'], 
                                                $value ['time'],
                                                $value ['type'], 
                                                0
                                            );

                $logger -> debug ("POSTed message: " . $messageObj -> toString());

                try {
                    $this -> mobacDAO -> insert($messageObj);
                } catch (Exception $e) {

                }

                $messages = $messageObj -> toArray();
                
                //if(! isset($messages ['id'])) 
                  //  return array('code' => '2011');

                $this -> messages[] = $messages;
            }

        } 
        else {

            $newFromTo = str_replace(array(' ', '-'), array('', ''), $data['fromTo']);
            
            $messageObj = new Message($userId, $newFromTo, $data ['messageText'], $data ['time'],$data ['type'], 0);
            $logger -> debug ("POSTed message: " . $messageObj -> toString());

            $this -> mobacDAO -> insert($messageObj);

            $messages = $messageObj -> toArray();
            
            if(! isset($messages ['id'])) 
                return array('code' => '2011');

            $this -> messages[] = $messages;
        }

        return array ('code' => '2001', 
                        'data' => array(
                            'messages' => $this -> messages
                        )
        );
    }

    public function get($resourceVals, $data, $userId) {

        $messageId = $resourceVals ['messages'];
        if (isset($messageId))
            $result = $this->getMessage($messageId, $userId);
        else
            $result = $this -> getListOfAllMessages($userId);

        if (!is_array($result)) {
            return array('code' => '2004');
        }

        return $result;
    }

    private function getMessage($messageId, $userId) {
    
        global $logger;
        $logger->debug('Fetch message...');

        $messageObj = $this -> mobacDAO -> loadMessage($messageId, $userId);

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

    private function getListOfAllMessages($userId) {
    
        global $logger;
        $logger->debug('Fetch list of all messages...');

        $listOfmessageObjs = $this -> mobacDAO -> queryAllMessages($userId);
        
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