<?php namespace Seek\Api;

use Seek\Entities\Advertisement as AdvertisementEntity;
use Seek\Factories\AdvertisementFactory;

/**
 * Listing end point
 */
class Advertisement extends ApiAbstract
{
    /**
     * @param int|null $advertiserId
     * @return mixed
     */
    public function getAll($advertiserId = null)
    {
        return $this->get('/advertisement' . ($advertiserId !== null ? '?advertiserId=' . $advertiserId : ''));
    }

    /**
     * @param string $id
     * @return AdvertisementEntity
     */
    public function retrieve($id)
    {
        return AdvertisementFactory::createFromArray(
            $this->get('/advertisement/' . $id)
        );
    }

    /**
     * @param AdvertisementEntity $advertisement
     * @return AdvertisementEntity
     */
    public function create(AdvertisementEntity $advertisement)
    {
        return AdvertisementFactory::createFromArray(
            $this->post(
                '/advertisement',
                $advertisement->getArray(),
                [
                    'Content-Type' => 'application/vnd.seek.advertisement+json; version=1; charset=utf-8',
                ]
            )
        );
    }

    /**
     * @param AdvertisementEntity $advertisement
     * @return AdvertisementEntity
     */
    public function update(AdvertisementEntity $advertisement)
    {
        return AdvertisementFactory::createFromArray(
            $this->put(
                '/advertisement/' . $advertisement->getId(),
                $advertisement->getArray(),
                [
                    'Content-Type' => 'application/vnd.seek.advertisement+json; version=1; charset=utf-8',
                ]
            )
        );
    }

    /**
     * @param string $id
     * @return AdvertisementEntity
     */
    public function expire($id)
    {
        return AdvertisementFactory::createFromArray(
            $this->patch(
                '/advertisement/' . $id,
                [
                    [
                        'path'  => 'state',
                        'op'    => 'replace',
                        'value' => 'Expired',
                    ],
                ],
                [
                    'Content-Type' => 'application/vnd.seek.advertisement-patch+json; version=1; charset=utf-8',
                ]
            )
        );
    }
}
