<?php

namespace CartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GlassBundle\Entity\Glass;
use CartBundle\Entity\Cart;

/**
 * @Route("/shopping-cart")
 */
class CartController extends Controller
{
    /**
     * @Route("/", name="shopping-cart-list")
     */
    public function indexAction()
    {
        $repositoryGlasses = $this->getDoctrine()->getRepository(Glass::class);
        $allGlasses = $repositoryGlasses->findAll();

        $repositoryCartItems = $this->getDoctrine()->getRepository(Cart::class);
        $cartItems = $repositoryCartItems->findAll();

        return $this->render('default/shopping-cart.html.twig', [
            'glasses' => $allGlasses, // gafas que te pueden interesar
            'cartItems' => $cartItems // items del carrito
        ]);
    }
}
