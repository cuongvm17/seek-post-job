<?php namespace Seek\Tests\Entities;

use DateTime;
use Seek\Factories\AdvertisementFactory;
use Seek\Tests\SeekTestCase;
use Seek\Enums\AdvertisementState;


class AdvertisementTest extends SeekTestCase
{
    public function testSetThirdParties()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $thirdParties = $advertisement->getThirdParties();

        $this->assertInstanceOf('Seek\ValueObjects\ThirdParties', $thirdParties);
        $this->assertEquals($data['thirdParties']['advertiserId'], $thirdParties->getAdvertiserId());
        $this->assertEquals($data['thirdParties']['agentId'], $thirdParties->getAgentId());
    }

    public function testSetAdvertisementType()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $advertisementType = $advertisement->getAdvertisementType();

        $this->assertInstanceOf('Seek\Enums\AdvertisementType', $advertisementType);
        $this->assertEquals($data['advertisementType'], $advertisementType->getValue());
    }

    public function testSetLocation()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $location = $advertisement->getLocation();

        $this->assertInstanceOf('Seek\ValueObjects\Location', $location);
        $this->assertEquals($data['location']['id'], $location->getId()->getValue());
        $this->assertEquals($data['location']['areaId'], $location->getAreaId()->getValue());
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Job title must be a string
     */
    public function testSetInvalidJobTitle()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $advertisement->setJobTitle(10);
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Job title cannot be empty
     */
    public function testSetInvalidJobTitle2()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $advertisement->setJobTitle('');
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Job title must be no more than 80 characters long
     */
    public function testSetInvalidJobTitle3()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $advertisement->setJobTitle(str_repeat('J', 81));
    }

    public function testSetJobTitle()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);

        $this->assertEquals($data['jobTitle'], $advertisement->getJobTitle());
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Job summary must be a string
     */
    public function testSetInvalidJobSummary()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $advertisement->setJobSummary(10);
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Job summary cannot be empty
     */
    public function testSetInvalidJobSummary2()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $advertisement->setJobSummary('');
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Job summary must be no more than 150 characters long
     */
    public function testSetInvalidJobSummary3()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $advertisement->setJobSummary(str_repeat('J', 151));
    }

    public function testSetJobSummary()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);

        $this->assertEquals($data['jobSummary'], $advertisement->getJobSummary());
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Advertisement details must be a string
     */
    public function testSetInvalidAdvertisementDetails()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $advertisement->setAdvertisementDetails([]);
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Advertisement details cannot be empty
     */
    public function testSetInvalidAdvertisementDetails2()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $advertisement->setAdvertisementDetails('');
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Advertisement details must be no more than 20000 characters long
     */
    public function testSetInvalidAdvertisementDetails3()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $advertisement->setAdvertisementDetails(str_repeat('J', 20001));
    }

    public function testSetAdvertisementDetails()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);

        $this->assertEquals($data['advertisementDetails'], $advertisement->getAdvertisementDetails());
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Search job title must be a string
     */
    public function testSetInvalidSearchJobTitle()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $advertisement->setSearchJobTitle(true);
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Search job title cannot be empty
     */
    public function testSetInvalidSearchJobTitle2()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $advertisement->setSearchJobTitle('');
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Search job title must be no more than 80 characters long
     */
    public function testSetInvalidSearchJobTitle3()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $advertisement->setSearchJobTitle(str_repeat('J', 81));
    }

    public function testSetSearchJobTitle()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);

        $this->assertEquals($data['searchJobTitle'], $advertisement->getSearchJobTitle());
    }

    public function testSetSubClassification()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $subClassification = $advertisement->getSubClassification();

        $this->assertInstanceOf('Seek\Enums\SubClassification', $subClassification);
        $this->assertEquals($data['subclassificationId'], $subClassification->getValue());
    }

    public function testSetWorkType()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $workType = $advertisement->getWorkType();

        $this->assertInstanceOf('Seek\Enums\WorkType', $workType);
        $this->assertEquals($data['workType'], $workType->getValue());
    }

    public function testSetSalary()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $salary = $advertisement->getSalary();

        $this->assertInstanceOf('Seek\ValueObjects\Salary', $salary);
        $this->assertEquals($data['salary']['type'], $salary->getType()->getValue());
        $this->assertEquals($data['salary']['minimum'], $salary->getMinimum());
        $this->assertEquals($data['salary']['maximum'], $salary->getMaximum());
        $this->assertEquals($data['salary']['details'], $salary->getDetails());
    }

    public function testSetContact()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $contact = $advertisement->getContact();

        $this->assertInstanceOf('Seek\ValueObjects\Contact', $contact);
        $this->assertEquals($data['contact']['name'], $contact->getName());
        $this->assertEquals($data['contact']['email'], $contact->getEmail());
        $this->assertEquals($data['contact']['phone'], $contact->getPhone());
    }

    public function testSetVideo()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $video = $advertisement->getVideo();

        $this->assertInstanceOf('Seek\ValueObjects\Video', $video);
        $this->assertEquals($data['video']['url'], $video->getUrl());
        $this->assertEquals($data['video']['position'], $video->getPosition()->getValue());
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Application email format is invalid
     */
    public function testSetInvalidApplicationEmail()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $advertisement->setApplicationEmail('invalid email');
    }

    public function testSetApplicationEmail()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $applicationEmail = $advertisement->getApplicationEmail();

        $this->assertSame($data['applicationEmail'], $applicationEmail);

        $advertisement->setApplicationEmail(null);

        $this->assertSame(null, $advertisement->getApplicationEmail());
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Application form URL format is invalid
     */
    public function testSetInvalidApplicationFormUrl()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $advertisement->setApplicationFormUrl('invalid url');
    }

    public function testSetApplicationFormUrl()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);

        $this->assertSame($data['applicationFormUrl'], $advertisement->getApplicationFormUrl());

        $advertisement->setApplicationFormUrl(null);

        $this->assertSame(null, $advertisement->getApplicationFormUrl());
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage End application URL format is invalid
     */
    public function testSetInvalidEndApplicationUrl()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $advertisement->setEndApplicationUrl('invalid url');
    }

    public function testSetEndApplicationUrl()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);

        $this->assertSame($data['endApplicationUrl'], $advertisement->getEndApplicationUrl());

        $advertisement->setEndApplicationUrl(null);

        $this->assertSame(null, $advertisement->getEndApplicationUrl());
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Screen id must be an integer
     */
    public function testSetInvalidScreenId()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $advertisement->setScreenId('invalid ID');
    }

    public function testSetScreenId()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);

        $this->assertSame($data['screenId'], $advertisement->getScreenId());

        $advertisement->setScreenId(null);

        $this->assertSame(null, $advertisement->getScreenId());
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Job reference must be a string
     */
    public function testSetInvalidJobReference()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $advertisement->setJobReference([]);
    }

    public function testSetJobReference()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);

        $this->assertSame($data['jobReference'], $advertisement->getJobReference());

        $advertisement->setJobReference(null);

        $this->assertSame(null, $advertisement->getJobReference());
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Agent job reference must be a string
     */
    public function testSetInvalidAgentJobReference()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $advertisement->setAgentJobReference([]);
    }

    public function testSetAgentJobReference()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);

        $this->assertSame($data['agentJobReference'], $advertisement->getAgentJobReference());

        $advertisement->setAgentJobReference(null);

        $this->assertSame(null, $advertisement->getAgentJobReference());
    }

    public function testSetStandOut()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $standOut = $advertisement->getStandOut();

        $this->assertInstanceOf('Seek\ValueObjects\StandOut', $standOut);
        $this->assertEquals($data['standout']['logoId'], $standOut->getLogoId());
        $this->assertEquals($data['standout']['bullets'], $standOut->getBullets());
    }

    public function testSetTemplate()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $template = $advertisement->getTemplate();

        $this->assertInstanceOf('Seek\ValueObjects\Template', $template);
        $this->assertEquals($data['template']['id'], $template->getId());
        $this->assertCount(2, $template->getItems());
    }

    public function testSetRecruiter()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $recruiter = $advertisement->getRecruiter();

        $this->assertInstanceOf('Seek\ValueObjects\Recruiter', $recruiter);
        $this->assertEquals($data['recruiter']['fullName'], $recruiter->getFullName());
        $this->assertEquals($data['recruiter']['email'], $recruiter->getEmail());
        $this->assertEquals($data['recruiter']['teamName'], $recruiter->getTeamName());
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Residents only flag must be a boolean value
     */
    public function testSetInvalidResidentsOnly()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $advertisement->setResidentsOnly('');
    }

    public function testSetResidentsOnly()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);

        $this->assertSame(true, $advertisement->getResidentsOnly());

        $advertisement->setResidentsOnly(null);

        $this->assertSame(null, $advertisement->getResidentsOnly());
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Graduates flag must be a boolean value
     */
    public function testSetInvalidGraduate()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $advertisement->setGraduate(10);
    }

    public function testSetGraduate()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);

        $this->assertSame(false, $advertisement->getGraduate());

        $advertisement->setGraduate(null);

        $this->assertSame(null, $advertisement->getGraduate());
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Creation id must be a string
     */
    public function testSetInvalidCreationId()
    {
        $data = $this->getAdvertisementData();
        $data['creationId'] = 43.2;
        $this->createAdvertisement($data);
    }

    public function testSetCreationId()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);

        $this->assertEquals($data['creationId'], $advertisement->getCreationId());

        $advertisement->setCreationId(null);

        $this->assertEquals(null, $advertisement->getCreationId());
    }

    /**
     * @expectedException \Seek\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Id must be a string
     */
    public function testSetInvalidId()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $advertisement->setId([]);
    }

    public function testSetId()
    {
        $id = 'test-id';
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $advertisement->setId($id);

        $this->assertEquals($id, $advertisement->getId());

        $advertisement->setId(null);

        $this->assertNull($advertisement->getId());
    }

    public function testSetExpiryDate()
    {
        $dateTime = new DateTime();
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $advertisement->setExpiryDate($dateTime);

        $this->assertSame($dateTime, $advertisement->getExpiryDate());

        $advertisement->setId(null);

        $this->assertNull($advertisement->getId());
    }

    public function testSetExpiryDateFromString()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $advertisement->setExpiryDateFromString('2016-11-06T21:19:00Z');

        $this->assertEquals('2016-11-06 21:19:00', $advertisement->getExpiryDate()->format('Y-m-d H:i:s'));
    }

    public function testSetState()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);
        $advertisement->setState(AdvertisementState::get('Expired'));
        $state =$advertisement->getState();

        $this->assertInstanceOf('Seek\Enums\AdvertisementState', $state);
        $this->assertEquals('Expired', $state->getValue());
    }

    public function testGetArray()
    {
        $data = $this->getAdvertisementData();
        $advertisement = $this->createAdvertisement($data);

        $this->assertEquals($data, $advertisement->getArray());
    }

    private function createAdvertisement($data)
    {
        return AdvertisementFactory::createFromArray($data);
    }

    private function getAdvertisementData()
    {
        return json_decode(file_get_contents(__DIR__ . '/../Resources/Advertisement.json'), true);
    }
}
