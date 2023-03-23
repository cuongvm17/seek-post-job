<?php namespace Seek\Tests\ValueObjects;

use Seek\Enums\Position;
use Seek\Tests\SeekTestCase;
use Seek\ValueObjects\Video;

class VideoTest extends SeekTestCase
{
    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Video URL format is invalid
     */
    public function testSetInvalidUrl()
    {
        $data = $this->getVideoData();
        $data['url'] = 'badurl';
        $this->createVideo($data);
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Video URL must be no more than 50 characters long
     */
    public function testSetInvalidUrl2()
    {
        $data = $this->getVideoData();
        $data['url'] = 'http://www.' . str_repeat('a', 241) . '.com';
        $this->createVideo($data);
    }

    public function testSetUrl()
    {
        $data = $this->getVideoData();
        $video = $this->createVideo($data);

        $this->assertSame($data['url'], $video->getUrl());
    }

    public function testSetPosition()
    {
        $data = $this->getVideoData();
        $video = $this->createVideo($data);
        $position = $video->getPosition();

        $this->assertInstanceOf('Seek\Enums\Position', $position);
        $this->assertEquals($data['position'], $video->getPosition()->getValue());

        $data['position'] = null;
        $video = $this->createVideo($data);
        $this->assertNull($video->getPosition());
    }

    public function testGetArray()
    {
        $data = $this->getVideoData();
        $video = $this->createVideo($data);

        $this->assertSame($data, $video->getArray());
    }

    private function createVideo($data)
    {
        return new Video(
            $data['url'],
            $data['position'] !== null ? Position::get($data['position']) : $data['position']
        );
    }

    private function getVideoData()
    {
        return [
            'url'      => 'https://www.youtube.com/embed/dVDk7PXNXB8',
            'position' => 'Below',
        ];
    }
}
