<?php
/**
 * @licence Proprietary
 */
namespace Omnipay\SpreedlyBridge;

use Jihel\VikingPayReceiver\Bridge\VikingPayReceiver;
use Omnipay\Common\AbstractGateway;
use Omnipay\Common\GatewayInterface;
use Omnipay\Common\Http\ClientInterface;
use Omnipay\SpreedlyBridge\Model\ReceiverInterface;

/**
 * Class SpreedlyBridge
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class Gateway extends AbstractGateway implements GatewayInterface
{
    const ENDPOINT = 'https://core.spreedly.com/';
    const NAME = 'SpreedlyBridge';

    /**
     * @param string $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->setParameter('user', $user);

        return $this;
    }

    /**
     * @param string $secret
     * @return $this
     */
    public function setSecret($secret)
    {
        $this->setParameter('secret', $secret);

        return $this;
    }

    /**
     * @param ReceiverInterface $receiver
     * @return $this
     */
    public function setReceiver(ReceiverInterface $receiver)
    {
        $this->setParameter('receiver', $receiver);

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return static::NAME;
    }

    /**
     * @param array $options
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
    public function authorize(array $options = [])
    {
        return $this->createRequest(Message\AuthorizeRequest::class, $options);
    }

    /**
     * @param array $options
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
    public function purchase(array $options = [])
    {
        return $this->createRequest(Message\PurchaseRequest::class, $options);
    }

    /**
     * @param array $options
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
    public function completePurchase(array $options = [])
    {
        return $this->createRequest(Message\CompletePurchaseRequest::class, $options);
    }

    /**
     * @param array $options
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
    public function refund(array $options = [])
    {
        return $this->createRequest(Message\RefundRequest::class, $options);
    }
}
