<?php namespace Seek\Tests\ValueObjects;

use Seek\Tests\SeekTestCase;
use Seek\ValueObjects\ThirdParties;

class ThirdPartiesTest extends SeekTestCase
{
    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Advertisement id must be a string
     */
    public function testInvalidEmptyAdvertiserId()
    {
        $this->createThirdParties(
            [
                'advertiserId' => 10,
                'agentId'      => '',
            ]
        );
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Advertisement id cannot be empty
     */
    public function testInvalidEmptyAdvertiserId2()
    {
        $this->createThirdParties(
            [
                'advertiserId' => '',
                'agentId'      => '',
            ]
        );
    }

    public function testAdvertiserId()
    {
        $data = $this->getThirdPartiesData();
        $thirdParties = $this->createThirdParties($data);
        $this->assertSame($data['advertiserId'], $thirdParties->getAdvertiserId());
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Agent id must be a string
     */
    public function testInvalidAgentId()
    {
        $this->createThirdParties(
            [
                'advertiserId' => 'test id',
                'agentId'      => 10,
            ]
        );
    }

    public function testAgentId()
    {
        $data = $this->getThirdPartiesData();
        $thirdParties = $this->createThirdParties($data);

        $this->assertSame($data['agentId'], $thirdParties->getAgentId());

        $data['agentId'] = null;
        $thirdParties = $this->createThirdParties($data);

        $this->assertSame($data['agentId'], $thirdParties->getAgentId());
    }

    public function testGetArray()
    {
        $data = $this->getThirdPartiesData();
        $thirdParties = $this->createThirdParties($data);

        $this->assertSame($data, $thirdParties->getArray());

        unset($data['agentId']);
        $thirdParties = $this->createThirdParties($data);

        $this->assertSame($data, $thirdParties->getArray());
    }

    private function createThirdParties($data)
    {
        return new ThirdParties(
            $data['advertiserId'],
            isset($data['agentId']) ? $data['agentId'] : null
        );
    }

    private function getThirdPartiesData()
    {
        return [
            'advertiserId' => 'test string',
            'agentId'      => 'test agent id',
        ];
    }
}
