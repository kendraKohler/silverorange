<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use AppBundle\Model\PostModel;
use AppBundle\Database\PostDatabase;

//Imports post data to database, can not be hit by GET
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
    	// Get json request data as object, decode to object
    	$jsonData = $request->getContent();
    	$postData = json_decode($jsonData);


		//Loop through data if array is sent
    	if(is_array($postData))
    	{
    		foreach($postData as $currentData)
    		{
    			$this->saveToDatabase($currentData);
    		}
    	}
    	else
    	{
    		$this->saveToDatabase($postData);
    	}

    }

	// Store in model and save to database
    private function saveToDatabase($data)
    {

		// Create post model using json data
    	$postModel = new PostModel();

    	//Issue with symfony constructor work around
    	$postModel->initialize(
    		$data->id,
    		$data->title,
    		$data->body,
    		$data->created_at,
    		$data->modified_at,
    		$data->author);

    	// Save to database
    	$this->postDatabase->savePost($postModel);
    }
}


