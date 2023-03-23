<?php namespace Seek\ValueObjects;

use Seek\Enums\Position;
use Seek\Exceptions\InvalidArgumentException;

/**
 * Video value object
 */
final class Video implements ValueObjectInterface
{
    /**
     * Full 'embed' link including object tags as displayed on YouTube
     *
     * @var string
     */
    private $url;

    /**
     * @var Position
     */
    private $position;

    /**
     * @param string $url
     * @param Position|null $position
     * @throws InvalidArgumentException
     */
    public function __construct($url, Position $position = null)
    {
        $this->setUrl($url);
        $this->setPosition($position);
    }

    /**
     * @param string $url
     * @throws InvalidArgumentException
     */
    private function setUrl($url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Video URL format is invalid');
        }

        if (strlen($url) > 255) {
            throw new InvalidArgumentException('Video URL must be no more than 50 characters long');
        }
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param Position|null $position
     * @throws InvalidArgumentException
     */
    private function setPosition(Position $position = null)
    {
        $this->position = $position;
    }

    /**
     * @return Position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return array
     */
    public function getArray()
    {
        return [
            'url'      => $this->getUrl(),
            'position' => $this->getPosition()->getValue(),
        ];
    }
}
