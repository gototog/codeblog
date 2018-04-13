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
            ->getDisplayableCategories()
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


    /**
     * @Route("/contents", name="blog_contents")
     */
    public function listContentAction(Request $request)
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->getDisplayableCategories()
        ;
        $article = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        return $this->render('blog/contents.html.twig', [
            'categories' => $categories,
            'articles' => $article,
        ]);
    }

    /**
     * @Route("/contents/{category_id}", name="byCategory")
     */
    public function getByCat($category_id)
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->getDisplayableCategories()
        ;
        $article = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->findBy(array('category' => $category_id));

        return $this->render('blog/contents.html.twig', [
            'categories' => $categories,
            'articles' => $article,
        ]);
    }
}
