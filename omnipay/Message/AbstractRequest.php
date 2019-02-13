<?php
/**
 * @licence Proprietary
 */
namespace Omnipay\SpreedlyBridge\Message;

use Omnipay\Common\Message\AbstractRequest as BaseRequest;
use Omnipay\SpreedlyBridge\Model\ReceiverBridgeInterface;
use Omnipay\SpreedlyBridge\Model\ReceiverInterface;

/**
 * Class AbstractRequest
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
abstract class AbstractRequest extends BaseRequest
{
    const API_VERSION = 'v1';

    const ENDPOINT = 'https://core.spreedly.com';

    /**
     * @var ReceiverBridgeInterface
     */
    protected $receiverBridge;

    /**
     * @return ReceiverInterface
     */
    public function getReceiver()
    {
        return $this->getParameter('receiver');
    }

    /**
     * @param ReceiverInterface $value
     * @return AbstractRequest
     */
    public function setReceiver(ReceiverInterface $value)
    {
        return $this->setParameter('receiver', $value);
    }

    /**
     * @return string
     */
    public function get3ds()
    {
        return $this->getParameter('3ds');
    }

    /**
     * @param string $value
     * @return AbstractRequest
     */
    public function set3ds($value)
    {
        return $this->setParameter('3ds', $value);
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->getParameter('currency');
    }

    /**
     * @param string $value
     * @return AbstractRequest
     */
    public function setCurrency($value)
    {
        return $this->setParameter('currency', $value);
    }

    /**
     * @return string
     */
    public function getBin()
    {
        return $this->getParameter('bin');
    }

    /**
     * @param string $value
     * @return AbstractRequest
     */
    public function setBin($value)
    {
        return $this->setParameter('bin', $value);
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->getParameter('user');
    }

    /**
     * @param string $value
     * @return AbstractRequest
     */
    public function setUser($value)
    {
        return $this->setParameter('user', $value);
    }

    /**
     * @return string
     */
    public function getSecret()
    {
        return $this->getParameter('secret');
    }

    /**
     * @param string $value
     * @return AbstractRequest
     */
    public function setSecret($value)
    {
        return $this->setParameter('secret', $value);
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->getParameter('token');
    }

    /**
     * @param string $value
     * @return AbstractRequest
     */
    public function setToken($value)
    {
        return $this->setParameter('token', $value);
    }

    /**
     * @return string
     */
    public function getLandingUrl()
    {
        return $this->getParameter('landingUrl');
    }

    /**
     * @param string $value
     * @return AbstractRequest
     */
    public function setLandingUrl($value)
    {
        return $this->setParameter('landingUrl', $value);
    }

    /**
     * @return string
     */
    protected function getHttpMethod()
    {
        return 'POST';
    }

    /**
     * @return string
     */
    protected function getEndpoint()
    {
        return self::ENDPOINT.'/'.static::API_VERSION;
    }

    /**
     * @return array
     */
    protected function getHeaders()
    {
        return [
            'Content-Type' => 'application/json',
            'Authorization' => sprintf('Basic %s',
                base64_encode(sprintf('%s:%s',
                    $this->getUser(),
                    $this->getSecret()
                ))
            ),
        ];
    }

    /**
     * @param array $data
     * @return \Omnipay\Common\Message\ResponseInterface|Response
     */
    public function sendData($data)
    {
        $body = [
            'delivery' => array_merge([
                'payment_method_token' => $this->getCardReference(),
            ],
                $data
            ),
        ];

        $httpResponse = $this->httpClient->request(
            $this->getHttpMethod(),
            sprintf('%s/receivers/%s/deliver.json', $this->getEndpoint(), $this->getReceiver()->getToken()),
            $this->getHeaders(),
            json_encode($body)
        );

        return $this->response = $this->getBridge()->createResponse(
            $this,
            json_decode($httpResponse->getBody(), true),
            $httpResponse->getStatusCode()
        );
    }

    /**
     * @return array
     */
    abstract public function getData();

    /**
     * @return ReceiverBridgeInterface
     */
    protected function getBridge()
    {
        if (null === $this->receiverBridge) {
            $this->receiverBridge = $this->createBridge($this->getReceiver()->getBridgeClass());
        }

        return $this->receiverBridge;
    }

    /**
     * @param string $className
     */
    protected function createBridge($className)
    {
        /** @var ReceiverBridgeInterface $bridge */
        $bridge = new $className();

        $bridge
            ->setTestMode($this->getTestMode())
        ;

        return $bridge;
    }
}
