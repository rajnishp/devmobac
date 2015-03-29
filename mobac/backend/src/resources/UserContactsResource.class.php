<?php

/**
 * @author Rahul Lahoria (rahul.lahoria@capillarytech.com)
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';

require_once 'models/UserContact.class.php';

require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class UserContactsResource implements Resource {

    private $mobacDAO;
    private $Contacts;

    public function __construct() {
		$DAOFactory = new DAOFactory();
		$this -> mobacDAO = $DAOFactory -> getUserContactsDAO();
    }

    public function checkIfRequestMethodValid($requestMethod) {
		return in_array($requestMethod, array('get', 'put', 'post', 'delete', 'options'));
    }

    public function options() {    }

    
    public function delete ($resourceVals, $data, $userId) {
        global $logger, $warnings_payload; 

        // $userId is set temporally, update it
        //$userId = 2;

        $contactId = $resourceVals ['contacts'];

        if (! isset($contactId)) {
            $warnings_payload [] = 'DELETE call to /contacts must be succeeded ' .  
                                        'by /contactId i.e. DELETE /contacts/contactId';
            throw new UnsupportedResourceMethodException();
        }

        $logger -> debug ("Delete contact with Id: " . $contactId);-
        
        $result = $this -> mobacDAO -> delete($contactId, $userId);
        $logger -> debug ("Contact Deleted? " . $result);

        if ($result) 
            $result = array('code' => '5003');
        else 
            $result = array('code' => '5004');

        return $result;
    }

    public function put ($resourceVals, $data, $userId) {    }

    public function post ($resourceVals, $data, $userId) {
        global $logger, $warnings_payload;

        // $userId is set temporally, update it
        $userId = 2;
        
        $contactId = $resourceVals ['contacts'];
        if (isset($contactId)) {
            $warnings_payload [] = 'POST call to /contacts must not have ' . 
                                        '/contacts appended i.e. POST /contacts';
            throw new UnsupportedResourceMethodException();
        }        

        $contactObj = new UserContact(
                                        $userId, 
                                        $data ['name'], 
                                        $data ['number'], 
                                        $data ['last_update_time'],
                                        $data ['email_contact'],
                                        $data ['email_type'],
                                        $data ['image_link']
                                    );

        $logger -> debug ("POSTed contact: " . $contactObj -> toString());

        $this -> mobacDAO -> insert($contactObj);

        $contacts = $contactObj -> toArray();
        
        if(! isset($contacts ['id'])) 
            return array('code' => '5011');

        $this -> contacts[] = $contacts;
    

        return array ('code' => '5001', 
                        'data' => array(
                            'contacts' => $this -> contacts
                        )
        );

        
    }


    public function get($resourceVals, $data, $userId) {

        // $userId is set temporally, update it
        $userId = 2;

        $contactId = $resourceVals ['contacts'];
        if (isset($contactId))
            $result = $this->getContact($contactId, $userId);
        else
            $result = $this -> getListOfAllContacts($userId);

        if (!is_array($result)) {
            return array('code' => '5004');
        }

        return $result;
    }

    private function getContact($contactId, $userId) {
    
        global $logger;
        $logger->debug('Fetch contact...');

        $contactObj = $this -> mobacDAO -> loadUserContact($contactId, $userId);

        if(empty($contactObj)) 
                return array('code' => '5004');        
             
        $this -> Contacts [] = $contactObj-> toArray();
        
        $logger -> debug ('Fetched list of Contacts: ' . json_encode($this -> Contacts));

        return array('code' => '5000', 
                     'data' => array(
                                'Contacts' => $this -> Contacts
                            )
            );
    }

    private function getListOfAllContacts($userId) {
    
        global $logger;
        $logger->debug('Fetch list of all Contacts...');

        $listOfContactObj = $this -> mobacDAO -> queryAllUserContacts($userId);
        if(empty($listOfContactObj)) 
                return array('code' => '5004');

        foreach ($listOfContactObj as $contactObj) {
                $contacts = $contactObj -> toArray();
                $this -> contacts [] = $contacts;
        }
        $logger -> debug ('Fetched list of contacts: ' . json_encode($this -> contacts));

        return array('code' => '5000', 
                     'data' => array(
                                'contacts' => $this -> contacts
                            )
            );
    }
}