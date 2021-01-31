<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Attribute;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Attribute controller.
 *
 * @Route("attribute")
 */
class AttributeController extends Controller
{
    /**
     * Lists all attribute entities.
     *
     * @Route("/", name="attribute_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $attributes = $em->getRepository('AppBundle:Attribute')->findAll();

        return $this->render('attribute/index.html.twig', array(
            'attributes' => $attributes,
        ));
    }

    /**
     * Creates a new attribute entity.
     *
     * @Route("/new", name="attribute_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $attribute = new Attribute();
        $form = $this->createForm('AppBundle\Form\AttributeType', $attribute);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($attribute);
            $em->flush();

            return $this->redirectToRoute('attribute_edit', array('id' => $attribute->getId()));
        }

        return $this->render('attribute/new.html.twig', array(
            'attribute' => $attribute,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing attribute entity.
     *
     * @Route("/{id}/edit", name="attribute_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Attribute $attribute)
    {
        $deleteForm = $this->createDeleteForm($attribute);
        $editForm = $this->createForm('AppBundle\Form\AttributeType', $attribute);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('attribute_edit', array('id' => $attribute->getId()));
        }

        return $this->render('attribute/edit.html.twig', array(
            'attribute' => $attribute,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a attribute entity.
     *
     * @Route("/{id}", name="attribute_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Attribute $attribute)
    {
        $form = $this->createDeleteForm($attribute);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($attribute);
            $em->flush();
        }

        return $this->redirectToRoute('attribute_index');
    }

    /**
     * Creates a form to delete a attribute entity.
     *
     * @param Attribute $attribute The attribute entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Attribute $attribute)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('attribute_delete', array('id' => $attribute->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
