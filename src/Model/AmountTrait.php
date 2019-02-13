<?php
/**
 * @licence Proprietary
 */
namespace Jihel\OmnipaySpreedlyBridgeBundle\Model;

// Annotation
use Doctrine\ORM\Mapping as ORM;

/**
 * Trait AmountTrait
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
trait AmountTrait
{
    /**
     * The initial amount requested
     *
     * @var float
     *
     * @ORM\Column(type="decimal", scale=5)
     */
    protected $amount;

    /**
     * Total amount authorized = deposited + credited
     *
     * @var float
     *
     * @ORM\Column(type="decimal", scale=5)
     */
    protected $amountAuthorized;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", scale=5)
     */
    protected $amountDeposited;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", scale=5)
     */
    protected $amountCredited;

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
     * @return float
     */
    public function getAmountAuthorized()
    {
        return $this->amountAuthorized;
    }

    /**
     * @param float $amountAuthorized
     * @return $this
     */
    public function setAmountAuthorized($amountAuthorized)
    {
        $this->amountAuthorized = $amountAuthorized;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmountDeposited()
    {
        return $this->amountDeposited;
    }

    /**
     * @param float $amountDeposited
     * @return $this
     */
    public function setAmountDeposited($amountDeposited)
    {
        $this->amountDeposited = $amountDeposited;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmountCredited()
    {
        return $this->amountCredited;
    }

    /**
     * @param float $amountCredited
     * @return $this
     */
    public function setAmountCredited($amountCredited)
    {
        $this->amountCredited = $amountCredited;

        return $this;
    }
}
