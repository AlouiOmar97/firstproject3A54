<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    //    /**
    //     * @return Book[] Returns an array of Book objects
    //     */
        public function findBookAuthor()
        {
            return $this->createQueryBuilder('b')
                ->join('b.author', 'a')
                ->addSelect('a')
                ->where('a.username = ?1')
                ->setParameter('1', 'William Shakespeare DB')
                ->getQuery()
                ->getDQL()
            ;
        }

        public function findBookAuthorDQL()
        {
            return $this->getEntityManager()
            ->createQuery("SELECT count(b) FROM App\Entity\Book b INNER JOIN b.author a WHERE a.username = :username")
            ->setParameter('username', 'William Shakespeare DB')
            ->getResult()
            ;
        }

    //    public function findOneBySomeField($value): ?Book
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
