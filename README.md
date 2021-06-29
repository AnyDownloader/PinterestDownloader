# PinterestDownloader
Get video & image sources from Pinterest

Install via Composer
```
composer require any-downloader/pinterest-downloader
```

You have two options of how to use this package

1. Use it standalone

```
<?php
use AnyDownloader\DownloadManager\Model\URL;
use AnyDownloader\PinterestDownloader\PinterestHandler;
use Goutte\Client;

include_once 'vendor/autoload.php';

$pinUrl = URL::fromString('https://pin.it/i6z3naz65vlh7t');
$pinterestHandler = new PinterestHandler(new Client());
$result = $pinterestHandler->fetchResource($pinUrl);

print_r($result->toArray());

/**
Array
(
    [source_url] => https://pin.it/i6z3naz65vlh7t
    [preview_image] => Array
        (
            [type] => image
            [format] => png
            [quality] => 720x1280
            [url] => https://i.pinimg.com/originals/f2/ce/36/f2ce36b176a836dc929e592856751ded.png
            [mime_type] => image/png
        )

    [preview_video] => Array
        (
            [type] => video
            [format] => mp4
            [quality] => 720x1280
            [url] => https://v.pinimg.com/videos/mc/720p/5b/f2/b6/5bf2b646c97ae208a0287ae25d58b1a0.mp4
            [mime_type] => video/mp4
        )

    [attributes] => Array
        (
            [id] => 659495939164206993
            [author] => Array
                (
                    [id] => 659496076591524584
                    [avatar_url] => https://i.pinimg.com/75x75_RS/32/d6/65/32d665ff7b68ecd3e6cfb6e66cf75bc3.jpg
                    [full_name] => Anupama Prasad
                    [nickname] => anupamaannaya
                )

            [text] => caramel custard recipe | caramel pudding recipe | caramel custard pudding with detailed photo and video recipe. a popular, creamy and rich dessert recipe made with custard powder and milk. it is a known dessert recipe in european countries and an integral part of full course meal. there are many variants and flavours to this recipe, but this recipe post dedicates to the basic version of custard pudding recipe.
        )

    [items] => Array
        (
            [image] => Array
                (
                    [0] => Array
                        (
                            [type] => image
                            [format] => jpg
                            [quality] => 60x60
                            [url] => https://i.pinimg.com/60x60/f2/ce/36/f2ce36b176a836dc929e592856751ded.jpg
                            [mime_type] => image/jpg
                        )

                    [1] => Array
                        (
                            [type] => image
                            [format] => jpg
                            [quality] => 136x136
                            [url] => https://i.pinimg.com/136x136/f2/ce/36/f2ce36b176a836dc929e592856751ded.jpg
                            [mime_type] => image/jpg
                        )

                    [2] => Array
                        (
                            [type] => image
                            [format] => jpg
                            [quality] => 170x302
                            [url] => https://i.pinimg.com/170x/f2/ce/36/f2ce36b176a836dc929e592856751ded.jpg
                            [mime_type] => image/jpg
                        )

                    [3] => Array
                        (
                            [type] => image
                            [format] => jpg
                            [quality] => 236x419
                            [url] => https://i.pinimg.com/236x/f2/ce/36/f2ce36b176a836dc929e592856751ded.jpg
                            [mime_type] => image/jpg
                        )

                    [4] => Array
                        (
                            [type] => image
                            [format] => jpg
                            [quality] => 474x842
                            [url] => https://i.pinimg.com/474x/f2/ce/36/f2ce36b176a836dc929e592856751ded.jpg
                            [mime_type] => image/jpg
                        )

                    [5] => Array
                        (
                            [type] => image
                            [format] => jpg
                            [quality] => 564x1002
                            [url] => https://i.pinimg.com/564x/f2/ce/36/f2ce36b176a836dc929e592856751ded.jpg
                            [mime_type] => image/jpg
                        )

                    [6] => Array
                        (
                            [type] => image
                            [format] => jpg
                            [quality] => 720x1280
                            [url] => https://i.pinimg.com/736x/f2/ce/36/f2ce36b176a836dc929e592856751ded.jpg
                            [mime_type] => image/jpg
                        )

                    [7] => Array
                        (
                            [type] => image
                            [format] => jpg
                            [quality] => 600x315
                            [url] => https://i.pinimg.com/600x315/f2/ce/36/f2ce36b176a836dc929e592856751ded.jpg
                            [mime_type] => image/jpg
                        )

                    [8] => Array
                        (
                            [type] => image
                            [format] => png
                            [quality] => 720x1280
                            [url] => https://i.pinimg.com/originals/f2/ce/36/f2ce36b176a836dc929e592856751ded.png
                            [mime_type] => image/png
                        )

                )

            [video] => Array
                (
                    [0] => Array
                        (
                            [type] => video
                            [format] => mp4
                            [quality] => 720x1280
                            [url] => https://v.pinimg.com/videos/mc/720p/5b/f2/b6/5bf2b646c97ae208a0287ae25d58b1a0.mp4
                            [mime_type] => video/mp4
                        )

                )

        )

)

**/
```

2. Use it with DownloadManager.
Useful in case if your application is willing to download files from different sources (i.e. has more than one download handler)

```
<?php
use AnyDownloader\DownloadManager\DownloadManager;
use AnyDownloader\DownloadManager\Model\URL;
use AnyDownloader\PinterestDownloader\PinterestHandler;
use Goutte\Client;

include_once 'vendor/autoload.php';

$pinUrl = URL::fromString('https://pin.it/i6z3naz65vlh7t');

$downloadManager = new DownloadManager();
$downloadManager->addHandler(new PinterestHandler(new Client()));

$result = $downloadManager->fetchResource($pinUrl);

print_r($result->toArray());
```