<?php

namespace App\Repository;

use App\Entity\Menu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Menu>
 *
 * @method Menu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Menu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Menu[]    findAll()
 * @method Menu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Menu::class);
    }

    public function findMenu($id_cms): ?Menu
    {
        return $this->createQueryBuilder('row')
            ->andWhere('row.id_cms = :id_cms')
            ->setParameter('id_cms', $id_cms)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getMenu(): ?array
    {
        $allMenu = $this->createQueryBuilder('row')
            ->where('row.id > 0')
            ->getQuery()
            ->getArrayResult()
        ;

        if ($allMenu) {
            $menuUrlAndName = [];
            foreach ($allMenu as $i => $menuItem) {
                foreach ($menuItem as $key => $value) {
                    if ($key==='url') {
                        $menuUrlAndName[$i]['url'] = $value;
                    } else if ($key==='name') {
                        $menuUrlAndName[$i]['name'] = $value;
                    } else if ($key==='type') {
                        $menuUrlAndName[$i]['type'] = $value;
                    }
                }
            }
            return $menuUrlAndName;
        } else {
            return null;
        }
    }

    //    /**
    //     * @return Menu[] Returns an array of Menu objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Menu
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
