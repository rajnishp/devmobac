<?php

	/**
	 * @author Rahul Lahoria
	 */

	require_once 'ResourceRegistry.interface.php';

    class v0ResourceRegistry implements ResourceRegistry{

        private $resource = null;

        public function lookupResource ($resourceType) {

            switch($resourceType) {

                case '/messages': 
                    require_once 'resources/MessagesResource.class.php';
                    $this -> resource = new MessagesResource();
                break;
            	
                case '/call-details': 
                    require_once 'resources/CallDetailsResource.class.php';
                    $this -> resource = new CallDetailsResource();
                break;

                case '/locations': 
                    require_once 'resources/LocationsResource.class.php';
                    $this -> resource = new LocationsResource();
                break;

                case '/user': 
                    require_once 'resources/UserResource.class.php';
                    $this -> resource = new UserResource();
                break;

                case '/contacts': 
                    require_once 'resources/UserContactsResource.class.php';
                    $this -> resource = new UserContactsResource();
                break;

                case '/messages-summary': 
                    require_once 'resources/MessagesSummaryResource.class.php';
                    $this -> resource = new MessagesSummaryResource();
                break;

                case '/callDetails-summary': 
                    require_once 'resources/CallDetailsSummaryResource.class.php';
                    $this -> resource = new CallDetailsSummaryResource();
                break;

                default:
                    require_once 'exceptions/UnsupportedResourceTypeException.class.php';
            		throw new UnsupportedResourceTypeException();
                break;
            }
        	return $this -> resource;
        }

        public function toString() {
            return "Resource: " . $this -> resource;
        }
    }
