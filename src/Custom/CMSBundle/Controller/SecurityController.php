<?php

namespace Custom\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Security controller.
 *
 */
class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @Template("CustomCMSBundle:security:login.html.twig")
     *
     */
    public function loginAction(Request $request)
    {
	    $authenticationUtils = $this->get('security.authentication_utils');

	    // get the login error if there is one
	    $error = $authenticationUtils->getLastAuthenticationError();

	    // last username entered by the user
	    // $lastUsername = $authenticationUtils->getLastUsername();

	    return array(
            // last username entered by the user
            // 'last_username' => $lastUsername,
            'error'         => $error,
	    );
    }
}