<?php

/**
 * @author rajnish
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/UserInfo.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class UserResource implements Resource {

    private $mobacDAO;
    private $UserInfo;

    public function __construct() {
		$DAOFactory = new DAOFactory();
		$this -> mobacDAO = $DAOFactory -> getUserInfoDAO();
    }

    public function checkIfRequestMethodValid($requestMethod) {
		return in_array($requestMethod, array('get', 'put', 'post', 'delete', 'options'));
    }

    public function options() {    }

    
    public function delete ($resourceVals, $data, $userId) {    }

    public function put ($resourceVals, $data, $userId) {    }

    public function post ($resourceVals, $data, $userId) {
        global $logger, $warnings_payload;

        $UserInfoId = $resourceVals ['user'];
        if (isset($UserInfoId)) {
            $warnings_payload [] = 'POST call to /user must not have ' . 
                                        '/user_ID appended i.e. POST /user';
            throw new UnsupportedResourceMethodException();
        }

        $userInfoObj = new UserInfo($data ['firstName'], $data ['lastName'], $data ['email'], $data ['phoneNo'], $data ['password'], 0);
        $logger -> debug ("POSTed User Detail: " . $userInfoObj -> toString());

        if ($data['phoneNo'] == '') {
            return array('code' => '6014');
        }
        else if ($data['password'] == '') {
            return array('code' => '6015');
        }
        else {
            $this -> mobacDAO -> insert($userInfoObj);

            $userDetail = $userInfoObj -> toArray();
            
            if(! isset($userDetail ['id'])) 
                return array('code' => '6011');

            $this -> userDetail[] = $userDetail;
            return array ('code' => '6001', 
                            'data' => array(
                                'userDetail' => $this -> userDetail
                            )
            );
        }
    }

    public function get($resourceVals, $data, $userId) {

        //$userId = 1;

        $UserInfoId = $resourceVals ['user'];
        if (isset($UserInfoId))
            return array('code' => '6004');
            //$result = $this->getUserDetail($userId);
            
        else
            $result = $this -> getUserDetail($userId);
        
        if (!is_array($result)) {
            return array('code' => '6004');
        }

        return $result;
    }

    private function getUserDetail($userId) {
    
        global $logger;
        $logger->debug('Fetch User Detail...');
        $userInfoObj = $this -> mobacDAO -> load($userId);

        if(empty($userInfoObj)) 
                return array('code' => '6004');        
             
        $this -> userDetail [] = $userInfoObj-> toArray();
        $logger -> debug ('Fetched details: ' . json_encode($this -> userDetail));

        return array('code' => '6000', 
                     'data' => array(
                                'user' => $this -> userDetail
                            )
            );
    }

}