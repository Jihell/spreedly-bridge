<?php
/**
 * @licence Proprietary
 */
namespace Jihel\OmnipaySpreedlyBridgeBundle\Bridge;

use GuzzleHttp\ClientInterface;
use Omnipay\SpreedlyBridge\Model\CredentialInterface;
use Omnipay\SpreedlyBridge\Model\ReceiverRequestInterface;

/**
 * Class ReceiverBridge
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class ReceiverBridge
{
    const ENDPOINT = 'https://core.spreedly.com/';

    /**
     * @var string
     */
    protected $user;

    /**
     * @var string
     */
    protected $secret;

    /**
     * ReceiverBridge constructor.
     *
     * @param string $user
     * @param string $secret
     */
    public function __construct(string $user, string $secret)
    {
        $this->user = $user;
        $this->secret = $secret;
    }

    /**
     * @return \GuzzleHttp\Client|ClientInterface
     */
    protected function getDefaultHttpClient()
    {
        return new \GuzzleHttp\Client([
            'base_uri' => static::ENDPOINT,
            'auth' => [
                $this->user,
                $this->secret,
                'basic',
            ],
            'headers' => [
                'Content-type' => 'application/json'
            ]
        ]);
    }

    /**
     * @param ReceiverRequestInterface $receiverRequest
     * @return array|mixed|object
     * @throws Exception\CreateReceiverException
     */
    public function createReceiver(ReceiverRequestInterface $receiverRequest)
    {
        $credentials = array_map(function(CredentialInterface $credential) {
            return [
                'name' => $credential->getName(),
                'value' => $credential->getValue(),
                'safe' => (bool) $credential->getSafe(),
            ];
        }, $receiverRequest->getCredentials()->toArray());

        $response = $this->getDefaultHttpClient()
            ->request(
                'POST',
                '/v1/receivers.json',
                [
                    'json' => [
                        'receiver' => [
                            'receiver_type' => $receiverRequest->getType(),
                            'hostnames' => $receiverRequest->getHostnames(),
                            'credentials' => $credentials,
                        ],
                    ],
                ]
            )
        ;

        if (201 !== $response->getStatusCode()) {
            throw new Exception\CreateReceiverException($response);
        }

        return json_decode($response->getBody()->getContents(), true)['receiver'];
    }

    /**
     * @param string $token
     * @return mixed
     * @throws Exception\CreateReceiverException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function showReceiver(string $token)
    {
        $response = $this->getDefaultHttpClient()
            ->request(
                'GET',
                sprintf('/v1/receivers/%s.json', $token)
            )
        ;

        if (200 !== $response->getStatusCode()) {
            throw new Exception\CreateReceiverException($response);
        }

        return json_decode($response->getBody()->getContents(), true)['receiver'];
    }
}
