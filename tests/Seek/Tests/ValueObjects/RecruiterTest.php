<?php namespace Seek\Tests\ValueObjects;

use Seek\Tests\SeekTestCase;
use Seek\ValueObjects\Recruiter;

class RecruiterTest extends SeekTestCase
{
    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Recruiter full name must be a string
     */
    public function testSetInvalidFullName()
    {
        $data = $this->getRecruiterData();
        $data['fullName'] = [];
        $this->createRecruiter($data);
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Recruiter full name cannot be empty
     */
    public function testSetInvalidFullName2()
    {
        $data = $this->getRecruiterData();
        $data['fullName'] = '';
        $this->createRecruiter($data);
    }

    public function testSetFullName()
    {
        $data = $this->getRecruiterData();
        $recruiter = $this->createRecruiter($data);

        $this->assertSame($data['fullName'], $recruiter->getFullName());
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Recruiter email format is invalid
     */
    public function testSetInvalidEmail()
    {
        $data = $this->getRecruiterData();
        $data['email'] = 'invalid email';
        $this->createRecruiter($data);
    }

    public function testSetEmail()
    {
        $data = $this->getRecruiterData();
        $recruiter = $this->createRecruiter($data);

        $this->assertSame($data['email'], $recruiter->getEmail());
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Recruiter team name must be a string
     */
    public function testSetInvalidTeamName()
    {
        $data = $this->getRecruiterData();
        $data['teamName'] = 10;
        $this->createRecruiter($data);
    }

    public function testSetTeamName()
    {
        $data = $this->getRecruiterData();
        $recruiter = $this->createRecruiter($data);

        $this->assertSame($data['teamName'], $recruiter->getTeamName());

        $data['teamName'] = null;
        $recruiter = $this->createRecruiter($data);
        $this->assertSame($data['teamName'], $recruiter->getTeamName());
    }

    public function testGetArray()
    {
        $data = $this->getRecruiterData();
        $recruiter = $this->createRecruiter($data);

        $this->assertSame($data, $recruiter->getArray());
    }

    private function createRecruiter($data)
    {
        return new Recruiter(
            $data['fullName'],
            $data['email'],
            $data['teamName']
        );
    }

    private function getRecruiterData()
    {
        return [
            'fullName' => 'John Citizen',
            'email'    => 'test@testdomain.com',
            'teamName' => 'Team A',
        ];
    }
}
