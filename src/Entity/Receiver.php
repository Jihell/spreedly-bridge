<?php
/**
 * @licence Proprietary
 */
namespace Jihel\OmnipaySpreedlyBridgeBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Jihel\OmnipaySpreedlyBridgeBundle\Model;
use Omnipay\SpreedlyBridge\Model\ReceiverInterface;
// Annotation
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Receiver
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 *
 * @ORM\Table(name="omnipay_spreedly_receiver")
 * @ORM\Entity(repositoryClass="Jihel\OmnipaySpreedlyBridgeBundle\Repository\ReceiverRepository")
 *
 * @Gedmo\Loggable
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Receiver implements ReceiverInterface
{
    use Model\TimestampTrait;

    public function __construct()
    {
        $this
            ->setTransaction(new ArrayCollection())
        ;
    }

    public function __toString()
    {
        return $this->getCompanyName().(null === $this->getDeletedAt() ? '' : ' - /!\ DELETED /!\\');
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
     * @ORM\OneToMany(targetEntity="Jihel\OmnipaySpreedlyBridgeBundle\Entity\Transaction", mappedBy="receiver")
     */
    protected $transaction;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $companyName;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $token;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $receiverType;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $hostnames;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $state;

    /**
     * @var array
     *
     * @ORM\Column(type="json_array")
     */
    protected $credentials;

    /**
     * @var string
     *
     * @Assert\NotBlank
     * @ORM\Column(type="string")
     */
    protected $bridgeClass;

    /**
     * @var string
     *
     * @Assert\NotBlank
     * @ORM\Column(type="string", nullable=true)
     */
    protected $receiverUser;

    /**
     * @var string
     *
     * @Assert\NotBlank
     * @ORM\Column(type="string", nullable=true)
     */
    protected $receiverPass;

    /**
     * @var string
     *
     * @Assert\NotBlank
     * @ORM\Column(type="string", nullable=true)
     */
    protected $receiverMid;


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
     * @return ArrayCollection|Model\TransactionInterface[]
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @param ArrayCollection|Model\TransactionInterface[] $transaction
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
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param string $companyName
     * @return $this
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

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
    public function getReceiverType()
    {
        return $this->receiverType;
    }

    /**
     * @param string $receiverType
     * @return $this
     */
    public function setReceiverType($receiverType)
    {
        $this->receiverType = $receiverType;

        return $this;
    }

    /**
     * @return string
     */
    public function getHostnames()
    {
        return $this->hostnames;
    }

    /**
     * @param string $hostnames
     * @return $this
     */
    public function setHostnames($hostnames)
    {
        $this->hostnames = $hostnames;

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
     * @return array
     */
    public function getCredentials()
    {
        return $this->credentials;
    }

    /**
     * @param array $credentials
     * @return $this
     */
    public function setCredentials(array $credentials)
    {
        $this->credentials = $credentials;

        return $this;
    }

    /**
     * @return string
     */
    public function getBridgeClass()
    {
        return $this->bridgeClass;
    }

    /**
     * @param string $bridgeClass
     * @return $this
     */
    public function setBridgeClass($bridgeClass)
    {
        $this->bridgeClass = $bridgeClass;

        return $this;
    }

    /**
     * @return string
     */
    public function getReceiverUser()
    {
        return $this->receiverUser;
    }

    /**
     * @param string $receiverUser
     * @return $this
     */
    public function setReceiverUser($receiverUser)
    {
        $this->receiverUser = $receiverUser;

        return $this;
    }

    /**
     * @return string
     */
    public function getReceiverPass()
    {
        return $this->receiverPass;
    }

    /**
     * @param string $receiverPass
     * @return $this
     */
    public function setReceiverPass($receiverPass)
    {
        $this->receiverPass = $receiverPass;

        return $this;
    }

    /**
     * @return string
     */
    public function getReceiverMid()
    {
        return $this->receiverMid;
    }

    /**
     * @param string $receiverMid
     * @return $this
     */
    public function setReceiverMid($receiverMid)
    {
        $this->receiverMid = $receiverMid;

        return $this;
    }
}
