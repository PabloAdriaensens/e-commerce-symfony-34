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

        $totalSum = 0;

        foreach($cartItems as $item) {
            $totalSum += $item->getQuantity() * $item->getProduct()->getPrice();
        }

        return $this->render('default/shopping-cart.html.twig', [
            'glasses' => array_slice($allGlasses, 0, 3), // gafas que te pueden interesar
            'cartItems' => $cartItems, // items del carrito,
            'totalSum' => $totalSum 
        ]);
    }
    /**
     * @Route("/", name="delete-shopping-cart")
     */
    public function deleteCartItem()
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

    /**
     * @param Cart $item
     *
     * @Route("/{id}/less-quantity", requirements={"id" = "\d+"}, name="less-quantity-sc")
     *
     */
    public function lessQuantityItemShoppingCart(Cart $item)
    {
        $entityManager = $this->getDoctrine()->getManager();

        // Logica
        if ($item->getQuantity() === 1) {
            // Borrar del carrito
            $entityManager->remove($item);
            $entityManager->flush();
        } else {
            // Decrementar
            $item->setQuantity($item->getQuantity() - 1);
            $entityManager->persist($item);
            $entityManager->flush();
        }

        // Redirigir
        $response = $this->redirectToRoute('shopping-cart-list');

        return $response;
    }

    /**
     * @param Cart $item
     *
     * @Route("/{id}/add-quantity", requirements={"id" = "\d+"}, name="add-quantity-sc")
     *
     */
    public function addQuantityItemShoppingCart(Cart $item)
    {
        $entityManager = $this->getDoctrine()->getManager();

        // Logica
        // Aumentar
        $item->setQuantity($item->getQuantity() + 1);
        $entityManager->persist($item);
        $entityManager->flush();

        // Redirigir
        $response = $this->redirectToRoute('shopping-cart-list');

        return $response;
    }

    /**
     * @param Cart $item
     *
     * @Route("/{id}/remove-item", requirements={"id" = "\d+"}, name="remove-item-sc")
     *
     */
    public function removeItemShoppingCart(Cart $item)
    {
        $entityManager = $this->getDoctrine()->getManager();

        // Logica
        // Eliminar un item en concreto
        $entityManager->remove($item);
        $entityManager->flush();

        // Redirigir
        $response = $this->redirectToRoute('shopping-cart-list');

        return $response;
    }
}
