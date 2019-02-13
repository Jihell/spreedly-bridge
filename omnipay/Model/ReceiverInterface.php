<?php
/**
 * @licence Proprietary
 */
namespace Omnipay\SpreedlyBridge\Model;

/**
 * Interface ReceiverInterface
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
interface ReceiverInterface
{
    const STATE_RETAINED = 'retained';
    const STATE_REDACTED = 'redacted';

    /**
     * @param string $companyName
     * @return $this
     */
    function setCompanyName($companyName);

    /**
     * @return string
     */
    function getCompanyName();

    /**
     * @param string $receiverType
     * @return $this
     */
    function setReceiverType($receiverType);

    /**
     * @return string
     */
    function getReceiverType();

    /**
     * @param string $token
     * @return $this
     */
    function setToken($token);

    /**
     * @return string
     */
    function getToken();

    /**
     * @param string $hostnames
     * @return $this
     */
    function setHostnames($hostnames);

    /**
     * @return string
     */
    function getHostnames();

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
     * @param array $credentials
     * @return $this
     */
    function setCredentials(array $credentials);

    /**
     * @return string
     */
    function getCredentials();

    /**
     * @param string $bridgeClass
     * @return mixed
     */
    function setBridgeClass($bridgeClass);

    /**
     * @return mixed
     */
    function getBridgeClass();

    /**
     * @param string $receiverUser
     * @return mixed
     */
    function setReceiverUser($receiverUser);

    /**
     * @return mixed
     */
    function getReceiverUser();

    /**
     * @param string $receiverPass
     * @return mixed
     */
    function setReceiverPass($receiverPass);

    /**
     * @return mixed
     */
    function getReceiverPass();

    /**
     * @param string $receiverMid
     * @return mixed
     */
    function setReceiverMid($receiverMid);

    /**
     * @return mixed
     */
    function getReceiverMid();
}
