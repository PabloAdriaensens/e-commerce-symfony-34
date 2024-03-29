<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use GlassBundle\Entity\Section;
use GlassBundle\Entity\Glass;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/sections", name="sections")
     */
    public function getAllSectionsAction()
    {
        $repository = $this->getDoctrine()->getRepository(Section::class);
        $sections = $repository->findBy(['active' => 1]);
        return $this->render('default/sidebar.html.twig', [
            'sections' => $sections
        ]);
    }

    /**
     * @Route("/glasses", name="home")
     */
    public function getAllGlassesAction()
    {
        $repository = $this->getDoctrine()->getRepository(Glass::class);
        $glasses = $repository->findAll();

        return $this->render('default/home.html.twig', [
            'glasses' => $glasses
        ]);
    }
}
