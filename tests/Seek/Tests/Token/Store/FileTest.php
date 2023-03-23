<?php namespace Seek\Tests\Token\Store;

use Seek\Tests\SeekTestCase;
use Seek\Token\Store\File as FileStore;

class FileTest extends SeekTestCase
{
    public function testSet()
    {
        $value = 'test-token-123';
        $ttl = 3600;
        $fileStore = $this->createFileStore();
        $fileStore->set($value, $ttl);

        $this->assertEquals($value, $fileStore->get());

        $fileStore->expire();

        $this->assertEquals(null, $fileStore->get());

        $fileStore->set($value, 0);

        $this->assertEquals(null, $fileStore->get());
    }

    private function createFileStore()
    {
        return new FileStore();
    }
}
