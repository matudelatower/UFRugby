<?php

namespace App\Repository;

use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @method Usuario|null find($id, $lockMode = null, $lockVersion = null)
 * @method Usuario|null findOneBy(array $criteria, array $orderBy = null)
 * @method Usuario[]    findAll()
 * @method Usuario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsuarioRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Usuario::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof Usuario) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    // /**
    //  * @return Usuario[] Returns an array of Usuario objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Usuario
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

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
