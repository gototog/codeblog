<?php

namespace AppBundle\Repository;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends \Doctrine\ORM\EntityRepository
{
    public function getDisplayableCategories() {

        $qb = $this->createQueryBuilder('category');

        return $qb
            ->getQuery()
            ->getResult()
            ;
    }
}
