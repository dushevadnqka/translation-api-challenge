<?php

namespace AppBundle\Repository;

use AppBundle\Entity\AppEntityInterface;

class BaseAppRepository extends \Doctrine\ORM\EntityRepository
{
    public function saveEntity(AppEntityInterface $entity)
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }
}
