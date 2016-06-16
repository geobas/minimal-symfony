<?php

namespace Custom\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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

    /**
     * Finds and displays a Page entity.
     *
     * @Route("page/{id}", name="cms_page_display")
     * @Method("GET")
     */
    public function displayAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$page = $em->getRepository('CustomCMSBundle:Page')->find($id);
        return $this->render('CustomCMSBundle:Default:display.html.twig', array(
        		'page' => $page
        	));
    }    
}
