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
     * @Route("/{id}/add-shopping-cart", requirements={"id" = "\d+"}, name="add-shopping-cart")
     *
     */
    public function addItemToShoppingCart(Glass $glass)
    {
        $repository = $this->getDoctrine()->getRepository(Cart::class);
        $entityManager = $this->getDoctrine()->getManager();
        $existingItem = $repository->findOneBy([
            'product' => $glass,
            'user' => $this->getUser()
        ]);

        if ($existingItem) {
            // Actualizar la cantidad
            $existingQuantity = $existingItem->getQuantity();
            $quantityToUpdate = $existingQuantity + 1;
            $existingItem->setQuantity($quantityToUpdate);
            $entityManager->persist($existingItem);
            $entityManager->flush();
        } else {
            // Insertar producto al carrito
            $item = new Cart();
            $item->setQuantity(1);
            $item->setProduct($glass);
            $item->setUser($this->getUser());
            $entityManager->persist($item);
            $entityManager->flush();
        }

        // Redirigir
        $response = $this->redirectToRoute('shopping-cart-list');

        return $response;
    }

    /**
     * @param Glass $glass
     *
     * @Route("/delete-shopping-cart", name="delete-shopping-cart")
     *
     */
    public function deleteItemsShoppingCart()
    {
        // Eliminar productos del carrito
        $repository = $this->getDoctrine()->getRepository(Cart::class);
        $itemsCart = $repository->findBy(['user' => $this->getUser()]);
        $entityManager = $this->getDoctrine()->getManager();

        foreach ($itemsCart as $itemCart) {
            $entityManager->remove($itemCart);
        }

        $entityManager->flush();

        // Redirigir
        $response = $this->redirectToRoute('shopping-cart-list');

        return $response;
    }
}
