<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use AppBundle\Model\PostModel;


class ImportController
{

    public function indexAction(Request $request)
    {
    	// Get json request data as object
    	$jsonData = $request->getContent();
    	error_log('JSON DATA: ' . print_r($jsonData,1));

    	$postData = json_decode($jsonData);
    	error_log('POST DATA ID: ' . $postData->id);

    	// Create post model using json data
    	$postModel = new PostModel();

    	//Issue with symfony constructor work around
    	$postModel->initialize(
    		$postData->id,
    		$postData->title,
    		$postData->body,
    		$postData->created_at,
    		$postData->modified_at,
    		$postData->author);

    	error_log('POST MODEL ID: ' . print_r($postModel,1));
    }
}


