<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HelloController extends Controller
{
    /**
     * @Route("/hello/{name}", name="hello_name")
     */
    public function helloNameAction(Request $request, $name = "world")
    {
        //return $this->render('hello/hello_name.html.twig', array(
        return $this->render('hello/hello_name.html.twig', array(
            'name' => $name,
        ));
    }


}
