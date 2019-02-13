<?php
/**
 * @licence Proprietary
 */
namespace Omnipay\SpreedlyBridge\Model;

/**
 * Interface CredentialInterface
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
interface CredentialInterface
{
    /**
     * @return string
     */
    function getName();

    /**
     * @return string
     */
    function getValue();

    /**
     * @return bool
     */
    function getSafe();
}
