<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    /**
     * @Route("/", methods={"GET","HEAD"}, name="home")
     */
    public function getHome()
    {
        return $this->render('index.html.twig');
    }
}
