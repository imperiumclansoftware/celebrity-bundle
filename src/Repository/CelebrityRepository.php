<?php

namespace ICS\CelebrityBundle\Repository;

use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use ICS\SearchBundle\Entity\EntitySearchRepositoryInterface;
use ICS\CelebrityBundle\Entity\Celebrity;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use DateTime;
use DateInterval;

class CelebrityRepository extends ServiceEntityRepository implements EntitySearchRepositoryInterface
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

    public function getSlider($limit=10,$offset=0)
    {
        $query = $this->createQueryBuilder('c')
        ->join('c.gallery','g')
        ->orderBy('MAX(g.modificationDate)','DESC')
        ->groupBy('c.id')
        ->setFirstResult($offset)
        ->setMaxResults($limit);

        return $query->getQuery()->getResult();
    }

    public function getNbrByNationality()
    {
        $query = $this->createQueryBuilder('c')
        ->select('count(c.id) as counter,c.nationality')
        ->groupBy('c.nationality')
        ;
     
        return $query->getQuery()->getScalarResult();
    }

    public function getThisWeekAnniversary()
    {
        $now = new DateTime();
        // Get Week start
        $startDay = new DateTime("this week");
        // Get Week End
        $endDay = new DateTime("next week");
        $days = [];
        while($startDay->format('Ymd') != $endDay->format('Ymd'))
        {
            $days[] = $startDay->format('Y-m-d');
            $startDay->add(new DateInterval('P1D'));   
        }
        
        return $this->createQueryBuilder('c')
            ->where("CONCAT('".$startDay->format('Y')."-',substring(CONCAT(c.birthday,''),6,5)) IN (:days)")
            ->setParameter('days',$days)
            ->groupBy('c.birthday, c.id')
            ->getQuery()
            ->getResult();


    }

    public function search(string $search): ?Collection
    {
        $results = $this->createQueryBuilder('c')
            ->where('lower(c.name) LIKE lower(:search)')
            ->setParameter('search', "%".$search."%")
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult();
        return new ArrayCollection($results);
    }
}