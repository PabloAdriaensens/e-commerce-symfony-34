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
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('@Admin/Default/index.html.twig');
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
            ->add('created_at')
            ->add('updated_at')
            ->add('save', SubmitType::class, ['label' => 'Add Glass'])
            ->getForm();

        return $this->render('@Admin/Default/addGlass.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}