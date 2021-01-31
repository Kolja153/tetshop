<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AttributeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Attributetype controller.
 *
 * @Route("attributetype")
 */
class AttributeTypeController extends Controller
{
    /**
     * Lists all attributeType entities.
     *
     * @Route("/", name="attributetype_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $attributeTypes = $em->getRepository('AppBundle:AttributeType')->findAll();

        return $this->render('attributetype/index.html.twig', array(
            'attributeTypes' => $attributeTypes,
        ));
    }

    /**
     * Creates a new attributeType entity.
     *
     * @Route("/new", name="attributetype_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $attributeType = new Attributetype();
        $form = $this->createForm('AppBundle\Form\AttributeTypeType', $attributeType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($attributeType);
            $em->flush();

            return $this->redirectToRoute('attributetype_edit', array('id' => $attributeType->getId()));
        }

        return $this->render('attributetype/new.html.twig', array(
            'attributeType' => $attributeType,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing attributeType entity.
     *
     * @Route("/{id}/edit", name="attributetype_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AttributeType $attributeType)
    {
        $deleteForm = $this->createDeleteForm($attributeType);
        $editForm = $this->createForm('AppBundle\Form\AttributeTypeType', $attributeType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('attributetype_edit', array('id' => $attributeType->getId()));
        }

        return $this->render('attributetype/edit.html.twig', array(
            'attributeType' => $attributeType,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a attributeType entity.
     *
     * @Route("/{id}", name="attributetype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, AttributeType $attributeType)
    {
        $form = $this->createDeleteForm($attributeType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($attributeType);
            $em->flush();
        }

        return $this->redirectToRoute('attributetype_index');
    }

    /**
     * Creates a form to delete a attributeType entity.
     *
     * @param AttributeType $attributeType The attributeType entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AttributeType $attributeType)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('attributetype_delete', array('id' => $attributeType->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
