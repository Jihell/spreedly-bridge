<?php
/**
 * @licence Proprietary
 */
namespace Jihel\OmnipaySpreedlyBridgeBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
 * @ORM\Table(name="omnipay_spreedly_payment")
 * @ORM\Entity(repositoryClass="Jihel\OmnipaySpreedlyBridgeBundle\Repository\PaymentRepository")
 *
 * @Gedmo\Loggable
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Payment implements Model\PaymentInterface
{
    use Model\AmountTrait;
    use Model\TimestampTrait;

    public function __construct()
    {
        $this
            ->setCredits(new ArrayCollection())
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
     * @ORM\ManyToOne(targetEntity="Jihel\OmnipaySpreedlyBridgeBundle\Entity\Transaction", inversedBy="payments")
     */
    protected $transaction;

    /**
     * @var Model\CreditInterface[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Jihel\OmnipaySpreedlyBridgeBundle\Entity\Credit", mappedBy="payment")
     */
    protected $credits;

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
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $descriptor;

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
     * @return ArrayCollection|Model\CreditInterface[]
     */
    public function getCredits()
    {
        return $this->credits;
    }

    /**
     * @param ArrayCollection|Model\CreditInterface[] $credits
     * @return $this
     */
    public function setCredits($credits)
    {
        $this->credits = $credits;

        return $this;
    }

    /**
     * @param Model\CreditInterface $credit
     * @return $this
     */
    public function addCredit(Model\CreditInterface $credit)
    {
        $this->credits->add($credit);

        return $this;
    }

    /**
     * @param Model\CreditInterface $credit
     * @return $this
     */
    public function removeCredit(Model\CreditInterface $credit)
    {
        $this->credits->removeElement($credit);

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

    /**
     * @return string
     */
    public function getDescriptor()
    {
        return $this->descriptor;
    }

    /**
     * @param string $descriptor
     * @return $this
     */
    public function setDescriptor($descriptor)
    {
        $this->descriptor = $descriptor;

        return $this;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return in_array($this->getState(), [
            Model\PaymentInterface::STATE_DEPOSITED,
            Model\PaymentInterface::STATE_CANCELED,
        ]);
    }
}
