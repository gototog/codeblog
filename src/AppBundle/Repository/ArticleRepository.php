<?php

namespace AppBundle\Repository;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends \Doctrine\ORM\EntityRepository
{
    public function getLastArticle()
    {
        $qb = $this->createQueryBuilder('article');

        $qb
            ->orderBy('article.createdAt', 'DESC')
            ->setMaxResults(1)
        ;

        return $qb
            ->getQuery()
            ->getSingleResult()
            ;
    }
}