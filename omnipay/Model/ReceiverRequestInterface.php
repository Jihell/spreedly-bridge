<?php
/**
 * @licence Proprietary
 */
namespace Omnipay\SpreedlyBridge\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface ReceiverInterface
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
interface ReceiverRequestInterface
{
    /**
     * @return string
     */
    function getType();

    /**
     * @return string
     */
    function getHostnames();

    /**
     * @return ArrayCollection|CredentialInterface[]
     */
    function getCredentials();

    /**
     * @return mixed
     */
    function getBridgeClass();

    /**
     * @return mixed
     */
    function getReceiverUser();

    /**
     * @return mixed
     */
    function getReceiverPass();

    /**
     * @return mixed
     */
    function getReceiverMid();
}
