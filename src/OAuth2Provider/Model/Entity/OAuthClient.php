<?php
namespace OAuth2Provider\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="OAuth2Provider\Model\Repository\OAuthClientRepository")
 * @ORM\Table(name="oauth_clients")
 */
class OAuthClient
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=50, nullable=false)
     * @var string
     */
    protected $clientId;

    /**
     * @ORM\ManyToMany(targetEntity="OAuth2Provider\Model\Entity\OAuthUser", inversedBy="clientIds")
     * @ORM\JoinTable(name="users_clients",
     *      joinColumns={@ORM\JoinColumn(name="client_id", referencedColumnName="clientId")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="userId")}
     * )
     */
    protected $userIds;

    /**
     * @ORM\Column(type="string", length=20, nullable=false)
     * @var string
     */
    protected $clientSecret;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    protected $redirectUri;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @var string
     */
    protected $grantTypes;

	public function __construct()
    {
        $this->userIds = new ArrayCollection();
    }

    /**
     * @return the $clientId
     */
    public function getClientId()
    {
        return $this->clientId;
    }

	/**
     * @param string $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

	/**
     * @return the $userIds
     */
    public function getUserIds()
    {
        return $this->userIds;
    }

	/**
     * @param \Doctrine\Common\Collections\ArrayCollection $userIds
     */
    public function setUserIds($userIds)
    {
        $this->userIds = $userIds;
    }

	/**
     * @return the $clientSecret
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

	/**
     * @param string $clientSecret
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

	/**
     * @return the $redirectUri
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

	/**
     * @param string $redirectUri
     */
    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;
    }

	/**
     * @return the $grantTypes
     */
    public function getGrantTypes()
    {
        return $this->grantTypes;
    }

	/**
     * @param string $grantTypes
     */
    public function setGrantTypes($grantTypes)
    {
        $this->grantTypes = $grantTypes;
    }
}
