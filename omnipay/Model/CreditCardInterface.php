<?php
/**
 * @licence Proprietary
 */
namespace Omnipay\SpreedlyBridge\Model;

/**
 * Interface CreditCardInterface
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
interface CreditCardInterface
{
    /**
     * @param string $uuid
     * @return $this
     */
    function setUuid($uuid);

    /**
     * @return string
     */
    function getUuid();
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
     * @param string $test
     * @return $this
     */
    function setStorageState($storageState);

    /**
     * @return string
     */
    function getStorageState();
    /**
     * @param bool $test
     * @return $this
     */
    function setTest($test);

    /**
     * @return bool
     */
    function getTest();
    /**
     * @param string $lastFourDigits
     * @return $this
     */
    function setLastFourDigits($lastFourDigits);

    /**
     * @return string
     */
    function getLastFourDigits();
    /**
     * @param string $firstSixDigits
     * @return $this
     */
    function setFirstSixDigits($firstSixDigits);

    /**
     * @return string
     */
    function getFirstSixDigits();
    /**
     * @param string $cardType
     * @return $this
     */
    function setCardType($cardType);

    /**
     * @return string
     */
    function getCardType();
    /**
     * @param string $firstName
     * @return $this
     */
    function setFirstName($firstName);

    /**
     * @return string
     */
    function getFirstName();
    /**
     * @param string $lastName
     * @return $this
     */
    function setLastName($lastName);

    /**
     * @return string
     */
    function getLastName();
    /**
     * @param string $fullName
     * @return $this
     */
    function setFullName($fullName);

    /**
     * @return string
     */
    function getFullName();
    /**
     * @param int $month
     * @return $this
     */
    function setMonth($month);

    /**
     * @return int
     */
    function getMonth();
    /**
     * @param int $uuid
     * @return $this
     */
    function setYear($year);

    /**
     * @return int
     */
    function getYear();
    /**
     * @param string $paymentMethodType
     * @return $this
     */
    function setPaymentMethodType($paymentMethodType);

    /**
     * @return string
     */
    function getPaymentMethodType();
    /**
     * @param string $fingerprint
     * @return $this
     */
    function setFingerprint($fingerprint);

    /**
     * @return string
     */
    function getFingerprint();
    /**
     * @param string $verificationValue
     * @return $this
     */
    function setVerificationValue($verificationValue);

    /**
     * @return string
     */
    function getVerificationValue();
    /**
     * @param string $number
     * @return $this
     */
    function setNumber($number);

    /**
     * @return string
     */
    function getNumber();
}
