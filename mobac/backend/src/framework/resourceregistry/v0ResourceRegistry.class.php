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
