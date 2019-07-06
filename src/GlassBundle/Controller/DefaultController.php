<?php

namespace GlassBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use GlassBundle\Entity\Section;
use GlassBundle\Entity\Glass;

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
}
