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

	//Gets posted data and saves to the database
    public function indexAction(Request $request)
    {
    	// Get json request data as object, otherwise save normally
    	$jsonData = $request->getContent();

		//Loop through data if array is sent
    	if(is_array($jsonData))
    	{
    		foreach($jsonData as $currentData)
    		{
    			$this->saveToDatabase($currentData);
    		}
    	}
    	else
    	{
    		$this->saveToDatabase($jsonData);
    	}

    }

	// Decode json data, store in model and save to database
    private function saveToDatabase($data)
    {
    	//Decode json data
		$postData = json_decode($data);

		if($postData)
		{
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
}


