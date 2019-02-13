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
class PurchaseRequest extends AbstractRequest
{
    /**
     * @return string
     */
    protected function getEndpoint()
    {
        return parent::getEndpoint();
    }

    /**
     * @param array $data
     * @return \Omnipay\Common\Message\AbstractResponse|\Omnipay\Common\Message\ResponseInterface|Response
     */
    public function sendData($data)
    {
        // Only on initial payment
        if (!$this->getToken()) {
            return parent::sendData($data);
        }

        $httpResponse = $this->httpClient->request(
            $data['request_method'],
            sprintf('%s?%s', $data['url'], $data['body']),
            explode(',', $data['headers'])
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
        return $this->getBridge()->purchase([
            '3ds' => $this->get3ds(),
            'bin' => $this->getBin(),
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'token' => $this->getToken(),
            'landingUrl' => $this->getLandingUrl(),
            'receiverUser' => $this->getReceiver()->getReceiverUser(),
            'receiverPass' => $this->getReceiver()->getReceiverPass(),
            'receiverMid' => $this->getReceiver()->getReceiverMid(),
        ]);
    }
}
