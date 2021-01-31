<?php

namespace AppBundle\Repository;

/**
 * AttributeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AttributeRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByIds(array $ids)
    {
        $qb = $this->createQueryBuilder('a');

        return $qb
            ->where($qb->expr()->in('a.id', $ids))
            ->getQuery()
            ->getResult();
    }
}
