<?php

namespace ICS\CelebrityBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\Persistence\ManagerRegistry;
use ICS\CelebrityBundle\Entity\Celebrity;

class CelebrityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Celebrity::class);
    }

    public function getWithNoImage()
    {
        $q1 = $this->createQueryBuilder('a')
        ->join('a.gallery','g');
        

        return $q1->getQuery()->getResult();
    }
}