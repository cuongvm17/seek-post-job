<?php namespace Seek\Tests\ValueObjects;

use Seek\Enums\Location as LocationCode;
use Seek\Enums\LocationArea;
use Seek\Tests\SeekTestCase;
use Seek\ValueObjects\Location;

class LocationTest extends SeekTestCase
{
    public function testSetId()
    {
        $location = $this->createLocation($this->getLocationData());
        $locationId = $location->getId();

        $this->assertInstanceOf('Seek\Enums\Location', $locationId);
        $this->assertEquals('Melbourne', $locationId->getValue());
    }

    public function testSetAreaId()
    {
        $data = $this->getLocationData();
        $location = $this->createLocation($data);

        $areaId = $location->getAreaId();

        $this->assertInstanceOf('Seek\Enums\LocationArea', $areaId);
        $this->assertEquals('BaysideSouthEasternSuburbs', $areaId->getValue());

        $data['areaId'] = null;
        $location = $this->createLocation($data);

        $this->assertNull($location->getAreaId());
    }


    public function testGetArray()
    {
        $data = $this->getLocationData();
        $location = $this->createLocation($data);

        $this->assertSame($data, $location->getArray());
    }

    private function createLocation($data)
    {
        return new Location(
            LocationCode::get($data['id']),
            $data['areaId'] !== null ? LocationArea::get($data['areaId']) : $data['areaId']
        );
    }

    private function getLocationData()
    {
        return [
            'id'     => 'Melbourne',
            'areaId' => 'BaysideSouthEasternSuburbs',
        ];
    }
}
