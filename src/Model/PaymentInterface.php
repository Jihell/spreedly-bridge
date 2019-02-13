<?php
/**
 * @licence Proprietary
 */
namespace Jihel\OmnipaySpreedlyBridgeBundle\Model;

/**
 * Interface PaymentInterface
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
interface PaymentInterface extends AmountInterface
{
    const STATE_NEW = 'new';
    const STATE_PENDING = 'pending';
    const STATE_EXPIRED = 'expired';
    const STATE_CANCELED = 'canceled';
    const STATE_FAILED = 'failed';
    const STATE_AUTHORIZED = 'authorised';
    const STATE_DEPOSITED = 'deposited';
    const STATE_CREDITED = 'credited';

    /**
     * @return string
     */
    function getId();

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
     * @param CreditInterface[]|array $credits
     * @return $this
     */
    function setCredits($credits);

    /**
     * @return CreditInterface[]|array
     */
    function getCredits();

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

    /**
     * @param string $descriptor
     * @return $this
     */
    function setDescriptor($descriptor);

    /**
     * @return string
     */
    function getDescriptor();

    /**
     * Return true if the payment has been deposited
     *
     * @return bool
     */
    function isValid();
}
