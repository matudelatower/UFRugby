<?php


namespace App\Repository;

use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UsuarioRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Usuario::class);
    }


    public function findQbAll()
    {
        $qb = $this->createQueryBuilder('u');
        $qb->where('upper(u.username) <> upper(:user)');
        $qb->setParameter('user', 'admin');
        return $qb;
    }

    public function findQbBuscar($data)
    {
        $qb = $this->findQbAll();

        if ($data) {
            if ($data['username']) {
                $username = $data['username'];
                $qb
                    ->andWhere("upper(u.username) like upper(:username)");
                $qb->setParameter('username', '%' . $username . '%');
            }
            if ($data['email']) {
                $email = $data['email'];
                $qb
                    ->andWhere("upper(u.email) like upper(:email)");
                $qb->setParameter('email', '%' . $email . '%');
            }
            if (isset($data['enabled'])) {
                $enabled = $data['enabled'];
                $qb
                    ->andWhere("u.enabled = :enabled");
                $qb->setParameter('enabled', $enabled);
            }
            if ($data['club']) {
                $club = $data['club'];
                $qb
                    ->andWhere("u.club = :club");
                $qb->setParameter('club', $club);
            }

        }

        return $qb;
    }

}