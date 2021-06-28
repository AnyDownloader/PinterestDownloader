<?php
namespace AnyDownloader\PinterestDownloader;

use AnyDownloader\DownloadManager\Exception\NothingToExtractException;
use AnyDownloader\DownloadManager\Handler\BaseHandler;
use AnyDownloader\DownloadManager\Model\FetchedResource;
use AnyDownloader\DownloadManager\Model\ResourceItem\ResourceItemFactory;
use AnyDownloader\DownloadManager\Model\URL;
use AnyDownloader\PinterestDownloader\Model\Attribute\PinterestAuthorAttribute;
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
     * PinterestHandler constructor.
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
        $jsons = [];

        if (!preg_match(
            '/<script id=\"initial-state\" type=\"application\/json\">(.*)<\/script><script id=\"pc-state/s',
            $crawler->html(),
            $jsons)
        ) {
            throw new NothingToExtractException();
        }

        $data = json_decode($jsons[1]);
        if (json_last_error()) {
            throw new NothingToExtractException(json_last_error_msg());
        }
        $pinterestResource = new PinterestFetchedResource($url);

        if ($images = $data->resourceResponses[0]->response->data->images) {
            foreach ($images as $image) {
                $imageResource = ResourceItemFactory::fromURL(
                    URL::fromString($image->url), $image->width . 'x' . $image->height
                );
                $pinterestResource->addItem($imageResource);
            }
            if (isset($imageResource)) {
                $pinterestResource->setImagePreview($imageResource);
            }
        }

        $author = PinterestAuthorAttribute::fromPinterestOriginPinnerStdObj($data->resourceResponses[0]->response->data->pinner);
        $pinterestResource->addAttribute($author);

        return $pinterestResource;
    }

}