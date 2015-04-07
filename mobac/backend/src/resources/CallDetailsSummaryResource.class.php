<?php

/**
 * @author Rahul Lahoria (rahul.lahoria@capillarytech.com)
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/CallDetail.class.php';

//require_once 'models/Contact.class.php';

require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class CallDetailsSummaryResource implements Resource {

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

    
    public function delete ($resourceVals, $data, $userId) {    }

    public function put ($resourceVals, $data, $userId) {    }

    public function post ($resourceVals, $data, $userId) {		}


    public function get($resourceVals, $data, $userId) {

        $start = intval($data['start']);
        $limit = intval($data['limit']);
        
        $callDetailId = $resourceVals ['callDetails-summary'];
        if (isset($callDetailId))
            $result = $this->getCallSummary($callDetailId, $userId);
        else
            $result = $this -> getListOfAllCallsSummary($userId, $start, $limit);

        if (!is_array($result)) {
            return array('code' => '5004');
        }

        return $result;
    }

    private function getCallSummary($callDetailId, $userId) {
    
        global $logger;
        $logger->debug('Fetch call detail...');

        $callDetailObj = $this -> mobacDAO -> loadCallSummary($callDetailId, $userId);

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

    private function getListOfAllCallsSummary($userId, $start, $limit) {
    
        global $logger;
        $logger->debug('Fetch list of all messages...');

        $listOfcallDetailObj = $this -> mobacDAO -> queryAllCallsSummary($userId, $start, $limit);
        
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