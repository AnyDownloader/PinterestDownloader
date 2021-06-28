<?php
namespace AnyDownloader\PinterestDownloader\Tests;

use AnyDownloader\DownloadManager\Model\URL;
use AnyDownloader\PinterestDownloader\PinterestHandler;
use Goutte\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Component\BrowserKit\HttpBrowser;

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
    public function handler_validates_given_on_different_domain_zone()
    {
        $handler = new PinterestHandler(new Client());
        $url = URL::fromString('https://www.pinterest.ca/pin/467952217532671722/');
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
    public function handler_validates_given_short_url()
    {
        $handler = new PinterestHandler(new Client());
        $url = URL::fromString('https://pin.it/i6z3naz65vlh7t');
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