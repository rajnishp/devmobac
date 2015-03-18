<?php

/**
 * @author Rahul Lahoria (rahul.lahoria@capillarytech.com)
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/Post.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class PostsToShareResource implements Resource {

   private $postsDAO;
   private $posts;

    public function __construct() {
        $DAOFactory = new DAOFactory();
        $this->postsDAO = $DAOFactory->getpostsDAO();
    }

    public function checkIfRequestMethodValid($requestMethod) {
        return in_array($requestMethod, array('get', 'put', 'post', 'delete', 'options'));
    }

    public function options($resourceVals, $data) {    }

    public function delete ($resourceVals, $data) {    }

    public function put ($resourceVals, $data) {    }

    public function post ($resourceVals, $data) {
        global $logger, $warnings_payload;
        
        $postId = $resourceVals ['posts-to-share'];

        if (! isset($postId)) {
            $warnings_payload [] = 'POST call to /posts-to-share must be succeeded ' . 
                                    'by /post_id i.e. POST /posts-to-share/post_id';
            throw new UnsupportedResourceMethodException();
        }
        
        $postObj = $this -> postsDAO -> load($postId);
        
        if(! is_object($postObj)) 
            return array('code' => '2004');

        $postObj -> setShareCount($postObj -> getShareCount() + 1);
        
        $logger -> debug('POST Post object: ' . $postObj -> toString());
        $result = $this -> postsDAO -> update($postObj);
        $logger -> debug('Updated entry: ' . $result);
        

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

    public function get($resourceVals, $data) {
        
        $postToShareId = $resourceVals ['posts'];
        if (isset($postToShareId)){
            $warnings_payload [] = ' call to /posts must be succeeded ' . 
                                    'by /post_id i.e. PUT /posts/post_id';
            throw new UnsupportedResourceMethodException();
        }
        else    
            $result = $this->getpostToShare();

        if (!is_array($result)) {
            return array('code' => '6004');
        }

        return $result;
    }

    private function getpostToShare() {
        global $logger;
        $logger->debug('Fetch list of  post...');

        $listOfPostToShareObjs = $this -> postsDAO -> getPostToShare();

        if(empty($listOfPostToShareObjs)) 
                return array('code' => '2004');

        
        foreach ($listOfPostToShareObjs as $postObj) {
                $post = $postObj -> toArray();
                $this -> posts [] = $post;
        }
        $logger -> debug ('Fetched list of Posts: ' . json_encode($this -> posts));

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
        
        if (!isset($data ['shareCount']))
            throw new MissingParametersException("'shareCount' field is missing");
    }

}