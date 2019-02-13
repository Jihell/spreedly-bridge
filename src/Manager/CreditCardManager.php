<?php
/**
 * @licence Proprietary
 */
namespace Jihel\OmnipaySpreedlyBridgeBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Jihel\OmnipaySpreedlyBridgeBundle\Bridge\CreditCardBridge;
use Jihel\OmnipaySpreedlyBridgeBundle\Entity\CreditCard;
use Omnipay\SpreedlyBridge\Model\CreditCardInterface;

/**
 * Class ReceiverManager
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class CreditCardManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $manager;

    /**
     * @var CreditCardBridge
     */
    protected $bridge;

    /**
     * CreditCardManager constructor.
     *
     * @param EntityManagerInterface $manager
     * @param CreditCardBridge       $bridge
     */
    public function __construct(
        EntityManagerInterface $manager,
        CreditCardBridge $bridge
    ) {
        $this->manager = $manager;
        $this->bridge = $bridge;
    }

    /**
     * @param string $token
     * @param bool   $persist
     * @return CreditCard
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jihel\OmnipaySpreedlyBridgeBundle\Bridge\Exception\CreateReceiverException
     */
    public function create(string $token, $persist = true)
    {
        $creditCard = new CreditCard();
        $creditCard->setToken($token);
        $response = $this->bridge->showCreditCard($creditCard);

        $this->assignFromResponse($creditCard, $response);

        if ($persist) {
            $this->manager->persist($creditCard);
            $this->manager->flush();
        }

        return $creditCard;
    }

    /**
     * @param CreditCardInterface $creditCard
     * @param bool                $persist
     * @return CreditCardInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jihel\OmnipaySpreedlyBridgeBundle\Bridge\Exception\CreateReceiverException
     */
    public function synchronise(CreditCardInterface $creditCard, $persist = true)
    {
        $response = $this->bridge->showCreditCard($creditCard);

        $this->assignFromResponse($creditCard, $response);

        if ($persist) {
            $this->manager->persist($creditCard);
            $this->manager->flush();
        }

        return $creditCard;
    }

    /**
     * @param CreditCardInterface $creditCard
     * @param array               $response
     * @return CreditCardInterface
     */
    protected function assignFromResponse(CreditCardInterface $creditCard, array $response)
    {
        $creditCard
            ->setToken($response['token'])
            ->setStorageState($response['storage_state'])
            ->setTest($response['test'])
            ->setLastFourDigits($response['last_four_digits'])
            ->setFirstSixDigits($response['first_six_digits'])
            ->setCardType($response['card_type'])
            ->setFirstName($response['first_name'])
            ->setLastName($response['last_name'])
            ->setFullName($response['full_name'])
            ->setMonth($response['month'])
            ->setYear($response['year'])
            ->setPaymentMethodType($response['payment_method_type'])
            ->setFingerprint($response['fingerprint'])
            ->setVerificationValue($response['verification_value'])
            ->setNumber($response['number'])
        ;

        return $creditCard;
    }
}
