<?php namespace Seek\Factories;

use Seek\Entities\Advertisement;
use Seek\Enums\AdvertisementType;
use Seek\Enums\Location as LocationCode;
use Seek\Enums\LocationArea;
use Seek\Enums\Position;
use Seek\Enums\SalaryType;
use Seek\Enums\SubClassification;
use Seek\Enums\WorkType;
use Seek\ValueObjects\Contact;
use Seek\ValueObjects\Location;
use Seek\ValueObjects\Recruiter;
use Seek\ValueObjects\Salary;
use Seek\ValueObjects\StandOut;
use Seek\ValueObjects\Template;
use Seek\ValueObjects\TemplateItem;
use Seek\ValueObjects\ThirdParties;
use Seek\ValueObjects\Video;

/**
 * Advertisement factory
 */
class AdvertisementFactory extends AbstractEntityFactory
{
    /**
     * @var array
     */
    private static $mappings = [
        'searchJobTitle'     => [
            'function' => 'setSearchJobTitle',
        ],
        'applicationEmail'   => [
            'function' => 'setApplicationEmail',
        ],
        'applicationFormUrl' => [
            'function' => 'setApplicationFormUrl',
        ],
        'endApplicationUrl'  => [
            'function' => 'setEndApplicationUrl',
        ],
        'screenId'           => [
            'function' => 'setScreenId',
        ],
        'jobReference'       => [
            'function' => 'setJobReference',
        ],
        'agentJobReference'  => [
            'function' => 'setAgentJobReference',
        ],
        'id'                 => [
            'function' => 'setId',
        ],
        'expiryDate'         => [
            'function' => 'setExpiryDateFromString',
        ],
        'state' => [
            'function' => 'setState',
            'type' => '\Seek\Enums\AdvertisementState'
        ],
    ];

    /**
     * @param array $data
     * @return Advertisement
     */
    public static function createFromArray(array $data)
    {
        $advertisement = new Advertisement(
            empty($data['creationId']) ? null : $data['creationId'],
            new ThirdParties(
                $data['thirdParties']['advertiserId'],
                !empty($data['thirdParties']['agentId']) ? $data['thirdParties']['agentId'] : null
            ),
            AdvertisementType::get($data['advertisementType']),
            $data['jobTitle'],
            new Location(
                LocationCode::get($data['location']['id']),
                !empty($data['location']['areaId']) ? LocationArea::get($data['location']['areaId']) : null
            ),
            SubClassification::get($data['subclassificationId']),
            WorkType::get($data['workType']),
            new Salary(
                SalaryType::get($data['salary']['type']),
                $data['salary']['minimum'],
                $data['salary']['maximum'],
                !empty($data['salary']['details']) ? $data['salary']['details'] : null
            ),
            $data['jobSummary'],
            $data['advertisementDetails'],
            new Recruiter(
                $data['recruiter']['fullName'],
                $data['recruiter']['email'],
                !empty($data['recruiter']['teamName']) ? $data['recruiter']['teamName'] : null
            )
        );
        self::populateEntity($advertisement, $data, self::$mappings);

        if (!empty($data['contact'])) {
            $advertisement->setContact(
                new Contact(
                    $data['contact']['name'],
                    !empty($data['contact']['phone']) ? $data['contact']['phone'] : null,
                    !empty($data['contact']['email']) ? $data['contact']['email'] : null
                )
            );
        }

        if (!empty($data['video'])) {
            $advertisement->setVideo(
                new Video(
                    $data['video']['url'],
                    !empty($data['video']['position']) ? Position::get($data['video']['position']) : null
                )
            );
        }

        if (!empty($data['template'])) {
            $items = [];
            if (!empty($data['template']['items'])) {
                foreach ($data['template']['items'] as $item) {
                    $items[] = new TemplateItem($item['name'], $item['value']);
                }
            }
            $advertisement->setTemplate(new Template($data['template']['id'], $items));
        }

        if (!empty($data['standout'])) {
            $advertisement->setStandOut(
                new StandOut(
                    !empty($data['standout']['logoId']) ? $data['standout']['logoId'] : null,
                    !empty($data['standout']['bullets']) ? $data['standout']['bullets'] : []
                )
            );
        }

        if (!empty($data['additionalProperties'])) {
            foreach ($data['additionalProperties'] as $property) {
                if ($property == 'ResidentsOnly') {
                    $advertisement->setResidentsOnly(true);
                } elseif ($property == 'Graduate') {
                    $advertisement->setGraduate(true);
                }
            }
        }

        return $advertisement;
    }
}
