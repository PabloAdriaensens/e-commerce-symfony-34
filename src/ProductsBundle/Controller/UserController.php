<?php

namespace ProductsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use ProductsBundle\Entity\User;

/**
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @Route("/add")
     */
    public function addUser()
    {
        $user = new User();
        $user->setName("Juan");
        $user->setEmail("juan.martinez@gmail.com");
        $user->setPassword("12344321");
        $user->setCreatedAt(new \DateTime('now'));
        $user->setUpdatedAt(new \DateTime('now'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return new Response("Retorno user creado ->" . $user->getId());
    }
}
