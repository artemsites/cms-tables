<?php

namespace App\Repository;

use App\Entity\Page;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Page>
 *
 * @method Page|null find($id, $lockMode = null, $lockVersion = null)
 * @method Page|null findOneBy(array $criteria, array $orderBy = null)
 * @method Page[]    findAll()
 * @method Page[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Page::class);
    }

    public function findPage($id_cms): ?Page
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id_cms = :id_cms')
            ->setParameter('id_cms', $id_cms)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getPageByUrl($url): ?array
    {
        $res = $this->createQueryBuilder('row')
            ->where('row.url = :url')
            ->setParameter('url', $url)
            ->getQuery()
            ->getArrayResult()
        ;

        if ($res) {
            return $res[0];
        } else {
            return null;
        }
    }

    public function getLinksWithNamesOfParentUrl($url): ?array
    {
        $qb = $this->createQueryBuilder("row");

        $url = $url . '/';

        $qb->select('row.url', 'row.title')
        ->where("row.off != :off")
        ->setParameter("off", '1')
        ->andWhere("row.url LIKE :url")
        ->setParameter("url", "%{$url}%")
        ;

        $res = $qb->getQuery()->getArrayResult();

        if ($res) {
            return $res;
        } else {
            return null;
        }
    }

    public function getLinksWithNamesByTextInContent($strSearch): ?array
    {
        $qb = $this->createQueryBuilder("row");

        $qb->select('row.url', 'row.title')
        ->where("row.off != :off")
        ->setParameter("off", '1')
        ->andWhere("row.content LIKE :content")
        ->setParameter("content", "%{$strSearch}%")
        ;

        $res = $qb->getQuery()->getArrayResult();

        if ($res) {
            return $res;
        } else {
            return null;
        }
    }

    //    /**
    //     * @return Page[] Returns an array of Page objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Page
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
