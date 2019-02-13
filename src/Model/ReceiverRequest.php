<?php
/**
 * @licence Proprietary
 */
namespace Jihel\OmnipaySpreedlyBridgeBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Omnipay\SpreedlyBridge\Model\CredentialInterface;
use Omnipay\SpreedlyBridge\Model\ReceiverRequestInterface;

/**
 * Class Receiver
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class ReceiverRequest implements ReceiverRequestInterface
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $hostnames;

    /**
     * @var ArrayCollection|Credential[]
     */
    protected $credentials;

    /**
     * @var string
     */
    protected $bridgeClass;

    /**
     * @var string
     */
    protected $receiverUser;

    /**
     * @var string
     */
    protected $receiverPass;

    /**
     * @var string
     */
    protected $receiverMid;

    /**
     * Receiver constructor.
     */
    public function __construct()
    {
        $this->credentials = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

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
     * @return ArrayCollection|Credential[]
     */
    public function getCredentials()
    {
        return $this->credentials;
    }

    /**
     * @param ArrayCollection|Credential[] $credentials
     * @return $this
     */
    public function setCredentials($credentials)
    {
        $this->credentials = $credentials;

        return $this;
    }

    /**
     * @param Credential $credential
     * @return $this
     */
    public function addCredential(CredentialInterface $credential)
    {
        $this->credentials->add($credential);

        return $this;
    }

    /**
     * @param Credential $credential
     * @return $this
     */
    public function removeCredential(CredentialInterface $credential)
    {
        $this->credentials->removeElement($credential);

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
