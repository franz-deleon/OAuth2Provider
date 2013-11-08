<?php
namespace OAuth2Provider\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="OAuth2Provider\Model\Repository\OAuthRefreshTokenRepository")
 * @ORM\Table(name="oauth_refresh_tokens")
 */
class OAuthRefreshToken
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=100, nullable=false)
     * @var string
     */
    protected $refreshToken;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     *
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
     * @ORM\Column(type="datetime", nullable=false)
     * @var unknown
     */
    protected $expires;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @var string
     */
    protected $scope;

}
