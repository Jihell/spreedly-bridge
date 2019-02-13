<?php
/**
 * @licence Proprietary
 */
namespace Jihel\OmnipaySpreedlyBridgeBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Omnipay\SpreedlyBridge\Model\ReceiverInterface;

/**
 * Class ReceiverRepository
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class ReceiverRepository extends EntityRepository
{
    /**
     * TODO : Add a system to fetch by random or other criteria
     *
     * @return ReceiverInterface
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByDomain()
    {
        return $this->createQueryBuilder('r')
            ->addOrderBy('r.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult()
        ;
    }
}
