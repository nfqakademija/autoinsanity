<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use AppBundle\Entity\VehicleSearch;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * VehicleSearchRepository
 */
class VehicleSearchRepository extends EntityRepository
{
    // maximum number of recent searches stored for one user
    const MAX_SEARCHES_PER_USER = 10;

    public function getOutdatedSearches(User $user)
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('s')
            ->from('AppBundle:VehicleSearch', 's')
            ->where('s.user = :user')
            ->setParameter('user', $user)
            ->orderBy('s.id', 'DESC')
            ->setFirstResult(self::MAX_SEARCHES_PER_USER - 2) // +1 for new, +1 because it's an offset
            ->getQuery()
            ->getResult();
    }
}
