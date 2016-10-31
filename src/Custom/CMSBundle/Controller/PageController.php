<?php

namespace Custom\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Custom\CMSBundle\Entity\Page;
use Custom\CMSBundle\Form\PageType;

use Custom\CMSBundle\MyService\PagesSrv;
use Symfony\Component\HttpFoundation\Response;

/**
 * Page controller.
 *
 */
class PageController extends Controller
{
    /**
     * @Template()
     *
     * Lists all Page entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pages = $em->getRepository('CustomCMSBundle:Page')->findAll();

        return array(
            'pages' => $pages,
        );
    }

    /**
     * Creates a new Page entity.
     *
     */
    public function newAction(Request $request)
    {
        $page = new Page();
        $form = $this->createForm('Custom\CMSBundle\Form\PageType', $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // get logged in user
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $page->setOwner($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            return $this->redirectToRoute('cms_page_show', array('id' => $page->getId()));
        }

        return $this->render('CustomCMSBundle:Page:new.html.twig', array(
            'page' => $page,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Template("CustomCMSBundle:Page:show.html.twig")
     *
     * Finds and displays a Page entity.
     *
     */
    public function showAction(Page $page)
    {
        $deleteForm = $this->createDeleteForm($page);

        if (!$page)
            throw $this->createNotFoundException('Unable to find Page entity.');

        return array(
            'page' => $page,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Page entity.
     *
     */
    public function editAction(Request $request, Page $page)
    {
        $this->enforceOwnerSecurity($page);

        $deleteForm = $this->createDeleteForm($page);
        $editForm = $this->createForm('Custom\CMSBundle\Form\PageType', $page);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            return $this->redirectToRoute('cms_page_edit', array('id' => $page->getId()));
        }

        return $this->render('CustomCMSBundle:Page:edit.html.twig', array(
            'page' => $page,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Page entity.
     *
     */
    public function deleteAction(Request $request, Page $page)
    {
        $this->enforceOwnerSecurity($page);

        $form = $this->createDeleteForm($page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($page);
            $em->flush();
        }

        return $this->redirectToRoute('cms_page_index');
    }

    /**
     * Creates a form to delete a Page entity.
     *
     * @param Page $page The Page entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Page $page)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cms_page_delete', array('id' => $page->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Checks if that page is owned to logged in user
     *
     * @param Page $page The Page entity
     * @throws AccessDeniedException if user is not the owner of that page
     */
    public function enforceOwnerSecurity(Page $page)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if ( $user != $page->getOwner() ) {
            throw new AccessDeniedException("You do not own this!");
        }
    }

    /**
     * Renders a partial view with latest pages.
     *
     */
    public function _latestPagesAction($max = 3)
    {
        $em = $this->getDoctrine()->getManager();

        $pages = $em->getRepository('CustomCMSBundle:Page')->getLatestPages($max);

        return $this->render('CustomCMSBundle:Page:_latestPages.html.twig', array(
            'pages' => $pages,
        ));
    }

    /**
     * Testing page_srvc custom service
     *
     * @return Page a single page object
     */
    public function srvcAction()
    {
        $pageSrv = $this->container->get('page_srvc'); // or $this->get('page_srvc');
        $response = new Response($pageSrv->fetchOnePage());

        return $response;
    }
}
