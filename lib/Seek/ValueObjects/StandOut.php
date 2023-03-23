<?php namespace Seek\ValueObjects;

use Seek\Exceptions\InvalidArgumentException;
use Seek\Exceptions\ValidationException;

/**
 * Stand out value object
 */
final class StandOut implements ValueObjectInterface
{
    /**
     * @var integer
     */
    private $logoId;

    /**
     * @var string[]
     */
    private $bullets = [];

    /**
     * @param integer $logoId
     * @param string[] $bullets
     * @throws InvalidArgumentException
     * @throws ValidationException
     */
    public function __construct($logoId, array $bullets)
    {
        $this->setLogoId($logoId);

        if (sizeof($bullets) > 3) {
            throw new ValidationException('Stand out ads can only have up to 3 bullet points');
        }

        if (!empty($bullets)) {
            foreach ($bullets as $bullet) {
                $this->addBullet($bullet);
            }
        }
    }

    /**
     * @param int $logoId
     * @throws InvalidArgumentException
     */
    private function setLogoId($logoId)
    {
        if ($logoId !== null && !is_int($logoId)) {
            throw new InvalidArgumentException('Standout logo id must be an integer value');
        }
        $this->logoId = $logoId;
    }

    /**
     * @return integer
     */
    public function getLogoId()
    {
        return $this->logoId;
    }

    /**
     * @param string $bullet
     * @throws InvalidArgumentException
     */
    private function addBullet($bullet)
    {
        if (!is_string($bullet)) {
            throw new InvalidArgumentException('Stand out bullet point must be a string');
        }
        $this->bullets[] = $bullet;
    }

    /**
     * @return string[]
     */
    public function getBullets()
    {
        return $this->bullets;
    }

    /**
     * @return array
     */
    public function getArray()
    {
        return [
            'logoId'  => $this->getLogoId(),
            'bullets' => $this->getBullets(),
        ];
    }
}
