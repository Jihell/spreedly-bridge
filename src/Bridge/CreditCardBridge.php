<?php
/**
 * @licence Proprietary
 */
namespace Jihel\OmnipaySpreedlyBridgeBundle\Bridge;

use GuzzleHttp\ClientInterface;
use Omnipay\SpreedlyBridge\Model\CreditCardInterface;

/**
 * Class CreditCardBridge
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class CreditCardBridge
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
     * @param CreditCardInterface $creditCard
     * @return array
     * @throws Exception\CreateReceiverException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function showCreditCard(CreditCardInterface $creditCard)
    {
        $response = $this->getDefaultHttpClient()
            ->request(
                'GET',
                sprintf('/v1/payment_methods/%s.json', $creditCard->getToken())
            )
        ;

        if (200 !== $response->getStatusCode()) {
            throw new Exception\CreateReceiverException($response);
        }

        return json_decode($response->getBody()->getContents(), true)['payment_method'];
    }
}
