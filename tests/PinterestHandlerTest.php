<?php
namespace AnyDownloader\RedGifsDownloader\Tests;

use AnyDownloader\DownloadManager\Model\URL;
use AnyDownloader\PinterestDownloader\PinterestHandler;
use Goutte\Client;
use PHPUnit\Framework\TestCase;

class PinterestHandlerTest extends TestCase
{
    /** @test */
    public function handler_validates_given_url()
    {
        $handler = new PinterestHandler(new Client());
        $url = URL::fromString('https://www.pinterest.com/pin/467952217532671722/');
        $this->assertTrue($handler->isValidUrl($url));
    }

    /** @test */
    public function handler_validates_given_url_without_www()
    {
        $handler = new PinterestHandler(new Client());
        $url = URL::fromString('https://pinterest.com/pin/467952217532671722/');
        $this->assertTrue($handler->isValidUrl($url));
    }

    /** @test */
    public function handler_can_not_validate_given_url()
    {
        $handler = new PinterestHandler(new Client());
        $url = URL::fromString('https://facebook.com/pin/467952217532671722');
        $this->assertFalse($handler->isValidUrl($url));
    }
}