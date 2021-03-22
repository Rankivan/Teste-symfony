<?php

namespace App\Model\Repository;

use App\Model\Entity\Teste;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Teste|null find($id, $lockMode = null, $lockVersion = null)
 * @method Teste|null findOneBy(array $criteria, array $orderBy = null)
 * @method Teste[]    findAll()
 * @method Teste[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TesteRepository extends EntityRepository
{
    /**
     * TesteRepository constructor.
     * @param EntityManagerInterface $registry
     */
    public function __construct(EntityManagerInterface $registry)
    {
        parent::__construct($registry, Teste::class);
    }



}
