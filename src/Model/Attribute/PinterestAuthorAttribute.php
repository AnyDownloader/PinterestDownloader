<?php
namespace AnyDownloader\PinterestDownloader\Model\Attribute;

use AnyDownloader\DownloadManager\Model\Attribute\AuthorAttribute;
use AnyDownloader\DownloadManager\Model\URL;

/**
 * Class PinterestAuthorAttribute
 * @package AnyDownloader\PinterestDownloader\Model\Attribute
 */
final class PinterestAuthorAttribute extends AuthorAttribute
{
    /**
     * @param \stdClass $user
     * @return PinterestAuthorAttribute
     */
    public static function fromPinterestOriginPinnerStdObj(\stdClass $user): PinterestAuthorAttribute
    {
        $id = $user->id ?? '';
        $fullName = html_entity_decode($user->full_name) ?? '';
        $nickname = html_entity_decode($user->username) ?? '';
        try {
            $avatar = URL::fromString($user->image_medium_url);
        } catch (\Exception $e) {
            $avatar = null;
        }

        return new self($id, $nickname, $fullName, $avatar);
    }
}