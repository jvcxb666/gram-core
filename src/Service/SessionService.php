<?php

namespace App\Service;

use App\Entity\Session;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;

class SessionService implements ServiceInterface
{
    private EntityManagerInterface $em;
    private ServiceEntityRepository $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repo = $this->em->getRepository(Session::class);
    }

    public function get(array $params): ?array
    {
        return $this->repo->findBy($params);
    }

    public function save(array $data): ?array
    {
        if(empty($data['user_id'])) return null;

        $this->repo->clearSessionsForUser($data['user_id']);

        $session = new Session($data['login'] ?? null,$data['user_id']);
        $session->setDateEntered(new DateTime());
        $session->setDateExpired($this->getDateExpired($session->getDateEntered()));
        $session->setSessid(uniqid().uniqid());

        $this->em->persist($session);
        $this->em->flush();

        return ["object"=>$session];
    }

    public function remove(int $id): ?array
    {
        $this->repo->removeSession($id);
        return [];
    }

    public function checkSession(?string $sessId = null): bool
    {
        if(empty($sessId)) return false;
        $session = $this->repo->findOneBy(['sessid'=>$sessId]);
        if(empty($session)) return false;
        if(date('Y-m-d H:i:s') > $session->getDateExpired()->format('Y-m-d H:i:s')){
            $this->remove($session->getId());
            return false;
        }
 
        return true;
    }

    private function getDateExpired(DateTime $date_entered): DateTime
    {
        return $date_entered->modify('+1 day');
    }


}