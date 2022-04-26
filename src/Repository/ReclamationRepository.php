<?php

namespace App\Repository;


use App\Entity\Reclamation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reclamation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reclamation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reclamation[]    findAll()
 * @method Reclamation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReclamationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reclamation::class);
    }

    function tri_asc()
    {
        return $this->createQueryBuilder('reclamation')
            ->orderBy('reclamation.dateReclamation', 'asc')
            ->getQuery()
            ->getResult();
    }

    function tri_desc()
    {
        return $this->createQueryBuilder('reclamation')
            ->orderBy('reclamation.dateReclamation', 'desc')
            ->getQuery()
            ->getResult();
    }

    function recherche($data)
    {
        return $this->createQueryBuilder('reclamation')
            ->where('reclamation.dateReclamation like :dateReclamation')
            ->setParameter('dateReclamation', '%.$data.%')
            ->getQuery()
            ->getResult();
    }

    /////////////////////////////////:

    public function findReclamations($Value,$Value2,$order)
    {
        $em = $this->getEntityManager();
        if ($order == 'DESC') {
            $query = $em->createQuery(
                'SELECT r FROM App\Entity\Reclamation r   where r.etatReclamation like :suj and r.nomuser like :nomuser order by r.idReclamation DESC '
            );
            $query->setParameter('suj', $Value . '%');
            $query->setParameter('nomuser',$Value2 . '%');
        } else {
            $query = $em->createQuery(
                'SELECT r FROM App\Entity\Reclamation r   where r.etatReclamation like :suj and r.nomuser like :nomuser order by r.idReclamation ASC '
            );
            $query->setParameter('suj', $Value . '%');
            $query->setParameter('nomuser',$Value2 . '%');

        }
        return $query->getResult();
    }
    public function find_Nb_Rec_Par_Status($status)
    {

        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT DISTINCT  count(r.idReclamation) FROM   App\Entity\Reclamation r  where r.etatReclamation = :status   '
        );
        $query->setParameter('status', $status);
        return $query->getResult();
    }
}
