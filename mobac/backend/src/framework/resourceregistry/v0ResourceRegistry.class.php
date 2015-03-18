<?php

	/**
	 * @author Rahul Lahoria
	 */

	require_once 'ResourceRegistry.interface.php';

    class v0ResourceRegistry implements ResourceRegistry{

        private $resource = null;

        public function lookupResource ($resourceType) {

            switch($resourceType) {

            	case '/posts': 
            		require_once 'resources/PostsResource.class.php';
            		$this -> resource = new PostsResource();
                break;

                case '/posts-to-share': 
                    require_once 'resources/PostsToShareResource.class.php';
                    $this -> resource = new PostsToShareResource();
                break;

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
