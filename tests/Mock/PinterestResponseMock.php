<?php
namespace AnyDownloader\PinterestDownloader\Test\Mock;

use Symfony\Contracts\HttpClient\ResponseInterface;

class PinterestResponseMock implements ResponseInterface
{
    public function getStatusCode(): int
    {
        return 200;
    }

    public function getHeaders(bool $throw = true): array
    {
        return ['Host' => 'pinterest.com'];
    }

    public function getContent(bool $throw = true): string
    {
        return file_get_contents(__DIR__ . '/pinterest.php');
    }

    public function toArray(bool $throw = true): array
    {
        return [];
    }

    public function cancel(): void
    {

    }

    public function getInfo(string $type = null)
    {

    }
}