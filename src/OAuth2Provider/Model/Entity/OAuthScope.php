<?php
namespace OAuth2Provider\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="OAuth2Provider\Model\Repository\OAuthScopeRepository")
 * @ORM\Table(name="oauth_scopes")
 */
class OAuthScope
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=100, nullable=false)
     * @var string
     */
    protected $type = 'supported';

    /**
     * @ORM\Column(type="string", length=200)
     * @var string
     */
    protected $scope;

    /**
     * @ORM\Column(type="string", length=200)
     * @ORM\ManyToOne(targetEntity="OAuth2Provider\Model\Entity\OAuthClient", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="client_id", referencedColumnName="clientId")
     * @var string
     */
    protected $clientId;
}
