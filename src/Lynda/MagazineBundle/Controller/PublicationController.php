<?php

namespace Lynda\MagazineBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Lynda\MagazineBundle\Entity\Publication;
use Lynda\MagazineBundle\Form\PublicationType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Publication controller.
 *
 * @Route("/publication")
 */
class PublicationController extends Controller
{
    /**
     * Lists all Publication entities.
     *
     * @Route("/", name="publication_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $publications = $em->getRepository('LyndaMagazineBundle:Publication')->findAll();

        return $this->render('publication/index.html.twig', array(
            'publications' => $publications,
        ));
    }

    /**
     * Creates a new Publication entity.
     *
     * @Route("/new", name="publication_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $publication = new Publication();
        $form = $this->createForm('Lynda\MagazineBundle\Form\PublicationType', $publication);
        // $form->add('submit', 'submit', array('label' => 'Create PublicatioN'));
        $form->add('submit', SubmitType::class, array('label' => 'Create PublicatioN'));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($publication);
            $em->flush();

            $this->get('session')->getFlashBag()->add('msg', 'Publication has been created.');

            return $this->redirectToRoute('publication_show', array('id' => $publication->getId()));
        } 
        else if ( $form->isSubmitted() && !$form->isValid() )
        {
            $this->get('session')->getFlashBag()->add('msg', 'Invalid form field(s).');
        }

        return $this->render('publication/new.html.twig', array(
            'publication' => $publication,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Publication entity.
     *
     * @Route("/{id}", name="publication_show")
     * @Method("GET")
     */
    public function showAction(Publication $publication)
    {
        $deleteForm = $this->createDeleteForm($publication);

        return $this->render('publication/show.html.twig', array(
            'publication' => $publication,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Publication entity.
     *
     * @Route("/{id}/edit", name="publication_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Publication $publication)
    {
        $deleteForm = $this->createDeleteForm($publication);
        $editForm = $this->createForm('Lynda\MagazineBundle\Form\PublicationType', $publication);
        // $editForm->add('submit', 'submit', array('label' => 'Edit PublicatioN'));
        $editForm->add('submit', SubmitType::class, array('label' => 'Edit PublicatioN'));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($publication);
            $em->flush();

            $this->get('session')->getFlashBag()->add('msg', 'Publication has been edited.');

            return $this->redirectToRoute('publication_edit', array('id' => $publication->getId()));
        }

        return $this->render('publication/edit.html.twig', array(
            'publication' => $publication,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Publication entity.
     *
     * @Route("/{id}", name="publication_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Publication $publication)
    {
        $form = $this->createDeleteForm($publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($publication);
            $em->flush();
        }

        $this->get('session')->getFlashBag()->add('msg', 'Publication ' . $publication->getName() . ' has been deleted.');

        return $this->redirectToRoute('publication_index');
    }

    /**
     * Creates a form to delete a Publication entity.
     *
     * @param Publication $publication The Publication entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Publication $publication)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('publication_delete', array('id' => $publication->getId())))
            ->setMethod('DELETE')
            // ->add('submit', 'submit', array('label' => 'Delete me'))
            ->add('submit', SubmitType::class, array('label' => 'Delete me'))
            ->getForm()
        ;
    }
}
 