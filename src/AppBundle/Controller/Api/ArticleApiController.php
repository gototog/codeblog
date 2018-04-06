<?php

namespace AppBundle\Controller\Api;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ArticleApiController extends FOSRestController
{
    /**
     * @Route("/api/articles", name="api_article_index", methods={"GET"})
     * @ApiDoc(
     *  section="Articles",
     *  resource=true,
     *  description="Get all the articles",
     *  output={
     *      "class"="AppBundle\Entity\Article",
     *       "parsers" = {
     *          "Nelmio\ApiDocBundle\Parser\JmsMetadataParser"
     *      }
     *  },
     *  statusCodes={
     *      200="Returned when successful",
     *      403= "Returned when user does not have necessary permissions",
     *  }
     * )
     */
    public function getArticlesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('AppBundle:Article')->findAll();
        $view = $this->view($articles, 200);
        dump($this->get('serializer')->serialize(new \DateTimeImmutable('now',null), 'json'));
        return $this->handleView($view);
    }
}