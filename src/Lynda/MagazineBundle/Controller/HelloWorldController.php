<?php

namespace Lynda\MagazineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class HelloWorldController extends Controller
{
    /**
     * @Route("/hello")
     */
    public function indexAction()
    {
        return $this->render(
        	'LyndaMagazineBundle:Default:index.html.twig',
        	array(
        		'name' => 'geobas',
        	)
        );
    }

    /**
     * @Route("/hello/{name}")
     */
    public function index2Action($name)
    {
        return $this->render(
        	'LyndaMagazineBundle:Default:index.html.twig',
        	array(
        		'name' => $name,
        	)
        );
    }    
}
