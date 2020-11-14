<?php

namespace AppBundle\Repository;

/**
 * TranslationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TranslationRepository extends BaseAppRepository
{
    public function findAllAsArray()
    {
        $qb = $this->createQueryBuilder('tr')
            ->select('tr, k')
            ->leftJoin('tr.translationKey', 'k');
        return $qb->getQuery()->getArrayResult();
    }
}