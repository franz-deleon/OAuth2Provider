<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Controller\UserCredentialsController;
use OAuth2Provider\Version;

use OAuth2\Response as OAuth2Response;

use Zend\Http\Headers;
use Zend\Json\Json;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Zend\Stdlib\ArrayUtils;

/**
 * UserCredentialsController test case.
 */
class UserCredentialsControllerTest extends AbstractHttpControllerTestCase
{
    /**
     * @var UserCredentialsController
     */
    private $UserCredentialsController;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->setApplicationConfig(Bootstrap::getServiceManager()->get('ApplicationConfig'));
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->UserCredentialsController = null;
        parent::tearDown();
    }

    /**
     * Tests UserCredentialsController->authorizeAction()
     * @group test1
     */
    public function testAuthorizeAction()
    {
        $this->dispatch('/oauth2/' . Version::API_VERSION . '/authorize', 'POST');

        $r = Json::decode($this->getResponse()->getContent(), Json::TYPE_ARRAY);
        $this->assertNotEmpty($r['error']);
    }

    /**
     * Tests UserCredentialsController->requestAction()
     * @group test2
     */
    public function testRequestAction()
    {
        $result = array(
            "access_token" => "b43fde87a6e2cdbd001b09c27f68f2b60a201a06",
            "token_type" => "bearer",
            "scope" => "get",
            "access_expires_in" => 3600,
            "refresh_token" => "f934c943a5f5d5a3f2db8889b2d734fd7ca4aa64",
            "refresh_expires_in" => "952659",
        );

        $serverMock = $this->getMockBuilder('OAuth2Provider\Server')
            ->setMethods(array('handleTokenRequest'))
            ->getMock();
        $serverMock->expects($this->once())
            ->method('handleTokenRequest')
            ->will($this->returnValue(new OAuth2Response($result)));

        $mainSm = $this->getApplicationServiceLocator()->setAllowOverride(true);
        // having set to server.default provides some sort if integration test
        $mainSm->setService('oauth2provider.server.default', $serverMock);

        $this->dispatch('/oauth2/' . Version::API_VERSION . '/request', 'POST');

        $r = Json::decode($this->getResponse()->getContent(), Json::TYPE_ARRAY);
        $this->assertSame($result, $r);
    }

    /**
     * Tests UserCredentialsController->resourceAction()
     * @group test3
     */
    public function testResourceActionWhereRequestIsValid()
    {
        $serverMock = $this->getMockBuilder('OAuth2Provider\Server')
            ->setMethods(array('verifyResourceRequest', 'getResponse'))
            ->getMock();
        $serverMock->expects($this->once())
            ->method('verifyResourceRequest')
            ->with($this->isNull())
            ->will($this->returnValue(true));
        $serverMock->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(new OAuth2Response(array(
                'success' => true
            ))));

        $mainSm = $this->getApplicationServiceLocator()->setAllowOverride(true);
        // having set to server.default provides some sort if integration test
        $mainSm->setService('oauth2provider.server.default', $serverMock);

        $this->dispatch('/oauth2/' . Version::API_VERSION . '/resource', 'POST');

        $r = Json::decode($this->getResponse()->getContent(), Json::TYPE_ARRAY);
        $this->assertEquals('Access Token is Valid!', $r['message']);
    }

    /**
     * Tests UserCredentialsController->resourceAction()
     * @group test4
     */
    public function testResourceActionWhereRequestIsInValidWithErrorDescription()
    {
        $serverMock = $this->getMockBuilder('OAuth2Provider\Server')
            ->setMethods(array('verifyResourceRequest', 'getResponse'))
            ->getMock();
        $serverMock->expects($this->once())
            ->method('verifyResourceRequest')
            ->with($this->isNull())
            ->will($this->returnValue(false));
        $serverMock->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(new OAuth2Response(array(
                'error'   => 'some error',
                'error_description' => 'some message',
            ))));

        $mainSm = $this->getApplicationServiceLocator()->setAllowOverride(true);
        $mainSm->setService('oauth2provider.server.default', $serverMock);

        $this->dispatch('/oauth2/' . Version::API_VERSION . '/resource', 'POST');

        $r = Json::decode($this->getResponse()->getContent(), Json::TYPE_ARRAY);
        $this->assertFalse($r['success']);
        $this->assertEquals('some error', $r['error']);
        $this->assertEquals('some message', $r['message']);
    }

    /**
     * Tests UserCredentialsController->resourceAction()
     * @group test4
     */
    public function testResourceActionWhereRequestIsInValidWithErrorDefaultDescription()
    {
        $serverMock = $this->getMockBuilder('OAuth2Provider\Server')
            ->setMethods(array('verifyResourceRequest', 'getResponse'))
            ->getMock();
        $serverMock->expects($this->once())
            ->method('verifyResourceRequest')
            ->with($this->isNull())
            ->will($this->returnValue(false));
        $serverMock->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(new OAuth2Response(array(
                'nonexistingkeyplaceholder'   => 'zXxXz',
            ))));

        $mainSm = $this->getApplicationServiceLocator()->setAllowOverride(true);
        $mainSm->setService('oauth2provider.server.default', $serverMock);

        $this->dispatch('/oauth2/' . Version::API_VERSION . '/resource', 'POST');

        $r = Json::decode($this->getResponse()->getContent(), Json::TYPE_ARRAY);
        $this->assertFalse($r['success']);
        $this->assertEquals('Invalid Request', $r['error']);
        $this->assertEquals('Access Token is invalid', $r['message']);
    }
}
