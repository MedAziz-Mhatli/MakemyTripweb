<?php

namespace App\Repository;

use App\Entity\Facture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method Facture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Facture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Facture[]    findAll()
 * @method Facture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */


class FactureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Facture::class);
    }


    public function calculTotalavecremise():float
    {
        $facture = new Facture();
        $res = $facture->getRemiseFacture()/100;
        $y = $facture->getTotalFacture() * $res ;
        return $y;
    }

    /*public function calcultotale()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'select ( reservation_chambre.prix * reservation_chambre.duree) as prix_loc_chambre from reservation_chambre';

        $stmt = $conn->prepare($sql);

        $ResultSet=$stmt->executeQuery([]);

        return $ResultSet->fetchAll();

    }

*/


    // /**
    //  * @return Facture[] Returns an array of Facture objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function findFacture1($id): ?Facture
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.idFacture = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


    /*    public function calcul_facture(){
        return $this->createQueryBuilder('facture')
            ->where()
    }*/

    function tri_asc()
    {
        return $this->createQueryBuilder('facture')
            ->orderBy('facture.total', 'asc')
            ->getQuery()
            ->getResult();
    }

    function tri_desc()
    {
        return $this->createQueryBuilder('facture')
            ->orderBy('facture.total', 'desc')
            ->getQuery()
            ->getResult();
    }

    function recherche($data)
    {
        return $this->createQueryBuilder('facture')
            ->where('facture.total like :total')
            ->setParameter('total', '%.$data.%')
            ->getQuery()
            ->getResult();
    }
    ////////////////////////////////////////////////////////////////////////////////
    public function findFacture($Value, $Value2, $order)
    {
        $em = $this->getEntityManager();
        if ($order == 'DESC') {
            $query = $em->createQuery(
                'SELECT r FROM App\Entity\Facture r   where r.totalFacture like :suj and r.dateFacture like :date order by r.totalFacture DESC '
            );
            $query->setParameter('suj', $Value . '%');
            $query->setParameter('date', $Value2 . '%');

        } else {
            $query = $em->createQuery(
                'SELECT r FROM App\Entity\Facture r   where r.totalFacture like :suj and r.dateFacture like :date order by r.totalFacture ASC '
            );
            $query->setParameter('suj', $Value . '%');
            $query->setParameter('date', $Value2 . '%');

        }
        return $query->getResult();
    }
}
