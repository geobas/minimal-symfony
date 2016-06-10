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
        return $this->render('CustomCMSBundle:Default:index.html.twig');
    }
}
