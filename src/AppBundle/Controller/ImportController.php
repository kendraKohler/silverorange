<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use AppBundle\Model\PostModel;
use AppBundle\Database\PostDatabase;


class ImportController
{
	private $postDatabase;

	public function __construct(PostDatabase $postDatabase)
	{
		$this->postDatabase = $postDatabase;
	}

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

    	// Save to database
    	$this->postDatabase->savePost($postModel);

    }
}


