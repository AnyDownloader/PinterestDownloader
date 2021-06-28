<?php
namespace AnyDownloader\PinterestDownloader\Test\Mock;

use AnyDownloader\DownloadManager\Model\URL;

class URLMock extends URL
{
    /**
     * @param int $redirectsLeft
     */
    public function followLocation(int $redirectsLeft = 5): void {
        $this->value = 'https://www.pinterest.com/pin/659495939164206993/feedback/?invite_code=d6155233c5334fbc91b315c31ce06155&sender_id=842665917686033511';
    }
}
