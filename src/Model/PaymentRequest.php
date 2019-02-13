<?php
/**
 * @licence Proprietary
 */
namespace Jihel\OmnipaySpreedlyBridgeBundle\Model;

// Annotations
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class PaymentRequest
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class PaymentRequest
{
    /**
     * @var string
     */
    protected $fullName;

    /**
     * @var string
     */
    protected $month;

    /**
     * @var string
     */
    protected $year;

    /**
     * This is the only data to get, others are presentation
     *
     * @var string
     *
     * @Assert\NotBlank
     */
    protected $token;

    /**
     * @var float
     */
    protected $amount;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     * @return $this
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * @return string
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @param string $month
     * @return $this
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * @return string
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param string $year
     * @return $this
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }
}
