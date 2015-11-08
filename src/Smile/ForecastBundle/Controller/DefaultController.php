<?php

namespace Smile\ForecastBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SmileForecastBundle:Default:index.html.twig', array('name' => $name));
    }
}
