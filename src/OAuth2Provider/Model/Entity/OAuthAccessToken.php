<?php
namespace OAuth2Provider\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="OAuth2Provider\Model\Repository\OAuthAccessTokenRepository")
 * @ORM\Table(name="oauth_access_tokens")
 */
class OAuthAccessToken
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", unique=true, nullable=false)
     */
    protected $accessToken;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     * @ORM\ManyToOne(targetEntity="OAuth2Provider\Model\Entity\OAuthClient", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="client_id", referencedColumnName="clientId")
     */
    protected $clientId;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     * @ORM\ManyToOne(targetEntity="OAuth2Provider\Model\Entity\OAuthUser", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="userId")
     */
    protected $userId;

    /**
     * @ORM\Column(type="datetime", length=50, nullable=false)
     */
    protected $expires;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $scope;

	/**
     * @return the $accessToken
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

	/**
     * @param field_type $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

	/**
     * @return the $clientId
     */
    public function getClientId()
    {
        return $this->clientId;
    }

	/**
     * @param field_type $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

	/**
     * @return the $userId
     */
    public function getUserId()
    {
        return $this->userId;
    }

	/**
     * @param field_type $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

	/**
     * @return the $expires
     */
    public function getExpires()
    {
        return $this->expires;
    }

	/**
     * @param field_type $expires
     */
    public function setExpires($expires)
    {
        $this->expires = $expires;
    }

	/**
     * @return the $scope
     */
    public function getScope()
    {
        return $this->scope;
    }

	/**
     * @param field_type $scope
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
    }

}
