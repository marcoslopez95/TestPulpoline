<?php

namespace App\Repository;

use App\Entity\ApiCall;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ApiCall>
 *
 * @method ApiCall|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApiCall|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApiCall[]    findAll()
 * @method ApiCall[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApiCallRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApiCall::class);
    }

//    /**
//     * @return ApiCall[] Returns an array of ApiCall objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ApiCall
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function getApiCallsByIpAndDateRange(string $ip, \DateTimeImmutable $startDate, \DateTimeImmutable $endDate): array
{
    // $entityManager = $this->getDoctrine()->getManager();
    $queryBuilder = $this->getEntityManager()->createQueryBuilder();

    $queryBuilder
        ->select('a')
        ->from(ApiCall::class, 'a')
        ->where('a.ip = :ip')
        ->andWhere('a.created_at BETWEEN :startDate AND :endDate')
        ->setParameter('ip', $ip)
        ->setParameter('startDate', $startDate)
        ->setParameter('endDate', $endDate);

    return $queryBuilder->getQuery()->getResult();
}
}
