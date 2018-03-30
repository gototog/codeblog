<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction(Request $request)
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll()
        ;
        $article = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->getLastArticle();

        return $this->render('blog/homepage.html.twig', [
            'categories' => $categories,
            'article' => $article,
        ]);
    }
}
