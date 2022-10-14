<?php

namespace App\Repository;

use App\Entity\Catalogue;
use App\Entity\Menu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\Mapping as ORM;

/**
 * @extends ServiceEntityRepository<Catalogue>
 *
 * @method Catalogue|null find($id, $lockMode = null, $lockVersion = null)
 * @method Catalogue|null findOneBy(array $criteria, array $orderBy = null)
 * @method Catalogue[]    findAll()
 * @method Catalogue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CatalogueRepository extends ServiceEntityRepository
{

    public const PAGINATOR_PER_PAGE = 3;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Catalogue::class);
    }

    public function add(Catalogue $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Catalogue $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getCataloguePaginator(Menu $menu, int $offset): Paginator   // ser à la pagination
    {
        $query = $this->createQueryBuilder('c')
            ->andWhere('c.menu = :menu')  // Condition : le menu du catalogue dois être le même que celuis du menu choisi
            ->setParameter('menu', $menu) // initialise une variable
            ->orderBy('c.id', 'ASC')  // trier par ordre croissans
            ->setMaxResults(self::PAGINATOR_PER_PAGE) // nombre de résultat afficher sur la page
            ->setFirstResult($offset)
            ->getQuery()
        ;

        return new Paginator($query);
    }

//    /**
//     * @return Catalogue[] Returns an array of Catalogue objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Catalogue
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
