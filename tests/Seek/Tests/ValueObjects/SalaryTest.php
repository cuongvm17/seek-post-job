<?php namespace Seek\Tests\ValueObjects;

use Seek\Enums\SalaryType;
use Seek\Tests\SeekTestCase;
use Seek\ValueObjects\Salary;

class SalaryTest extends SeekTestCase
{
    public function testSetType()
    {
        $data = $this->getSalaryData();
        $salary = $this->createSalary($this->getSalaryData());
        $type = $salary->getType();

        $this->assertInstanceOf('Seek\Enums\SalaryType', $type);
        $this->assertEquals($data['type'], $type->getValue());
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Salary minimum amount must be a numeric value
     */
    public function testSetInvalidMinimum()
    {
        $data = $this->getSalaryData();
        $data['minimum'] = '3000';
        $this->createSalary($data);
    }

    public function testSetMinimum()
    {
        $data = $this->getSalaryData();
        $salary = $this->createSalary($data);
        $this->assertSame($data['minimum'], $salary->getMinimum());

        $data['minimum'] = (int)$data['minimum'];
        $salary = $this->createSalary($data);

        $this->assertSame($data['minimum'], $salary->getMinimum());
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Salary maximum amount must be a numeric value
     */
    public function testSetInvalidMaximum()
    {
        $data = $this->getSalaryData();
        $data['maximum'] = [];
        $this->createSalary($data);
    }

    public function testSetMaximum()
    {
        $data = $this->getSalaryData();
        $salary = $this->createSalary($data);
        $this->assertSame($data['maximum'], $salary->getMaximum());

        $data['maximum'] = (int)$data['maximum'];
        $salary = $this->createSalary($data);

        $this->assertSame($data['maximum'], $salary->getMaximum());
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Salary description must be a string
     */
    public function testSetInvalidDetails()
    {
        $data = $this->getSalaryData();
        $data['details'] = 10.5;
        $this->createSalary($data);
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Salary description must be no more than 50 characters long
     */
    public function testSetInvalidDetails2()
    {
        $data = $this->getSalaryData();
        $data['details'] = str_repeat('a', 51);
        $this->createSalary($data);
    }

    public function testSetDetails()
    {
        $data = $this->getSalaryData();
        $salary = $this->createSalary($data);

        $this->assertSame($data['details'], $salary->getDetails());

        $data['details'] = null;
        $salary = $this->createSalary($data);

        $this->assertNull($salary->getDetails());
    }

    public function testGetArray()
    {
        $data = $this->getSalaryData();
        $salary = $this->createSalary($data);

        $this->assertSame($data, $salary->getArray());
    }

    private function createSalary($data)
    {
        return new Salary(
            SalaryType::get($data['type']),
            $data['minimum'],
            $data['maximum'],
            $data['details']
        );
    }

    private function getSalaryData()
    {
        return [
            'type'    => 'AnnualPackage',
            'minimum' => 35000.0,
            'maximum' => 39999.0,
            'details' => 'Test details',
        ];
    }
}
