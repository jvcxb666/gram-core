<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Session>
 *
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    public function removeSession(int $id): void 
    {
        $this->getEntityManager()
            ->createQueryBuilder()
                ->delete("App\Entity\Session",'us')
                    ->andWhere("us.id = :id")
                        ->setParameter("id",$id)
                            ->getQuery()
                                ->execute();
    }

    public function clearSessionsForUser(int $user_id): void
    {
        $this->getEntityManager()
            ->createQueryBuilder()
                ->delete("App\Entity\Session",'us')
                    ->andWhere("us.user_id = :id")
                        ->setParameter("id",$user_id)
                            ->getQuery()
                                ->execute();
    }
}
