<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/admin")
     */
    public function indexAction()
    {
        return $this->render('@Admin/Default/admin.html.twig');
    }
    /**
     * @Route("/add", name="add")
     */
    public function nuevoEquipoTemp()
    {
        return $this->render('/add.html.twig');
    }

}
