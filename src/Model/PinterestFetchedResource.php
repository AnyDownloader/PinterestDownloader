<?php
namespace AnyDownloader\PinterestDownloader\Model;

use AnyDownloader\DownloadManager\Model\FetchedResource;

final class PinterestFetchedResource extends FetchedResource
{
    /**
     * @return string
     */
    public function getExtSource(): string
    {
        return 'pinterest';
    }
}
