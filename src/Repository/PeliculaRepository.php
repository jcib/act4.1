<?php

namespace App\Repository;

use App\Entity\Pelicula;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Pelicula|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pelicula|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pelicula[]    findAll()
 * @method Pelicula[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PeliculaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,EntityManagerInterface $manager)
    {
        parent::__construct($registry, Pelicula::class);
        $this->manager = $manager;
    }

    public function savePeli($nombre, $genero, $descripcion)
    {
        $newPeli = new Pelicula();

        $newPeli
            ->setNombre($nombre)
            ->setGenero($genero)
            ->setDescripcion($descripcion);

        $this->manager->persist($newPeli);
        $this->manager->flush();
    }

    public function updatePeli(Pelicula $peli): Pelicula
    {
        $this->manager->persist($peli);
        $this->manager->flush();

        return $peli;
    }


    public function removePeli(Pelicula $peli)
    {
        $this->manager->remove($peli);
        $this->manager->flush();
    }

    // /**
    //  * @return Pet[] Returns an array of Pet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pet
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}