<?php

namespace GlassBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
}
