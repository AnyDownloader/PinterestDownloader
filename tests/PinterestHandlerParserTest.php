<?php
namespace AnyDownloader\PinterestDownloader\Test;

use AnyDownloader\PinterestDownloader\Test\Mock\URLMock as URL;
use AnyDownloader\PinterestDownloader\Model\PinterestFetchedResource;
use AnyDownloader\PinterestDownloader\PinterestHandler;
use AnyDownloader\PinterestDownloader\Test\Mock\HttpClientMock;
use Goutte\Client;
use PHPUnit\Framework\TestCase;

class PinterestHandlerParserTest extends TestCase
{
    /** @test */
    public function handler_parses_page_correctly_and_returns_resource_model()
    {
        $url = URL::fromString('https://pin.it/i6z3naz65vlh7t');

        $handler = new PinterestHandler(new Client(new HttpClientMock()));

        $res = $handler->fetchResource($url);

        $this->assertInstanceOf(PinterestFetchedResource::class, $res);

        $this->assertEquals([
            'source_url' => 'https://pin.it/i6z3naz65vlh7t',
            'preview_image' => [
                'type' => 'image',
                'format' => 'png',
                'title' => '720x1280',
                'url' => 'https://i.pinimg.com/originals/f2/ce/36/f2ce36b176a836dc929e592856751ded.png',
                'mime_type' => 'image/png'
            ],
            'preview_video' => [
                'type' => 'video',
                'format' => 'mp4',
                'title' => '720x1280',
                'url' => 'https://v.pinimg.com/videos/mc/720p/5b/f2/b6/5bf2b646c97ae208a0287ae25d58b1a0.mp4',
                'mime_type' => 'video/mp4'
            ],
            'attributes' => [
                'id' => '659495939164206993',
                'author' => [
                    'id' => '659496076591524584',
                    'avatar_url' => 'https://i.pinimg.com/75x75_RS/32/d6/65/32d665ff7b68ecd3e6cfb6e66cf75bc3.jpg',
                    'full_name' => 'Anupama Prasad',
                    'nickname' => 'anupamaannaya',
                    'avatar' => [
                        'type' => 'image',
                        'format' => 'jpg',
                        'title' => '',
                        'url' => 'https://i.pinimg.com/75x75_RS/32/d6/65/32d665ff7b68ecd3e6cfb6e66cf75bc3.jpg',
                        'mime_type' => 'image/jpg'
                    ]
                ],
                'text' => 'caramel custard recipe | caramel pudding recipe | caramel custard pudding with detailed photo and video recipe. a popular, creamy and rich dessert recipe made with custard powder and milk. it is a known dessert recipe in european countries and an integral part of full course meal. there are many variants and flavours to this recipe, but this recipe post dedicates to the basic version of custard pudding recipe.'
            ],
            'items' => [
                'image' => [[
                        'type' => 'image',
                        'format' => 'jpg',
                        'title' => '60x60',
                        'url' => 'https://i.pinimg.com/60x60/f2/ce/36/f2ce36b176a836dc929e592856751ded.jpg',
                        'mime_type' => 'image/jpg'
                    ],
                    [
                        'type' => 'image',
                        'format' => 'jpg',
                        'title' => '136x136',
                        'url' => 'https://i.pinimg.com/136x136/f2/ce/36/f2ce36b176a836dc929e592856751ded.jpg',
                        'mime_type' => 'image/jpg'
                    ],
                    [
                        'type' => 'image',
                        'format' => 'jpg',
                        'title' => '170x302',
                        'url' => 'https://i.pinimg.com/170x/f2/ce/36/f2ce36b176a836dc929e592856751ded.jpg',
                        'mime_type' => 'image/jpg'
                    ],
                    [
                        'type' => 'image',
                        'format' => 'jpg',
                        'title' => '236x419',
                        'url' => 'https://i.pinimg.com/236x/f2/ce/36/f2ce36b176a836dc929e592856751ded.jpg',
                        'mime_type' => 'image/jpg'
                    ],
                    [
                        'type' => 'image',
                        'format' => 'jpg',
                        'title' => '474x842',
                        'url' => 'https://i.pinimg.com/474x/f2/ce/36/f2ce36b176a836dc929e592856751ded.jpg',
                        'mime_type' => 'image/jpg'
                    ],
                    [
                        'type' => 'image',
                        'format' => 'jpg',
                        'title' => '564x1002',
                        'url' => 'https://i.pinimg.com/564x/f2/ce/36/f2ce36b176a836dc929e592856751ded.jpg',
                        'mime_type' => 'image/jpg'
                    ],
                    [
                        'type' => 'image',
                        'format' => 'jpg',
                        'title' => '720x1280',
                        'url' => 'https://i.pinimg.com/736x/f2/ce/36/f2ce36b176a836dc929e592856751ded.jpg',
                        'mime_type' => 'image/jpg'
                    ],
                    [
                        'type' => 'image',
                        'format' => 'jpg',
                        'title' => '600x315',
                        'url' => 'https://i.pinimg.com/600x315/f2/ce/36/f2ce36b176a836dc929e592856751ded.jpg',
                        'mime_type' => 'image/jpg'
                    ],
                    [
                        'type' => 'image',
                        'format' => 'png',
                        'title' => '720x1280',
                        'url' => 'https://i.pinimg.com/originals/f2/ce/36/f2ce36b176a836dc929e592856751ded.png',
                        'mime_type' => 'image/png'
                    ]
                ],
                'video' => [
                    [
                            'type' => 'video',
                            'format' => 'mp4',
                            'title' => '720x1280',
                            'url' => 'https://v.pinimg.com/videos/mc/720p/5b/f2/b6/5bf2b646c97ae208a0287ae25d58b1a0.mp4',
                            'mime_type' => 'video/mp4'
                    ]
                ]
            ]
        ], $res->toArray());
    }
}