<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminHomeController extends AbstractController
{
    /**
     * @Route("/home", name="admin_home")
     */
    public function index(): Response
    {
        return $this->render('admin_home/calendar.html.twig', [
            'controller_name' => 'AdminHomeController',
        ]);
    }
}
