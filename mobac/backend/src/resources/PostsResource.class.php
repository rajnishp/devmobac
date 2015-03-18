<?php

/**
 * @author Rahul Lahoria (rahul.lahoria@capillarytech.com)
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/Post.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class PostsResource implements Resource {

    private $postDAO;
    private $posts;

    public function __construct() {
		$DAOFactory = new DAOFactory();
		$this->postDAO = $DAOFactory->getPostsDAO();
    }

    public function checkIfRequestMethodValid($requestMethod) {
		return in_array($requestMethod, array('get', 'put', 'post', 'delete', 'options'));
    }

    public function options() {    }

    
    public function delete ($resourceVals, $data) {
        global $logger, $warnings_payload; 
        $postId = $resourceVals ['posts'];

        if (! isset($postId)) {
            $warnings_payload [] = 'DELETE call to /posts must be succeeded ' .  
                                        'by /postId i.e. DELETE /posts/postId';
            throw new UnsupportedResourceMethodException();
        }
        $logger -> debug ("Delete post with Id: " . $postId);-
        
        $result = $this -> postDAO -> delete($postId);
        $logger -> debug ("Post Deleted? " . $result);

        if ($result) 
            $result = array('code' => '2003');
        else 
            $result = array('code' => '2004');

        return $result;
    }

    public function put ($resourceVals, $data) {
        global $logger, $warnings_payload;
        $update = false;
        
        $postId = $resourceVals ['posts'];

        if (! isset($postId)) {
            $warnings_payload [] = 'PUT call to /posts must be succeeded ' . 
                                    'by /post_id i.e. PUT /posts/post_id';
            throw new UnsupportedResourceMethodException();
        }
        if (! isset($data))
            throw new MissingParametersException('No fields specified for updation');

        $postObj = $this -> postDAO -> load($postId);
        
        if(! is_object($postObj)) 
            return array('code' => '2004');

        $newChId= $data ['chId'];
        if (isset($newChId)) {
            if ($newChId != $postObj -> getChId()) {
                $update = true;
                $postObj -> setChId($newChId);
            }
        }

        $newTitle = $data ['title'];
        if (isset($newTitle)) {
            if ($newTitle != $postObj -> getTitle()){
                $update = true;
                $postObj -> setTitle($newTitle);
            }
        }


        $newHashtag = $data ['hashtag'];
        if (isset($newHashtag)) {
            if ($newHashtag != $postObj -> getHashtag()){
                $update = true;
                $postObj -> setHashtag($newHashtag);
            }
        }


        if ($update) {
            $logger -> debug('PUT Post object: ' . $postObj -> toString());
            $result = $this -> postDAO -> update($postObj);
            $logger -> debug('Updated entry: ' . $result);
        }

        $posts = $postObj -> toArray();
        $this -> posts [] = $posts;

        if(! isset($posts ['id'])) 
            return array('code' => '2004');

        return array('code' => '2002', 
                        'data' => array(
                            'posts' => $this -> posts
                        )
        );
    }

    public function post ($resourceVals, $data) {
        global $logger, $warnings_payload;

        $postId = $resourceVals ['posts'];
        if (isset($postId)) {
            $warnings_payload [] = 'POST call to /posts must not have ' . 
                                        '/POST_ID appended i.e. POST /posts';
            throw new UnsupportedResourceMethodException();
        }

        $this -> sanitize($data);

        $postObj = new Post($data ['chId'], $data ['title'], $data ['hashtag'], 0);
        $logger -> debug ("POSTed post: " . $postObj -> toString());

        $this -> postDAO -> insert($postObj);

        $posts = $postObj -> toArray();
        
        if(! isset($posts ['id'])) 
            return array('code' => '2011');

        $this -> posts[] = $posts;
        return array ('code' => '2001', 
                        'data' => array(
                            'posts' => $this -> posts
                        )
        );
    }

    private function create($postObj) {

    }


    public function get($resourceVals, $data) {
		
		$postId = $resourceVals ['posts'];
		if (isset($postId))
			$result = $this->getPost($postId);
		else	
			$result = $this->getListOfAllPosts();

		if (!is_array($result)) {
		    return array('code' => '6004');
		}

		return $result;
    }

    private function getPost($postId) {
		global $logger;
		$logger->debug('Fetch list of  post...');

		$postObj = $this -> postDAO -> load($postId);

        if(empty($postObj)) 
                return array('code' => '2004');

        
             
        $this -> posts [] = $postObj-> toArray();
        
        $logger -> debug ('Fetched list of Channels: ' . json_encode($this -> posts));

        return array('code' => '2000', 
                     'data' => array(
                                'posts' => $this -> posts
                            )
            );
    }

    private function getListOfAllPosts() {
		global $logger;
		$logger->debug('Fetch list of all post...');

		$listOfPostObjs = $this -> postDAO -> readAll();

        if(empty($listOfPostObjs)) 
                return array('code' => '2004');

        foreach ($listOfPostObjs as $postObj) {
                $post = $postObj -> toArray();
                $this -> posts [] = $post;
        }
        $logger -> debug ('Fetched list of Channels: ' . json_encode($this -> posts));

        return array('code' => '2000', 
                     'data' => array(
                                'posts' => $this -> posts
                            )
            );
    }


    private function sanitize($data) {
		if (!isset($data ['chId']))
	    	throw new MissingParametersException("'chId' field is missing");

		if (!isset($data ['title']))
	    	throw new MissingParametersException("'title' field is missing");

	    if (!isset($data ['hashtag']))
	    	throw new MissingParametersException("'hashtag' field is missing");
    }

}
