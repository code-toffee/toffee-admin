<?php

namespace App\Repository;

use App\Dto\Admin\Request\CommonQueryDto;
use App\Entity\AdminLog;
use App\Entity\Cache\AdminUserCache;
use App\Message\AdminLogMessage;
use App\Utils\IpToAddr;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * @method AdminLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdminLog[]    findAll()
 * @method AdminLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminLog::class);
    }

    /**
     * @param AdminLogMessage $message
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function addLogging(AdminLogMessage $message)
    {
        $userAgent = $message->getHeaderBag()->get('User-Agent');
        $controller = $message->getParameterBag()->get('_controller');
        $remoteIp = $message->getServerBag()->get('REMOTE_ADDR');
        $response = $message->getResponse()->getContent() ?: '';
        $request = !empty($message->getContent()) ? $message->getContent() : json_encode($message->getInputBag());

        $log = new AdminLog();
        $log->setUid($message->getUserId());
        $log->setBrower($userAgent);
        $log->setController($controller);
        $log->setDescript($message->getLogName());
        $log->setRequestIp($remoteIp);
        $log->setMethod($message->getMethod());
        $log->setResponse($response);
        $log->setRequest($request);
        $log->setIpAddr(IpToAddr::toAddr($remoteIp));

        $this->_em->persist($log);
        $this->_em->flush();
    }

    public function getLogsList(CommonQueryDto $dto, AdminUserCache $adminUserCache): Paginator
    {
        $offset = ($dto->page - 1) * $dto->pageSize;
        $qb = $this->_em->createQueryBuilder();
        $qb->select('l')
            ->from(AdminLog::class, 'l')
            ->where('l.uid = :uid')
            ->setParameter(':uid', $adminUserCache->id);
        $qb->setMaxResults($dto->pageSize)->setFirstResult($offset);
        return new Paginator($qb, false);
    }
}
