<?php
/**
 * @licence Proprietary
 */
namespace Omnipay\SpreedlyBridge\Message;

/**
 * Class RefundRequest
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class RefundRequest extends AbstractRequest
{
    /**
     * @param array $data
     * @return \Omnipay\Common\Message\AbstractResponse|\Omnipay\Common\Message\ResponseInterface|Response
     */
    public function sendData($data)
    {
        $httpResponse = $this->httpClient->request(
            $data['request_method'],
            $data['url'],
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
        return $this->getBridge()->refund([
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'token' => $this->getToken(),
            'receiverUser' => $this->getReceiver()->getReceiverUser(),
            'receiverPass' => $this->getReceiver()->getReceiverPass(),
            'receiverMid' => $this->getReceiver()->getReceiverMid(),
        ]);
    }
}
