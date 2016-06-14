<?php

namespace Custom\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="cms_homepage")
     */
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$pages = $em->getRepository('CustomCMSBundle:Page')->findAll();
        return $this->render('CustomCMSBundle:Default:index.html.twig', array(
        		'pages' => $pages
        	));
    }
}
