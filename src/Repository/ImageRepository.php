<?php

namespace App\Repository;

use App\Entity\Image;
use App\Entity\SearchImages;
use Doctrine\ORM\Query;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Image|null find($id, $lockMode = null, $lockVersion = null)
 * @method Image|null findOneBy(array $criteria, array $orderBy = null)
 * @method Image[]    findAll()
 * @method Image[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Image::class);
    }

    public function findAllWithPagination(SearchImages $searchImages) : Query
    {
        $req = $this->createQueryBuilder("i");
        if ($searchImages->getTitle()){
            $req = $req->andWhere('i.title = :title')
            ->setParameter(':title', $searchImages->getTitle());
        }
        return $req->getQuery();
    }

    // /**
    //  * @return Image[] Returns an array of Image objects
    //  */
    
    public function findImagesByTag($value)
    {
        return $this->createQueryBuilder('i')
            ->leftJoin('i.tags', 'tag')
            ->andWhere('i.tags.["name"] = :val')
            ->setParameter('val', $value->getName())
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Image
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
