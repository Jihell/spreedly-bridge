<?php
/**
 * @licence Proprietary
 */
namespace Jihel\OmnipaySpreedlyBridgeBundle\Model;

/**
 * Interface AmountInterface
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
interface AmountInterface
{
    /**
     * @param float $amount
     * @return $this
     */
    function setAmount($amount);

    /**
     * @return float
     */
    function getAmount();

    /**
     * @param float $amountAuthorized
     * @return $this
     */
    function setAmountAuthorized($amountAuthorized);

    /**
     * @return float
     */
    function getAmountAuthorized();

    /**
     * @param float $amountDeposited
     * @return $this
     */
    function setAmountDeposited($amountDeposited);

    /**
     * @return float
     */
    function getAmountDeposited();

    /**
     * @param float $amountCredited
     * @return $this
     */
    function setAmountCredited($amountCredited);

    /**
     * @return float
     */
    function getAmountCredited();
}
