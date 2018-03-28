<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;


class ImportController
{

    public function indexAction(Request $request)
    {
        error_log('HITTING POST CONTROLLER');
    }
}
