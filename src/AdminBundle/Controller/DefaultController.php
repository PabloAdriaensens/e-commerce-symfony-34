<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use ProductsBundle\Entity\Glass;

/**
 * @Route("/admin")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="admin")
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository(Glass::class);
        $glasses = $repository->findAll();
        return $this->render('@Admin/Default/index.html.twig', [
            'glasses' => $glasses
        ]);
    }

    /**
     * @Route("/add")
     */
    public function addGlass(Request $request)
    {
        $glass = new Glass();

        $form = $this->createFormBuilder($glass)
            ->add('name')
            ->add('image')
            ->add('category')
            ->add('price')
            ->add('save', SubmitType::class, ['label' => 'Add Glass'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $glass = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($glass);
            $entityManager->flush();

            return $this->redirectToRoute('admin');
        }


        return $this->render('@Admin/Default/addGlass.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
