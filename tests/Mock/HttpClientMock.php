<?php
namespace AnyDownloader\PinterestDownloader\Test\Mock;

use Symfony\Component\HttpClient\Response\ResponseStream;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;

/**
 * @method  withOptions(array $options)
 */
class HttpClientMock implements HttpClientInterface
{

    public function request(string $method, string $url, array $options = []): ResponseInterface
    {
        return new PinterestResponseMock();
    }

    public function stream($responses, float $timeout = null): ResponseStreamInterface
    {
        return new ResponseStream(new \Generator());
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement @method  withOptions(array $options)
    }
}