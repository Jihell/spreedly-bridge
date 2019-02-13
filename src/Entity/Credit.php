<?php
/**
 * @licence Proprietary
 */
namespace Jihel\OmnipaySpreedlyBridgeBundle\Entity;

use Jihel\OmnipaySpreedlyBridgeBundle\Model;
// Annotation
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Payment
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 *
 * @ORM\Table(name="omnipay_spreedly_credit")
 * @ORM\Entity(repositoryClass="Jihel\OmnipaySpreedlyBridgeBundle\Repository\CreditRepository")
 *
 * @Gedmo\Loggable
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Credit implements Model\CreditInterface
{
    use Model\AmountTrait;
    use Model\TimestampTrait;

    public function __construct()
    {
        $this
            ->setState(static::STATE_NEW)
            ->setAmount(0)
            ->setAmountAuthorized(0)
            ->setAmountDeposited(0)
            ->setAmountCredited(0)
        ;
    }

    /**
     * =========================================================================
     *                              PROPERTIES
     * =========================================================================
     */

    /**
     * @var integer
     *
     * ID is a unique string name
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Model\TransactionInterface
     *
     * @ORM\ManyToOne(targetEntity="Jihel\OmnipaySpreedlyBridgeBundle\Entity\Transaction", inversedBy="credits")
     */
    protected $transaction;

    /**
     * @var Model\PaymentInterface
     *
     * @ORM\ManyToOne(targetEntity="Jihel\OmnipaySpreedlyBridgeBundle\Entity\Payment", inversedBy="credits")
     */
    protected $payment;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=15)
     */
    protected $state;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $reference;

    /**
     * =========================================================================
     *                              ACCESSORS
     * =========================================================================
     */

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Model\TransactionInterface
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @param Model\TransactionInterface $transaction
     * @return $this
     */
    public function setTransaction(Model\TransactionInterface $transaction)
    {
        $this->transaction = $transaction;

        return $this;
    }

    /**
     * @return Model\PaymentInterface
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * @param Model\PaymentInterface $payment
     * @return $this
     */
    public function setPayment(Model\PaymentInterface $payment)
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     * @return $this
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }
}
