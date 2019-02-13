<?php
/**
 * @licence Proprietary
 */
namespace Jihel\OmnipaySpreedlyBridgeBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Jihel\OmnipaySpreedlyBridgeBundle\Model;
use Omnipay\SpreedlyBridge\Model\CreditCardInterface;
use Omnipay\SpreedlyBridge\Model\ReceiverInterface;
// Annotation
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Transaction
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 *
 * @ORM\Table(name="omnipay_spreedly_transaction")
 * @ORM\Entity(repositoryClass="Jihel\OmnipaySpreedlyBridgeBundle\Repository\TransactionRepository")
 *
 * @Gedmo\Loggable
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Transaction implements Model\TransactionInterface
{
    public function __construct()
    {
        $this
            ->setPayments(new ArrayCollection())
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
     * @var CreditCardInterface
     *
     * @ORM\ManyToOne(targetEntity="Jihel\OmnipaySpreedlyBridgeBundle\Entity\CreditCard", inversedBy="transactions")
     */
    protected $creditCard;

    /**
     * @var ReceiverInterface
     *
     * @ORM\ManyToOne(targetEntity="Jihel\OmnipaySpreedlyBridgeBundle\Entity\Receiver", inversedBy="transactions")
     */
    protected $receiver;

    /**
     * @var Model\PaymentInterface[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Jihel\OmnipaySpreedlyBridgeBundle\Entity\Payment", mappedBy="transaction", cascade={"PERSIST"})
     */
    protected $payments;

    /**
     * @var Model\CreditInterface[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Jihel\OmnipaySpreedlyBridgeBundle\Entity\Credit", mappedBy="transaction", cascade={"PERSIST"})
     */
    protected $credits;

    /**
     * The initial amount requested
     *
     * @var string
     *
     * @ORM\Column(type="string", length=15)
     */
    protected $state;

    /**
     * ISO 3
     *
     * @var string
     *
     * @ORM\Column(type="string", nullable=true, length=3)
     */
    protected $currency;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $token;

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
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $email;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $deletedAt;

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
     * @return CreditCardInterface
     */
    public function getCreditCard()
    {
        return $this->creditCard;
    }

    /**
     * @param CreditCardInterface $creditCard
     * @return $this
     */
    public function setCreditCard(CreditCardInterface $creditCard)
    {
        $this->creditCard = $creditCard;

        return $this;
    }

    /**
     * @return ReceiverInterface
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @param ReceiverInterface $receiver
     * @return $this
     */
    public function setReceiver(ReceiverInterface $receiver)
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * @return Model\PaymentInterface[]|ArrayCollection
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
     * @param Model\PaymentInterface[]|ArrayCollection $payments
     * @return $this
     */
    public function setPayments($payments)
    {
        $this->payments = $payments;

        return $this;
    }

    /**
     * @param Model\PaymentInterface $payment
     * @return $this|Model\TransactionInterface
     */
    public function addPayment(Model\PaymentInterface $payment)
    {
        $this->payments->add($payment);
        $payment->setTransaction($this);

        return $this;
    }

    /**
     * @param Model\PaymentInterface $payment
     * @return $this|Model\TransactionInterface
     */
    public function removePayment(Model\PaymentInterface $payment)
    {
        $this->payments->removeElement($payment);

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

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @param \DateTime|null $deletedAt
     * @return $this
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }

    /**
     * @return bool
     */
    function haveToPay()
    {
        return in_array($this->getState(), [
            Model\TransactionInterface::STATE_NEW,
            Model\TransactionInterface::STATE_CANCELED,
            Model\TransactionInterface::STATE_DECLINED,
            Model\TransactionInterface::STATE_EXPIRED,
        ]) || null === $this->getCreditCard();
    }
}
