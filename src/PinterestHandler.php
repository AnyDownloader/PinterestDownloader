<?php
namespace AnyDownloader\PinterestDownloader;

use AnyDownloader\DownloadManager\Exception\NothingToExtractException;
use AnyDownloader\DownloadManager\Exception\NotValidUrlException;
use AnyDownloader\DownloadManager\Handler\BaseHandler;
use AnyDownloader\DownloadManager\Model\Attribute\IdAttribute;
use AnyDownloader\DownloadManager\Model\Attribute\TextAttribute;
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
        'short' => '/(\/\/|www\.)pin\.[a-zA-Z]+\/[a-zA-Z0-9]+/s',
        'full' => '/(\/\/|www\.)pinterest\.[a-zA-Z]+\/pin\/[0-9]+/s',
        'full_dirty' => '/(\/\/|www\.)pinterest\.[a-zA-Z]+\/pin\/[0-9]+\/(.*)/s'
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
     * @return FetchedResource
     * @throws NotValidUrlException
     * @throws NothingToExtractException
     */
    public function fetchResource(URL $url): FetchedResource
    {
        $realUrl = clone $url;
        $realUrl->followLocation();
        preg_match('/\/pin\/[0-9]+/s', $realUrl->getValue(), $pinId);

        if (empty($pinId)) {
            throw new NotValidUrlException();
        }

        $realUrl = 'https://pinterest.com' . $pinId[0];
        $crawler = $this->client->request('GET', $realUrl);
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
        $resource = new PinterestFetchedResource($url);
        $data = $data->resourceResponses[0]->response->data;

        if ($data->images) {
            foreach ($data->images as $image) {
                $imageResource = ResourceItemFactory::fromURL(
                    URL::fromString($image->url), $image->width . 'x' . $image->height
                );
                $resource->addItem($imageResource);
            }
            if (isset($imageResource)) {
                $resource->setImagePreview($imageResource);
            }
        }

        if ($data->videos && $data->videos->video_list) {
            foreach ($data->videos->video_list as $video) {
                $videoResource = ResourceItemFactory::fromURL(
                    URL::fromString($video->url), $video->width . 'x' . $video->height
                );
                if ($videoResource) {
                    $resource->addItem($videoResource);
                    $resource->setVideoPreview($videoResource);
                }
            }
        }

        if ($data->id) {
           $resource->addAttribute(new IdAttribute($data->id));
        }

        if ($data->pinner) {
            $author = PinterestAuthorAttribute::fromPinterestOriginPinnerStdObj($data->pinner);
            $resource->addAttribute($author);
        }

        if ($data->description) {
            $resource->addAttribute(new TextAttribute($data->description));
        }

        return $resource;
    }

}