<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GlassBundle\Entity\Glass;

class SectionController extends Controller
{
    /**
     * @Route("/sections/{id}/glasses", name="section_glasses_list", requirements={"id"="\d+"})
     */
    public function listGlasses($id)
    {
        $repository = $this->getDoctrine()->getRepository(Glass::class);
        $glasses = $repository->findBy(
            ['category' => $id]
        );
        return $this->render('default/section_glasses_list.html.twig', [
            'glasses' => $glasses
        ]);
    }
}
