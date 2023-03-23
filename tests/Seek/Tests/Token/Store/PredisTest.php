<?php namespace Seek\Tests\Token\Store;

use Predis\Client as PredisClient;
use Seek\Tests\SeekTestCase;
use Seek\Token\Store\Predis as PredisStore;

class PredisTest extends SeekTestCase
{
    public function testSet()
    {
        $value = 'test-token-123';
        $ttl = 3600;
        $predisClient = $this->createPredisClientMock();
        $predisClient->expects($this->once())
                     ->method('setex')
                     ->with('testKey', $ttl, $value)
                     ->will($this->returnValue(true));
        $predisClient->expects($this->once())
                     ->method('get')
                     ->will($this->returnValue($value));
        $predisStore = $this->createPredisStore($predisClient);

        $this->assertSame(true, $predisStore->set($value, $ttl));
        $this->assertEquals($value, $predisStore->get());
    }

    public function testExpire()
    {
        $value = 'test-token-123';
        $ttl = 3600;
        $predisClient = $this->createPredisClientMock();
        $predisClient->expects($this->once())
                     ->method('setex')
                     ->with('testKey', $ttl, $value)
                     ->will($this->returnValue(true));
        $predisClient->expects($this->at(1))
                     ->method('get')
                     ->will($this->returnValue($value));
        $predisClient->expects($this->at(2))
                     ->method('get')
                     ->will($this->returnValue(null));
        $predisClient->expects($this->once())
                     ->method('del')
                     ->with(['testKey'])
                     ->will($this->returnValue(true));
        $predisStore = $this->createPredisStore($predisClient);

        $this->assertSame(true, $predisStore->set($value, $ttl));
        $this->assertEquals($value, $predisStore->get());
        $this->assertSame(true, $predisStore->expire());
        $this->assertSame(null, $predisStore->get());
    }

    private function createPredisStore(PredisClient $predisClient)
    {
        return new PredisStore($predisClient, 'testKey');
    }

    private function createPredisClientMock()
    {
        return $this->getMockBuilder(PredisClient::class)
                    ->disableOriginalConstructor()
                    ->setMethods(['get', 'setex', 'del'])
                    ->getMock();
    }
}
