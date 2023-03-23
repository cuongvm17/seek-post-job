<?php namespace Seek\Tests\ValueObjects;

use Seek\Tests\SeekTestCase;
use Seek\ValueObjects\Template;
use Seek\ValueObjects\TemplateItem;

class TemplateTest extends SeekTestCase
{
    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Template id must be an integer value
     */
    public function testSetInvalidId()
    {
        $data = $this->getTemplateData();
        $data['id'] = '10';
        $this->createTemplate($data);
    }

    public function testSetId()
    {
        $data = $this->getTemplateData();
        $template = $this->createTemplate($data);

        $this->assertSame($data['id'], $template->getId());
    }

    public function testSetItems()
    {
        $data = $this->getTemplateData();
        $template = $this->createTemplate($data);

        $items = $template->getItems();

        $this->assertSame($data['items'][0]['name'], $items[0]->getName());
        $this->assertSame($data['items'][0]['value'], $items[0]->getValue());
        $this->assertSame($data['items'][1]['name'], $items[1]->getName());
        $this->assertSame($data['items'][1]['value'], $items[1]->getValue());

        $data = $this->getTemplateData();
        $data['items'] = [];
        $template = $this->createTemplate($data);

        $this->assertSame([], $template->getItems());
    }

    public function testGetArray()
    {
        $data = $this->getTemplateData();
        $template = $this->createTemplate($data);

        $this->assertSame($data, $template->getArray());
    }

    private function createTemplate($data)
    {
        $items = [];
        if (!empty($data['items'])) {
            foreach ($data['items'] as $item) {
                $items[] = new TemplateItem($item['name'], $item['value']);
            }
        }
        return new Template(
            $data['id'],
            $items
        );
    }

    private function getTemplateData()
    {
        return [
            'id'    => 99,
            'items' => [
                [
                    'name'  => 'field1',
                    'value' => 'Test Value',
                ],
                [
                    'name'  => 'field2',
                    'value' => 'Test Value 2',
                ],
            ],
        ];
    }
}
