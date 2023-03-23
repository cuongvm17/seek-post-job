<?php namespace Seek\Tests\ValueObjects;

use Seek\Tests\SeekTestCase;
use Seek\ValueObjects\Contact;

class ContactTest extends SeekTestCase
{
    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Contact name must be a string
     */
    public function testSetInvalidName()
    {
        $data = $this->getContactData();
        $data['name'] = [];
        $this->createContact($data);
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Contact name cannot be empty
     */
    public function testSetInvalidName2()
    {
        $data = $this->getContactData();
        $data['name'] = '';
        $this->createContact($data);
    }

    public function testSetName()
    {
        $data = $this->getContactData();
        $contact = $this->createContact($data);
        $this->assertSame($data['name'], $contact->getName());
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Contact phone must be a string
     */
    public function testSetInvalidPhone()
    {
        $data = $this->getContactData();
        $data['phone'] = 10;
        $this->createContact($data);
    }

    public function testSetPhone()
    {
        $data = $this->getContactData();
        $contact = $this->createContact($data);

        $this->assertSame($data['phone'], $contact->getPhone());

        $data['phone'] = null;
        $contact = $this->createContact($data);

        $this->assertNull($contact->getPhone());
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Contact email format is invalid
     */
    public function testSetInvalidEmail()
    {
        $data = $this->getContactData();
        $data['email'] = 'testemail.com';
        $this->createContact($data);
    }

    public function testSetEmail()
    {
        $data = $this->getContactData();
        $contact = $this->createContact($data);

        $this->assertSame($data['email'], $contact->getEmail());

        $data['email'] = null;
        $contact = $this->createContact($data);

        $this->assertNull($contact->getEmail());
    }

    public function testGetArray()
    {
        $data = $this->getContactData();
        $contact = $this->createContact($data);

        $this->assertSame($data, $contact->getArray());
    }

    private function createContact($data)
    {
        return new Contact(
            $data['name'],
            $data['phone'],
            $data['email']
        );
    }

    private function getContactData()
    {
        return [
            'name'  => 'Test Name',
            'phone' => '02 9999 8888',
            'email' => 'test@email.com',
        ];
    }
}
