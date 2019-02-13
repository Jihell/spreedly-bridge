<?php
/**
 * @licence Proprietary
 */
namespace Jihel\OmnipaySpreedlyBridgeBundle\Manager;

use ColinODell\OmnipayBundle\Service\Omnipay;
use Doctrine\ORM\EntityManagerInterface;
use Jihel\OmnipaySpreedlyBridgeBundle\Bridge\ReceiverBridge;
use Jihel\OmnipaySpreedlyBridgeBundle\Entity\Receiver;
use Jihel\OmnipaySpreedlyBridgeBundle\Repository\ReceiverRepository;
use Omnipay\SpreedlyBridge\Model\ReceiverInterface;
use Omnipay\SpreedlyBridge\Model\ReceiverRequestInterface;

/**
 * Class ReceiverManager
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class ReceiverManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $manager;

    /**
     * @var ReceiverBridge
     */
    protected $bridge;

    /**
     * ReceiverManager constructor.
     *
     * @param EntityManagerInterface $manager
     * @param ReceiverBridge         $bridge
     * @param Omnipay                $omnipay
     */
    public function __construct(
        EntityManagerInterface $manager,
        ReceiverBridge $bridge
    ) {
        $this->manager = $manager;
        $this->bridge = $bridge;
    }

    /**
     * @param string $domain
     * @return ReceiverInterface
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByDomain(string $domain)
    {
        /** @var ReceiverRepository $receiverRepository */
        $receiverRepository = $this->manager->getRepository(Receiver::class);

        return $receiverRepository->findByDomain($domain);
    }

    /**
     * @param ReceiverRequestInterface $receiverRequest
     * @param bool                     $persist
     * @return ReceiverInterface
     * @throws \Omnipay\SpreedlyBridge\Exception\CreateReceiverException
     */
    public function create(ReceiverRequestInterface $receiverRequest, $persist = true)
    {
        $response = $this->bridge->createReceiver($receiverRequest);
        $receiver = new Receiver();
        $receiver
            ->setBridgeClass($receiverRequest->getBridgeClass())
            ->setReceiverUser($receiverRequest->getReceiverUser())
            ->setReceiverPass($receiverRequest->getReceiverPass())
            ->setReceiverMid($receiverRequest->getReceiverMid())
        ;

        $this->assignFromResponse($receiver, $response);

        if ($persist) {
            $this->manager->persist($receiver);
            $this->manager->flush();
        }

        return $receiver;
    }

    /**
     * @param ReceiverInterface $receiver
     * @return ReceiverInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Omnipay\SpreedlyBridge\Exception\CreateReceiverException
     */
    public function synchronise(ReceiverInterface $receiver, $persist = true)
    {
        $response = $this->bridge->showReceiver($receiver->getToken());

        $this->assignFromResponse($receiver, $response);

        if ($persist) {
            $this->manager->persist($receiver);
            $this->manager->flush();
        }

        return $receiver;
    }

    /**
     * @param ReceiverInterface $receiver
     * @param array             $response
     * @return ReceiverInterface
     */
    protected function assignFromResponse(ReceiverInterface $receiver, array $response)
    {
        $receiver
            ->setCompanyName($response['company_name'])
            ->setReceiverType($response['receiver_type'])
            ->setToken($response['token'])
            ->setHostnames($response['hostnames'])
            ->setState($response['state'])
            ->setCredentials($response['credentials'])
        ;

        return $receiver;
    }
}
