<?php
/**
 * @licence Proprietary
 */
namespace Jihel\OmnipaySpreedlyBridgeBundle\Model;

use Omnipay\SpreedlyBridge\Model\CredentialInterface;

/**
 * Class Credential
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class Credential implements CredentialInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var bool
     */
    protected $safe;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return bool
     */
    public function getSafe()
    {
        return $this->safe;
    }

    /**
     * @param bool $safe
     * @return $this
     */
    public function setSafe($safe)
    {
        $this->safe = $safe;

        return $this;
    }
}
