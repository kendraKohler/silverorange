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

    public function indexAction(Request $request)
    {
    	$allPosts = $this->postDatabase->getAllPosts();

    	error_log('ALL POSTS: '.print_r($allPosts,1));
        return $this->templating->renderResponse('default/post.html.twig');
    }

    public function getIdAction(Request $request)
    {
    	$id = $request->attributes->get('id');

    	$postModel = $this->postDatabase->getPostById($id);

        return $this->templating->renderResponse('default/postId.html.twig',[
        	'title' => $postModel->title(),
        	'body' => $postModel->body(),
        	'authorName' =>$postModel->author()->fullName()]);
    }
}
