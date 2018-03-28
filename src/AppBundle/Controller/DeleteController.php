<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

use AppBundle\Database\PostDatabase;

//Removes all rows in post table
class DeleteController
{
	private $templating;
	private $postDatabase;

	public function __construct(EngineInterface $templating, PostDatabase $postDatabase)
	{
		$this->templating = $templating;
		$this->postDatabase = $postDatabase;
	}

	//Gets all post data, renders view and passes in data for view
    public function indexAction(Request $request)
    {
    	$result = $this->postDatabase->deleteAllPosts();

        return $this->templating->renderResponse('default/delete.html.twig',['deleted' => $result]);
    }
}
