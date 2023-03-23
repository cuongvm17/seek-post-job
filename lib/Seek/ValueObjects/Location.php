<?php namespace Seek\ValueObjects;

use Seek\Enums\Location as LocationCode;
use Seek\Enums\LocationArea;
use Seek\Exceptions\InvalidArgumentException;

/**
 * Location value object
 */
final class Location implements ValueObjectInterface
{
    /**
     * @var LocationCode
     */
    private $id;

    /**
     * @var LocationArea
     */
    private $areaId;

    /**
     * @param LocationCode $id
     * @param LocationArea|null $areaId
     * @throws InvalidArgumentException
     */
    public function __construct(LocationCode $id, LocationArea $areaId = null)
    {
        $this->setId($id);
        $this->setAreaId($areaId);
    }

    /**
     * @param LocationCode $id
     * @throws InvalidArgumentException
     */
    private function setId(LocationCode $id)
    {
        $this->id = $id;
    }

    /**
     * @return LocationCode
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param LocationArea $areaId
     * @throws InvalidArgumentException
     */
    private function setAreaId($areaId = null)
    {
        $this->areaId = $areaId;
    }

    /**
     * @return LocationArea
     */
    public function getAreaId()
    {
        return $this->areaId;
    }

    /**
     * @return array
     */
    public function getArray()
    {
        $areaId = $this->getAreaId();
        return [
            'id'     => $this->getId()->getValue(),
            'areaId' => $areaId === null ? $areaId : $areaId->getValue(),
        ];
    }
}
