<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use GlassBundle\Entity\Section;

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
        $sections = $repository->findAll();
        return $this->render('default/sidebar.html.twig', [
            'sections' => $sections
        ]);
    }

}
