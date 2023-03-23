<?php namespace Seek\Tests\ValueObjects;

use Seek\Tests\SeekTestCase;
use Seek\ValueObjects\StandOut;

class StandOutTest extends SeekTestCase
{
    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Standout logo id must be an integer value
     */
    public function testSetInvalidLogoId()
    {
        $data = $this->getStandOutData();
        $data['logoId'] = '10';
        $this->createStandOut($data);
    }

    public function testSetLogoId()
    {
        $data = $this->getStandOutData();
        $standOut = $this->createStandOut($data);

        $this->assertSame($data['logoId'], $standOut->getLogoId());
    }

    /**
     * @expectedException \Seek\Exceptions\ValidationException
     * @expectedExceptionMessage Stand out ads can only have up to 3 bullet points
     */
    public function testSetInvalidBullets()
    {
        $data = $this->getStandOutData();
        $data['bullets'][] = 'Additional bullet';
        $this->createStandOut($data);
    }

    public function testSetBullets()
    {
        $data = $this->getStandOutData();
        $standOut = $this->createStandOut($data);

        $this->assertSame($data['bullets'], $standOut->getBullets());

        $data['bullets'] = [];
        $standOut = $this->createStandOut($data);

        $this->assertSame($data['bullets'], $standOut->getBullets());
    }

    public function testGetArray()
    {
        $data = $this->getStandOutData();
        $standOut = $this->createStandOut($data);

        $this->assertSame($data, $standOut->getArray());
    }

    private function createStandOut($data)
    {
        return new StandOut(
            $data['logoId'],
            $data['bullets']
        );
    }

    private function getStandOutData()
    {
        return [
            'logoId'  => 333,
            'bullets' => [
                'Flexi Hours',
                'Awesome Location',
                'Free Parking',
            ],
        ];
    }
}
