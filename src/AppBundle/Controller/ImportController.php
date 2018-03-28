<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;


class ImportController
{

    public function indexAction(Request $request)
    {
    	$jsonData = $request->getContent();
        error_log('JSON DATA IS: '.print_r($jsonData,1);
    }
}
