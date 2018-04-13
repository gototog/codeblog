<?php
/**
 * Created by PhpStorm.
 * User: fred
 * Date: 13/04/18
 * Time: 09:47
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Article;
use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Repository\CategoryRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ArticleCategoryController extends Controller
{

    /**
     *
     * @Route("/ArticleCategory/{id}")
     */
    public function showArticlesFromCategory($id){
        $article = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->getArticlesFromCategory($id);

        $category = $this
            ->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);

        return $this->render('blog/ArticleCategory.html.twig', [
            'categories' => $category,
            'articles' =>$article,
        ]);
    }
}