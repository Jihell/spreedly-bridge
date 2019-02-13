<?php
/**
 * @licence Proprietary
 */
namespace Jihel\OmnipaySpreedlyBridgeBundle\Bridge\Exception;

use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Class CreateReceiverException
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class CreateReceiverException extends \Exception
{
    /**
     * CreateReceiverException constructor.
     *
     * @param ResponseInterface $response
     * @param Throwable|null    $previous
     */
    public function __construct(ResponseInterface $response, Throwable $previous = null)
    {
        $code = '403.'.$response->getStatusCode();

        parent::__construct(
            sprintf('%s %s: %s',
                $code,
                $response->getReasonPhrase(),
                $response->getBody()->getContents()
            ),
            $code,
            $previous
        );
    }
}
