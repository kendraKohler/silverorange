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

    	$postData = json_decode($jsonData);

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

    }
}


