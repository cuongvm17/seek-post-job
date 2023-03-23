<?php namespace Seek\ValueObjects;

use Seek\Exceptions\InvalidArgumentException;

/**
 * Recruiter value object
 */
final class Recruiter implements ValueObjectInterface
{
    /**
     * The first name and surname separated by a space of recruiter who is responsible for the job ad and handling
     * the recruitment of the position.
     *
     * @var string
     */
    private $fullName;

    /**
     * The email address of recruiter who is responsible for the job ad and handling the recruitment of the position.
     *
     * @var string
     */
    private $email;

    /**
     * The team name of recruiter who is responsible for the job ad and handling the recruitment of the position is
     * part of.
     *
     * @var string
     */
    private $teamName;

    /**
     * @param string $fullName
     * @param string $email
     * @param string|null $teamName
     * @throws InvalidArgumentException
     */
    public function __construct($fullName, $email, $teamName = null)
    {
        $this->setFullName($fullName);
        $this->setEmail($email);
        $this->setTeamName($teamName);
    }

    /**
     * @param string $fullName
     * @throws InvalidArgumentException
     */
    private function setFullName($fullName)
    {
        if (!is_string($fullName)) {
            throw new InvalidArgumentException('Recruiter full name must be a string');
        }

        if (!$fullName) {
            throw new InvalidArgumentException('Recruiter full name cannot be empty');
        }
        $this->fullName = $fullName;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param string $email
     * @throws InvalidArgumentException
     */
    private function setEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Recruiter email format is invalid');
        }
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $teamName
     * @throws InvalidArgumentException
     */
    private function setTeamName($teamName)
    {
        if ($teamName !== null && !is_string($teamName)) {
            throw new InvalidArgumentException('Recruiter team name must be a string');
        }

        $this->teamName = $teamName;
    }

    /**
     * @return string
     */
    public function getTeamName()
    {
        return $this->teamName;
    }

    /**
     * @return array
     */
    public function getArray()
    {
        return [
            'fullName' => $this->getFullName(),
            'email'    => $this->getEmail(),
            'teamName' => $this->getTeamName(),
        ];
    }
}
