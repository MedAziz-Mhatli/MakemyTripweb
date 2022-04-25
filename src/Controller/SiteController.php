<?php
/**
 * Created by PhpStorm.
 * User: giorgiopagnoni
 * Date: 17/01/18
 * Time: 11:49
 */

namespace App\Controller;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SiteController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @return Response
     */
    function homepage()
    {

        return $this->render('index.html.twig');


    }




}