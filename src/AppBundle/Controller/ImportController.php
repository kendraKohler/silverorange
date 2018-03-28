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

    	// Create most model using json data
    	$postModel = new PostModel(
    		$postData->id,
    		$postData->title,
    		$postData->body,
    		$postData->created_at,
    		$postData->modified_at,
    		$postData->author);

    	error_log('POST MODEL: ' . print_r($postModel,1));
    }
}


