<?php namespace Seek\ValueObjects;

use Seek\Enums\SalaryType;
use Seek\Exceptions\InvalidArgumentException;

/**
 * Salary value object
 */
final class Salary implements ValueObjectInterface
{
    /**
     * @var SalaryType
     */
    private $type;

    /**
     * Minimum salary of the salary range applicable to the job advertisement.
     *
     * @var float
     */
    private $minimum;

    /**
     * Maximum salary of the salary range applicable to the job advertisement.
     *
     * @var float
     */
    private $maximum;

    /**
     * Optional string used to specify salary information for display to candidates [limited to 50 characters].
     * No formatting tags are allowed e.g. < b >Bold< /b >, < br >, etc.
     *
     * @var string
     */
    private $details;

    /**
     * @param SalaryType $type
     * @param float $minimum
     * @param float $maximum
     * @param string|null $details
     */
    public function __construct(SalaryType $type, $minimum, $maximum, $details = null)
    {
        $this->setType($type);
        $this->setMinimum($minimum);
        $this->setMaximum($maximum);
        $this->setDetails($details);
    }

    /**
     * @param SalaryType $type
     */
    private function setType(SalaryType $type)
    {
        $this->type = $type;
    }

    /**
     * @return SalaryType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param float $minimum
     * @throws InvalidArgumentException
     */
    private function setMinimum($minimum)
    {
        if (!is_float($minimum) && !is_int($minimum)) {
            throw new InvalidArgumentException('Salary minimum amount must be a numeric value');
        }

        $this->minimum = $minimum;
    }

    /**
     * @return float
     */
    public function getMinimum()
    {
        return $this->minimum;
    }

    /**
     * @param float $maximum
     * @throws InvalidArgumentException
     */
    private function setMaximum($maximum)
    {
        if (!is_float($maximum) && !is_int($maximum)) {
            throw new InvalidArgumentException('Salary maximum amount must be a numeric value');
        }

        $this->maximum = $maximum;
    }

    /**
     * @return float
     */
    public function getMaximum()
    {
        return $this->maximum;
    }

    /**
     * @param string $details
     * @throws InvalidArgumentException
     */
    private function setDetails($details)
    {
        if ($details !== null && !is_string($details)) {
            throw new InvalidArgumentException('Salary description must be a string');
        }

        if (strlen($details) > 50) {
            throw new InvalidArgumentException('Salary description must be no more than 50 characters long');
        }
        $this->details = $details;
    }

    /**
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @return array
     */
    public function getArray()
    {
        return [
            'type'    => $this->getType()->getValue(),
            'minimum' => $this->getMinimum(),
            'maximum' => $this->getMaximum(),
            'details' => $this->getDetails(),
        ];
    }
}
