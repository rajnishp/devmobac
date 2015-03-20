<?php

/**
 * @author rajnish
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/Location.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class LocationsResource implements Resource {

    private $mobacDAO;
    private $location;

    public function __construct() {
		
        $DAOFactory = new DAOFactory();
		$this-> mobacDAO = $DAOFactory-> getLocationsDAO();
    }

    public function checkIfRequestMethodValid($requestMethod) {
	
    	return in_array($requestMethod, array('get', 'put', 'post', 'delete', 'options'));
    }

    public function options() {    

    }

    
    public function delete ($resourceVals, $data) {
        global $logger, $warnings_payload; 

        $locationId = $resourceVals ['locations'];

        if (! isset($locationId)) {
            $warnings_payload [] = 'DELETE call to /locations must be succeeded ' .  
                                        'by /locationId i.e. DELETE /locations/locationId';
            throw new UnsupportedResourceMethodException();
        }
        $logger -> debug ("Delete message with Id: " . $locationId);-
        
        $result = $this -> mobacDAO -> delete($locationId);
        $logger -> debug ("Location Deleted? " . $result);

        if ($result) 
            $result = array('code' => '4003');
        else 
            $result = array('code' => '4004');

        return $result;
    }

    public function put ($resourceVals, $data) {    }

    public function post ($resourceVals, $data) {
        global $logger, $warnings_payload;

        $locationId = $resourceVals ['locations'];
        if (isset($locationId)) {
            $warnings_payload [] = 'POST call to /locations must not have ' . 
                                        '/location_ID appended i.e. POST /locations';
            throw new UnsupportedResourceMethodException();
        }

        //$this -> sanitize($data);

        $locationObj = new Location($data ['latitude'], $data ['longitude'], $data ['time'], 0);
        $logger -> debug ("POSTed location: " . $locationObj -> toString());

        $this -> mobacDAO -> insert($locationObj);

        $locations = $locationObj -> toArray();
        
        if(! isset($locations ['id'])) 
            return array('code' => '4011');

        $this -> locations[] = $locations;
        return array ('code' => '4001', 
                        'data' => array(
                            'locations' => $this -> locations
                        )
        );
    }

    public function get($resourceVals, $data) {
		
		$locationId = $resourceVals ['locations'];
		if (isset($locationId))
			$result = $this->getLocation($locationId);
		else
			$result = $this -> getListOfAllLocations();

		if (!is_array($result)) {
		    return array('code' => '4004');
		}

		return $result;
    }

    private function getLocation($locationId) {
	
    	global $logger;
		$logger->debug('Fetch location...');

		$locationObj = $this -> mobacDAO -> load($locationId);

        if(empty($locationObj)) 
                return array('code' => '4004');        
             
        $this -> locations [] = $locationObj-> toArray();
        
        $logger -> debug ('Fetched list of Channels: ' . json_encode($this -> locations));

        return array('code' => '4000', 
                     'data' => array(
                                'locations' => $this -> locations
                            )
            );
    }

    private function getListOfAllLocations() {
	
    	global $logger;
		$logger->debug('Fetch list of all locations...');

		$listOfLocationObjs = $this -> mobacDAO -> queryAll();
        //print_r($listOfLocationObjs); exit;

        if(empty($listOfLocationObjs)) 
                return array('code' => '4004');

        foreach ($listOfLocationObjs as $locationObj) {
                $location = $locationObj -> toArray();
                $this -> locations [] = $location;
        }
        $logger -> debug ('Fetched list of Locations: ' . json_encode($this -> locations));

        return array('code' => '4000', 
                     'data' => array(
                                'locations' => $this -> locations
                            )
            );
    }

}