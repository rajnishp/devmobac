<?php

/**
 * @author Rahul Lahoria (rahul.lahoria@capillarytech.com)
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/CallDetail.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class CallDetailsResource implements Resource {

    private $mobacDAO;
    private $CallDetails;

    public function __construct() {
		$DAOFactory = new DAOFactory();
		$this -> mobacDAO = $DAOFactory -> getCallDetailsDAO();
    }

    public function checkIfRequestMethodValid($requestMethod) {
		return in_array($requestMethod, array('get', 'put', 'post', 'delete', 'options'));
    }

    public function options() {    }

    
    public function delete ($resourceVals, $data) {
        global $logger, $warnings_payload; 

// $userId is set temporally, update it
        $userId = 2;

        $callDetailId = $resourceVals ['call-details'];

        if (! isset($callDetailId)) {
            $warnings_payload [] = 'DELETE call to /call-details must be succeeded ' .  
                                        'by /callDetailId i.e. DELETE /call-details/callDetailId';
            throw new UnsupportedResourceMethodException();
        }

        $logger -> debug ("Delete call detail with Id: " . $callDetailId);-
        
        $result = $this -> mobacDAO -> delete($callDetailId, $userId);
        $logger -> debug ("Call detail Deleted? " . $result);

        if ($result) 
            $result = array('code' => '5003');
        else 
            $result = array('code' => '5004');

        return $result;
    }

    public function put ($resourceVals, $data) {    }

    public function post ($resourceVals, $data) {
        global $logger, $warnings_payload;

// $userId is set temporally, update it
        $userId = 2;

        $callDetailId = $resourceVals ['call-details'];
        if (isset($messageTextId)) {
            $warnings_payload [] = 'POST call to /call-details must not have ' . 
                                        '/call-detail_ID appended i.e. POST /call-details';
            throw new UnsupportedResourceMethodException();
        }

        //$this -> sanitize($data);

        $callDetailObj = new CallDetail($userId, $data ['secondParty'], $data ['callDuration'], $data ['time'],$data ['type'], 0);
        $logger -> debug ("POSTed call-detail: " . $callDetailObj -> toString());

        $this -> mobacDAO -> insert($callDetailObj);

        $CallDetails = $callDetailObj -> toArray();
        
        if(! isset($CallDetails ['id'])) 
            return array('code' => '5011');

        $this -> CallDetails[] = $CallDetails;
        return array ('code' => '5001', 
                        'data' => array(
                            'CallDetails' => $this -> CallDetails
                        )
        );
    }

    public function get($resourceVals, $data) {

// $userId is set temporally, update it
        $userId = 2;

        $callDetailId = $resourceVals ['call-details'];
        if (isset($callDetailId))
            $result = $this->getCallDetail($callDetailId, $userId);
        else
            $result = $this -> getListOfAllCallDetails($userId);

        if (!is_array($result)) {
            return array('code' => '5004');
        }

        return $result;
    }

    private function getCallDetail($callDetailId, $userId) {
    
        global $logger;
        $logger->debug('Fetch call detail...');

        $callDetailObj = $this -> mobacDAO -> load($callDetailId, $userId);

        if(empty($callDetailObj)) 
                return array('code' => '5004');        
             
        $this -> CallDetails [] = $callDetailObj-> toArray();
        
        $logger -> debug ('Fetched list of call details: ' . json_encode($this -> CallDetails));

        return array('code' => '5000', 
                     'data' => array(
                                'CallDetails' => $this -> CallDetails
                            )
            );
    }

    private function getListOfAllCallDetails($userId) {
    
        global $logger;
        $logger->debug('Fetch list of all messages...');

        $listOfcallDetailObj = $this -> mobacDAO -> queryAll($userId);
        
        if(empty($listOfcallDetailObj)) 
                return array('code' => '5004');

        foreach ($listOfcallDetailObj as $callDetailObj) {
                $callDetail = $callDetailObj -> toArray();
                $this -> CallDetails [] = $callDetail;
        }
        $logger -> debug ('Fetched list of call details: ' . json_encode($this -> CallDetails));

        return array('code' => '5000', 
                     'data' => array(
                                'CallDetails' => $this -> CallDetails
                            )
            );
    }
}