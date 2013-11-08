<?php
namespace OAuth2Provider\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="OAuth2Provider\Model\Repository\OAuthUserRepository")
 * @ORM\Table(name="oauth_users")
 */
class OAuthUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=50, nullable=false)
     * @var string
     */
    protected $userId;

    /**
     * @ORM\ManyToMany(targetEntity="OAuth2Provider\Model\Entity\OAuthClient", mappedBy="userIds")
     */
    protected $clientIds;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     * @var string
     */
    protected $userName;

    /**
     * @ORM\Column(type="string", length=200, nullable=false)
     * @var string
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @var string
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @var string
     */
    protected $lastName;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var string
     */
    protected $created;

	public function __construct()
    {
        $this->clientIds = new ArrayCollection();
    }

    /**
     * @return the $userId
     */
    public function getUserId()
    {
        return $this->userId;
    }

	/**
     * @param string $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

	/**
     * @return the $clientIds
     */
    public function getClientIds()
    {
        return $this->clientIds;
    }

	/**
     * @param \Doctrine\Common\Collections\ArrayCollection $clientIds
     */
    public function setClientIds($clientIds)
    {
        $this->clientIds = $clientIds;
    }

	/**
     * @return the $userName
     */
    public function getUserName()
    {
        return $this->userName;
    }

	/**
     * @param string $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

	/**
     * @return the $password
     */
    public function getPassword()
    {
        return $this->password;
    }

	/**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

	/**
     * @return the $firstName
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

	/**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

	/**
     * @return the $lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }

	/**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

	/**
     * @return the $created
     */
    public function getCreated()
    {
        return $this->created;
    }

	/**
     * @param string $created
     */
    public function setCreated($created)
    {
        $this->created = "2013-NOV-12 12:21:12";
    }

}
