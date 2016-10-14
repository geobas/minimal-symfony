<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // return new Response('Hello !!!');

        /* $data = array(
                    'fname' => "Geo",
                    'lname' => "Bas",
                    'state' => "Athens",
                );

        $data = json_encode($data);

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response; */

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
}
