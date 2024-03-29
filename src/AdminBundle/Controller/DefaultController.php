<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use GlassBundle\Entity\Glass;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use GlassBundle\Entity\Section;

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


        $repository = $this->getDoctrine()->getRepository(Section::class);
        $sections = $repository->findAll();

        $sectionsArray = array();


        foreach ($sections as $idx => $section) {
            $sectionsArray[$section->getTitle()] = $section->getId();
        }

        $form = $this->createFormBuilder($glass)
            ->add('name')
            ->add('image')
            ->add('category', ChoiceType::class, [
                'choices'  => $sectionsArray
            ])
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

    /**
     * @Route("/{id}/edit", name="edit-glass")
     */
    public function editGlass(Request $request, Glass $glass)
    {
        $repository = $this->getDoctrine()->getRepository(Section::class);
        $sections = $repository->findAll();

        $sectionsArray = array();


        foreach ($sections as $idx => $section) {
            $sectionsArray[$section->getTitle()] = $section->getId();
        }

        $form = $this->createFormBuilder($glass)
        ->add('name')
        ->add('image')
        ->add('category', ChoiceType::class, [
            'choices'  => $sectionsArray
        ])
        ->add('price')
        ->add('save', SubmitType::class, ['label' => 'Edit Glass'])
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('admin', [
                'id' => $glass->getId(),
            ]);
        }
        return $this->render('@Admin/Default/editGlass.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Glass $glass
     *
     * @Route("/{id}/remove-glasses", requirements={"id" = "\d+"}, name="remove-glasses")
     *
     */
    public function removeGlasses(Glass $glass)
    {
        $entityManager = $this->getDoctrine()->getManager();

        // Logica
        // Eliminar un item en concreto
        $entityManager->remove($glass);
        $entityManager->flush();

        // Redirigir
        $response = $this->redirectToRoute('admin');

        return $response;
    }
}
