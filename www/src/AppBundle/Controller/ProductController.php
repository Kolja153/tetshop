<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Attribute;
use AppBundle\Entity\AttributeType;
use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Product controller.
 *
 * @Route("product")
 */
class ProductController extends Controller
{
    /**
     * Search products.
     *
     * @Route("/seach", name="product_search")
     * @Method("GET")
     */
    public function searchAction(Request $request)
    {
        $query = $request->get('q');

        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository(Product::class)->findProductByName($query);

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * Lists all product entities.
     *
     * @Route("/", name="product_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository(Product::class)->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * Creates a new product entity.
     *
     * @Route("/new", name="product_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attr = $em->getRepository(Attribute::class)->findByIds($form->getExtraData()['attributes']);
            $colection = new ArrayCollection($attr);
            $product->setAttributes($colection);
            $em = $this->getDoctrine()->getManager();

            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product_edit', ['id' => $product->getId()]);
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'attributes' => $em->getRepository(AttributeType::class)->findAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     * @Route("/{id}/edit", name="product_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Product $product)
    {
        $em = $this->getDoctrine()->getManager();

        $deleteForm = $this->createDeleteForm($product);
        $editForm = $this->createForm(ProductType::class, $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $attr = $em->getRepository(Attribute::class)->findByIds($editForm->getExtraData()['attributes']);
            $colection = new ArrayCollection($attr);
            $product->setAttributes($colection);
            $product->setUpdatedAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_edit', ['id' => $product->getId()]);
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'attributes' => $em->getRepository(AttributeType::class)->findAll(),
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a product entity.
     *
     * @Route("/{id}", name="product_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Product $product)
    {
        $form = $this->createDeleteForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
        }

        return $this->redirectToRoute('product_index');
    }

    /**
     * Creates a form to delete a product entity.
     *
     * @param Product $product The product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', ['id' => $product->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }
}
