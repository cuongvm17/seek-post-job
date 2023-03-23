<?php namespace Seek\ValueObjects;

use Seek\Exceptions\InvalidArgumentException;

/**
 * Third parties value object
 */
final class ThirdParties implements ValueObjectInterface
{
    /**
     * Identity of the Client that this Advertisement is being posted for
     *
     * @var string
     */
    private $advertiserId;

    /**
     * Identity of the agent that is creating or updating an advertisement on behalf of an advertiser when the
     * agent is posting the advertisement using a third party uploader
     *
     * @var string
     */
    private $agentId;

    /**
     * @param string $advertiserId
     * @param string $agentId
     * @throws InvalidArgumentException
     */
    public function __construct($advertiserId, $agentId = null)
    {
        $this->setAdvertiserId($advertiserId);
        $this->setAgentId($agentId);
    }

    /**
     * @param string $advertiserId
     * @throws InvalidArgumentException
     */
    private function setAdvertiserId($advertiserId)
    {
        if (!is_string($advertiserId)) {
            throw new InvalidArgumentException('Advertisement id must be a string');
        }

        if (!$advertiserId) {
            throw new InvalidArgumentException('Advertisement id cannot be empty');
        }
        $this->advertiserId = $advertiserId;
    }

    /**
     * @return string
     */
    public function getAdvertiserId()
    {
        return $this->advertiserId;
    }

    /**
     * @param string $agentId
     * @throws InvalidArgumentException
     */
    private function setAgentId($agentId)
    {
        if ($agentId !== null && !is_string($agentId)) {
            throw new InvalidArgumentException('Agent id must be a string');
        }

        $this->agentId = $agentId;
    }

    /**
     * @return string
     */
    public function getAgentId()
    {
        return $this->agentId;
    }

    /**
     * @return array
     */
    public function getArray()
    {
        $data = [
            'advertiserId' => $this->getAdvertiserId(),
        ];
        $agentId = $this->getAgentId();
        if ($agentId !== null) {
            $data['agentId'] = $agentId;
        }
        return $data;
    }
}
