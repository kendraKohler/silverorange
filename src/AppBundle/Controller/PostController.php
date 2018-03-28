<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class PostController
{
	private $templating;

	public function __construct(EngineInterface $templating)
	{
		$this->templating = $templating;
	}

    public function indexAction(Request $request)
    {
        return $this->templating->renderResponse('default/post.html.twig');
    }
}
