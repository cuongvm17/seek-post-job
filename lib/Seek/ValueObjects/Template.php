<?php namespace Seek\ValueObjects;

use Seek\Exceptions\InvalidArgumentException;

/**
 * Template value object
 */
final class Template implements ValueObjectInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var TemplateItem[]
     */
    private $items = [];

    /**
     * @param string $id
     * @param TemplateItem[] $items
     * @throws InvalidArgumentException
     */
    public function __construct($id, array $items)
    {
        $this->setId($id);
        if (!empty($items)) {
            foreach ($items as $item) {
                $this->addItem($item);
            }
        }
    }

    /**
     * @param int $id
     * @throws InvalidArgumentException
     */
    private function setId($id)
    {
        if (!is_int($id)) {
            throw new InvalidArgumentException('Template id must be an integer value');
        }
        $this->id = $id;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param TemplateItem $item
     * @throws InvalidArgumentException
     */
    public function addItem(TemplateItem $item)
    {
        $this->items[] = $item;
    }

    /**
     * @return TemplateItem[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return array
     */
    public function getArray()
    {
        $items = $this->getItems();
        $itemsArray = [];
        if (!empty($items)) {
            foreach ($items as $item) {
                $itemsArray[] = $item->getArray();
            }
        }
        return [
            'id'    => $this->getId(),
            'items' => $itemsArray,
        ];
    }
}
