<?php namespace Seek\Tests\ValueObjects;

use Seek\Tests\SeekTestCase;
use Seek\ValueObjects\TemplateItem;

class TemplateItemTest extends SeekTestCase
{
    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Template item name must be a string
     */
    public function testSetInvalidName()
    {
        $data = $this->getTemplateItemData();
        $data['name'] = [];
        $this->createTemplateItem($data);
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Template item name cannot be empty
     */
    public function testSetInvalidName2()
    {
        $data = $this->getTemplateItemData();
        $data['name'] = '';
        $this->createTemplateItem($data);
    }

    public function testSetName()
    {
        $data = $this->getTemplateItemData();
        $templateItem = $this->createTemplateItem($data);

        $this->assertSame($data['name'], $templateItem->getName());
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Template item value must be a string
     */
    public function testSetInvalidValue()
    {
        $data = $this->getTemplateItemData();
        $data['value'] = [];
        $this->createTemplateItem($data);
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Template item value cannot be empty
     */
    public function testSetInvalidValue2()
    {
        $data = $this->getTemplateItemData();
        $data['value'] = '';
        $this->createTemplateItem($data);
    }

    public function testSetValue()
    {
        $data = $this->getTemplateItemData();
        $templateItem = $this->createTemplateItem($data);

        $this->assertSame($data['value'], $templateItem->getValue());
    }

    public function testGetArray()
    {
        $data = $this->getTemplateItemData();
        $templateItem = $this->createTemplateItem($data);

        $this->assertSame($data, $templateItem->getArray());
    }

    private function createTemplateItem($data)
    {
        return new TemplateItem(
            $data['name'],
            $data['value']
        );
    }

    private function getTemplateItemData()
    {
        return [
            'name'  => 'field1',
            'value' => 'Test Value',
        ];
    }
}
