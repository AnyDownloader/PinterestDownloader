<?php
namespace AnyDownloader\PinterestDownloader;

use AnyDownloader\DownloadManager\Exception\NothingToExtractException;
use AnyDownloader\DownloadManager\Handler\BaseHandler;
use AnyDownloader\DownloadManager\Model\FetchedResource;
use AnyDownloader\DownloadManager\Model\URL;
use AnyDownloader\PinterestDownloader\Model\PinterestFetchedResource;
use Goutte\Client;

final class PinterestHandler extends BaseHandler
{
    /**
     * @var string[]
     */
    protected $urlRegExPatterns = [
        '/(\/\/|www\.)pinterest\.[a-zA-Z]+\/pin\/[0-9]+/s'
    ];

    /**
     * @var Client
     */
    private $client;

    /**
     * RedGifsHandler constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param URL $url
     * @return PinterestFetchedResource
     * @throws NothingToExtractException
     */
    public function fetchResource(URL $url): FetchedResource
    {
        $crawler = $this->client->request('GET', $url->getValue());

        try {
            $pinterestResource = new PinterestFetchedResource($url);
        } catch (\Throwable $exception) {
            throw new NothingToExtractException($exception->getMessage());
        }

        return $pinterestResource;
    }

}