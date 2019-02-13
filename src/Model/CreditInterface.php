<?php
/**
 * @licence Proprietary
 */
namespace Jihel\OmnipaySpreedlyBridgeBundle\Model;

/**
 * Interface CreditInterface
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
interface CreditInterface extends AmountInterface
{
    const STATE_NEW = 'new';
    const STATE_PENDING = 'pending';
    const STATE_EXPIRED = 'expired';
    const STATE_CANCELED = 'canceled';
    const STATE_FAILED = 'failed';
    const STATE_CREDITED = 'credited';

    /**
     * @param TransactionInterface $transaction
     * @return $this
     */
    function setTransaction(TransactionInterface $transaction);

    /**
     * @return TransactionInterface
     */
    function getTransaction();

    /**
     * @param PaymentInterface $payment
     * @return $this
     */
    function setPayment(PaymentInterface $payment);

    /**
     * @return PaymentInterface
     */
    function getPayment();

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
     * Usually it's an id, for further use like refund
     *
     * @param string $reference
     * @return $this
     */
    function setReference($reference);

    /**
     * @return string
     */
    function getReference();
}
