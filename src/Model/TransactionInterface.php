<?php
/**
 * @licence Proprietary
 */
namespace Jihel\OmnipaySpreedlyBridgeBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Omnipay\SpreedlyBridge\Model\CreditCardInterface;
use Omnipay\SpreedlyBridge\Model\ReceiverInterface;

/**
 * Interface TransactionInterface
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
interface TransactionInterface extends AmountInterface
{
    const STATE_NEW = 'new'; // Waiting for credit card
    const STATE_PROCESSING = 'processing'; // Have credit card, pending for payment creation
    const STATE_DECLINED = 'declined';
    const STATE_CANCELED = 'canceled';
    const STATE_AUTHORIZED = 'authorized'; // Ok payment is valid
    const STATE_EXPIRED = 'expired';

    /**
     * @return bool
     */
    function haveToPay();

    /**
     * @return integer
     */
    function getId();

    /**
     * @param string $state
     * @return $this
     */
    function setState($state);

    /**
     * @return string
     */
    function getState();

    /**
     * Some gateway use a token for registered credit card, put it here
     *
     * @param string $token
     * @return $this
     */
    function setToken($token);

    /**
     * @return string
     */
    function getToken();

    /**
     * @param string $currency
     * @return $this
     */
    function setCurrency($currency);

    /**
     * @return string
     */
    function getCurrency();

    /**
     * @param CreditCardInterface $creditCard
     * @return $this
     */
    function setCreditCard(CreditCardInterface $creditCard);

    /**
     * @return CreditCardInterface
     */
    function getCreditCard();

    /**
     * @param ReceiverInterface $receiver
     * @return $this
     */
    function setReceiver(ReceiverInterface $receiver);

    /**
     * @return ReceiverInterface
     */
    function getReceiver();

    /**
     * @param ArrayCollection|PaymentInterface[] $payments
     * @return array
     */
    function setPayments($payments);

    /**
     * @return ArrayCollection|PaymentInterface[]
     */
    function getPayments();

    /**
     * @param PaymentInterface $payment
     * @return $this
     */
    function addPayment(PaymentInterface $payment);

    /**
     * @param PaymentInterface $payment
     * @return $this
     */
    function removePayment(PaymentInterface $payment);
}
