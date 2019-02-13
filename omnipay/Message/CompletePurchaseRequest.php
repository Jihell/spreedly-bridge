<?php
/**
 * @licence Proprietary
 */
namespace Omnipay\SpreedlyBridge\Message;

/**
 * Class PurchaseRequest
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class CompletePurchaseRequest extends AbstractRequest
{
    /**
     * @return string
     */
    protected function getEndpoint()
    {
        return parent::getEndpoint();
    }

    /**
     * @return string
     */
    protected function getHttpMethod()
    {
        return 'GET';
    }

    /**
     * @param array $data
     * @return \Omnipay\Common\Message\AbstractResponse|\Omnipay\Common\Message\ResponseInterface|Response
     */
    public function sendData($data)
    {
        $httpResponse = $this->httpClient->request(
            $this->getHttpMethod(),
            sprintf('%s/payments/%s?%s', $data['endPoint'], $data['id'], $data['auth'])
        );

        return $this->response = $this->getBridge()->createResponse(
            $this,
            json_decode($httpResponse->getBody(), true),
            $httpResponse->getStatusCode()
        );
    }

    /**
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        return $this->getBridge()->completePurchase([
            '3ds' => $this->get3ds(),
            'receiverUser' => $this->getReceiver()->getReceiverUser(),
            'receiverPass' => $this->getReceiver()->getReceiverPass(),
            'receiverMid' => $this->getReceiver()->getReceiverMid(),
        ]);
    }
}
