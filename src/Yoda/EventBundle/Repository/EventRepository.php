<?php

namespace Yoda\EventBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * EventRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EventRepository extends EntityRepository
{
    public function getUpcomingEvents($max = null) {
        $qb = $this->createQueryBuilder('e')
            ->addOrderBy('e.time', 'ASC')
            ->andWhere('e.time > :now')->setParameter(':now', new \DateTime());

        if($max){
            $qb
                ->setMaxResults($max);
        }

        return $qb
            ->getQuery()
            ->execute();
    }
}
