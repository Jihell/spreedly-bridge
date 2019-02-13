<?php
/**
 * @licence Proprietary
 */
namespace Jihel\OmnipaySpreedlyBridgeBundle\Factory;

use Omnipay\Common\Helper;
use Omnipay\SpreedlyBridge\Model\ReceiverBridgeInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Class ReceiverAbstract
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
abstract class ReceiverAbstract implements ReceiverBridgeInterface
{
    /**
     * @var ParameterBag
     */
    protected $parameters;

    /**
     * @return ParameterBag
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param ParameterBag $parameters
     * @return $this
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * @param $parameter
     * @return mixed|null
     */
    public function getParameter($parameter)
    {
        return $this->parameters->get($parameter);
    }

    /**
     * @param string $parameter
     * @param mixed $value
     * @return $this
     */
    public function setParameter($parameter, $value)
    {
        $this->parameters->set($parameter, $value);

        return $this;
    }

    /**
     * Gets the test mode of the request from the gateway.
     *
     * @return boolean
     */
    public function getTestMode()
    {
        return $this->getParameter('testMode');
    }

    /**
     * @param bool $mode
     * @return $this|ReceiverBridgeInterface
     */
    public function setTestMode($mode)
    {
        $this->setParameter('testMode', $mode);

        return $this;
    }

    /**
     * ReceiverAbstract constructor.
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Initialize the object with parameters.
     *
     * If any unknown parameters passed, they will be ignored.
     *
     * @param array $parameters
     * @return $this
     */
    public function initialize(array $parameters = [])
    {
        $this->parameters = new ParameterBag();

        Helper::initialize($this, $parameters);

        return $this;
    }
}
