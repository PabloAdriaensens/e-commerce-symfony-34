<?php

namespace GlassBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use GlassBundle\Entity\Section;
use GlassBundle\Entity\Glass;
use CartBundle\Entity\Cart;

/**
 * @Route("/glasses")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('@Glass/Default/index.html.twig');
    }

    /**
     * @Route("/", name="home")
     */
    public function getAllSections()
    {
        $repository = $this->getDoctrine()->getRepository(Section::class);
        $sections = $repository->findAll();
        return $this->render('@GlassBundle/Default/index.html.twig', [
            'sections' => $sections
        ]);
    }

    /**
     * @Route("/{id}", name="get_glass", requirements={"id"="\d+"})
     */
    public function getGlass($id)
    {
        $repository = $this->getDoctrine()->getRepository(Glass::class);
        $glasses = $repository->findBy(
            ['id' => $id]
        );
        return $this->render('default/get_glass.html.twig', [
            'glasses' => $glasses
        ]);
    }

    /**
     * @param Glass $glass
     *
     * @Route("/{id}/add-shopping-cart", requirements={"id" = "\d+"}, name="add_shopping_cart")
     *
     */
    public function addItemToShoppingCart(Glass $glass)
    {
        // Insertar producto al carrito
        $item = new Cart();
        $item->setQuantity(1);
        $item->setProduct($glass);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($item);
        $entityManager->flush();

        // Redirigir
        $response = $this->redirectToRoute('shopping-cart-list');

        return $response;
    }
}
