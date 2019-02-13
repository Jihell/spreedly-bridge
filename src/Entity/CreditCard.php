<?php
/**
 * @licence Proprietary
 */
namespace Jihel\OmnipaySpreedlyBridgeBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Jihel\OmnipaySpreedlyBridgeBundle\Model;
use Omnipay\SpreedlyBridge\Model\CreditCardInterface;
// Annotation
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CreditCard
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 *
 * @ORM\Table(name="omnipay_spreedly_credit_card")
 * @ORM\Entity(repositoryClass="Jihel\OmnipaySpreedlyBridgeBundle\Repository\CreditCardRepository")
 *
 * @Gedmo\Loggable
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class CreditCard implements CreditCardInterface
{
    use Model\TimestampTrait;

    const STORAGE_STATE_CACHED = 'cached';
    const STORAGE_STATE_RETAINED = 'retained';
    const STORAGE_STATE_REDACTED = 'redacted';

    /**
     * CreditCard constructor.
     */
    public function __construct()
    {
        $this
            ->setTransaction(new ArrayCollection())
            ->setUuid(preg_replace_callback('/[xy]/', function($matches) {
                return dechex('x' == $matches[0] ? mt_rand(0, 15) : (mt_rand(0, 15) & 0x3 | 0x8));
            }, 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'))
        ;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getUuid();
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
     * @var Model\TransactionInterface[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Jihel\OmnipaySpreedlyBridgeBundle\Entity\Transaction", mappedBy="creditCard")
     */
    protected $transaction;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=36)
     * @Serializer\Expose
     */
    protected $uuid;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Serializer\Expose
     */
    protected $token;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Serializer\Expose
     */
    protected $storageState;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     * @Serializer\Expose
     */
    protected $test;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=4)
     * @Serializer\Expose
     */
    protected $lastFourDigits;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=6)
     * @Serializer\Expose
     */
    protected $firstSixDigits;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Serializer\Expose
     */
    protected $cardType;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @Serializer\Expose
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @Serializer\Expose
     */
    protected $lastName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @Serializer\Expose
     */
    protected $fullName;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Serializer\Expose
     */
    protected $month;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Serializer\Expose
     */
    protected $year;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Serializer\Expose
     */
    protected $paymentMethodType;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Serializer\Expose
     */
    protected $fingerprint;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=15, nullable=true)
     * @Serializer\Expose
     */
    protected $verificationValue;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=63, nullable=true)
     * @Serializer\Expose
     */
    protected $number;


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
     * @return Model\TransactionInterface[]|ArrayCollection
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @param Model\TransactionInterface[]|ArrayCollection $transaction
     * @return $this
     */
    public function setTransaction($transaction)
    {
        $this->transaction = $transaction;

        return $this;
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     * @return $this
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;

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
     * @return string
     */
    public function getStorageState()
    {
        return $this->storageState;
    }

    /**
     * @param string $storageState
     * @return $this
     */
    public function setStorageState($storageState)
    {
        $this->storageState = $storageState;

        return $this;
    }

    /**
     * @return bool
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * @param bool $test
     * @return $this
     */
    public function setTest($test)
    {
        $this->test = $test;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastFourDigits()
    {
        return $this->lastFourDigits;
    }

    /**
     * @param string $lastFourDigits
     * @return $this
     */
    public function setLastFourDigits($lastFourDigits)
    {
        $this->lastFourDigits = $lastFourDigits;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstSixDigits()
    {
        return $this->firstSixDigits;
    }

    /**
     * @param string $firstSixDigits
     * @return $this
     */
    public function setFirstSixDigits($firstSixDigits)
    {
        $this->firstSixDigits = $firstSixDigits;

        return $this;
    }

    /**
     * @return string
     */
    public function getCardType()
    {
        return $this->cardType;
    }

    /**
     * @param string $cardType
     * @return $this
     */
    public function setCardType($cardType)
    {
        $this->cardType = $cardType;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return $this
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return $this
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

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
     * @return int
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @param int $month
     * @return $this
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param int $year
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
    public function getPaymentMethodType()
    {
        return $this->paymentMethodType;
    }

    /**
     * @param string $paymentMethodType
     * @return $this
     */
    public function setPaymentMethodType($paymentMethodType)
    {
        $this->paymentMethodType = $paymentMethodType;

        return $this;
    }

    /**
     * @return string
     */
    public function getFingerprint()
    {
        return $this->fingerprint;
    }

    /**
     * @param string $fingerprint
     * @return $this
     */
    public function setFingerprint($fingerprint)
    {
        $this->fingerprint = $fingerprint;

        return $this;
    }

    /**
     * @return string
     */
    public function getVerificationValue()
    {
        return $this->verificationValue;
    }

    /**
     * @param string $verificationValue
     * @return $this
     */
    public function setVerificationValue($verificationValue)
    {
        $this->verificationValue = $verificationValue;

        return $this;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $number
     * @return $this
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }
}
