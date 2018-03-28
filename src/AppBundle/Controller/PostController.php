<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

use AppBundle\Database\PostDatabase;

class PostController
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
    	$allPosts = $this->postDatabase->getAllPosts();

    	$allPostsViewData = $this->prepareAllPostsForView($allPosts);

        return $this->templating->renderResponse('default/post.html.twig',['posts' => $allPostsViewData]);
    }

    //Gets post data by id, renders view and passes in data for view
    public function getIdAction(Request $request)
    {
    	$id = $request->attributes->get('id');

    	$postModel = $this->postDatabase->getPostById($id);

        return $this->templating->renderResponse('default/postId.html.twig',[
        	'title' => $postModel->title(),
        	'body' => $postModel->body(),
        	'authorName' =>$postModel->author()->fullName()]);
    }

	//Orders post models in reverse order of the created at date
    private function orderPosts($postModels)
    {
    	usort($postModels,
    		function($a,$b)
    		{
    			return strcmp($a->createdAt(),$b->createdAt());    		
    		});

    	return array_reverse($postModels);
    }

	// Orders the models and assigns the data for the view
    private function prepareAllPostsForView($postModels)
    {
    	$viewData = [];
    	$sortedModels = $this->orderPosts($postModels);

    	foreach($sortedModels as $currentModel)
    	{
    		array_push($viewData,[
    			'title' => $currentModel->title(),
        		'body' => $currentModel->body(),
        		'authorName' =>$currentModel->author()->fullName(),
        		'created' => $currentModel->createdAt()]);
    	}
    	return $viewData;
    }
}
