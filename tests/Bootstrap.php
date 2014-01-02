<?php
namespace OAuth2ProviderTests;

use Zend\Loader\AutoloaderFactory;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;
use Zend\Test\Util\ModuleLoader;
use RuntimeException;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);
define('APPLICATION_ENV', 'unittest');

/**
 * Test bootstrap, for setting up autoloading
 */
class Bootstrap
{
    protected static $serviceManager;

    public static function init($runBootstrap = false)
    {
        $zf2ModulePaths = array(dirname(dirname(__DIR__)));
        if (($path = static::findParentPath('vendor'))) {
            $zf2ModulePaths[] = $path;
        }
        if (($path = static::findParentPath('module')) !== $zf2ModulePaths[0]) {
            $zf2ModulePaths[] = $path;
        }

        static::initAutoloader();

        // use ModuleManager to load this module and it's dependencies
        $config = array(
            'module_listener_options' => array(
                'module_paths' => $zf2ModulePaths,
            ),
            'modules' => array(
                static::getModuleName(),
            )
        );

        $moduleloader = new ModuleLoader($config);
        $serviceManager = $moduleloader->getServiceManager();

        if ($runBootstrap == true) {
            $serviceManager->get('Application')->bootstrap();
        }

        static::$serviceManager = $serviceManager;
    }

    public static function chroot()
    {
        $rootPath = dirname(static::findParentPath('module'));
        chdir($rootPath);
    }

    /**
     * @param $initialize Reinitialize the bootstrap
     * @return \Zend\ServiceManager\ServiceManager
     */
    public static function getServiceManager($initialize = false, $runBootstrap = false)
    {
        if (true == $initialize) {
            static::init($runBootstrap);
        }
        return static::$serviceManager;
    }

    protected static function getModuleName()
    {
        $module = '';
        if (defined('self::MODULE')) {
            $module = self::MODULE;
        } else {
            if (__NAMESPACE__) {
                $module = explode("\\", __NAMESPACE__);
                $module = str_replace('Tests', '', array_pop($module));
            } else {
                throw new \Exception("Module name cannot be determined");
            }
        }
        return $module;
    }

    protected static function initAutoloader()
    {
        $vendorPath = static::findParentPath('vendor');

        $zf2Path = getenv('ZF2_PATH');
        if (!$zf2Path) {
            if (defined('ZF2_PATH')) {
                $zf2Path = ZF2_PATH;
            } elseif (is_dir($vendorPath . '/zendframework/zendframework/library')) {
                $zf2Path = $vendorPath . '/zendframework/zendframework/library';
            } elseif (is_dir($vendorPath . '/ZF2/library')) {
                $zf2Path = $vendorPath . '/ZF2/library';
            }
        }

        if (!$zf2Path) {
            throw new RuntimeException('Unable to load ZF2. Run `php composer.phar install` or define a ZF2_PATH environment variable.');
        }

        if (file_exists($vendorPath . '/autoload.php')) {
            include $vendorPath . '/autoload.php';
        }

        include $zf2Path . '/Zend/Loader/AutoloaderFactory.php';
        AutoloaderFactory::factory(array(
            'Zend\Loader\StandardAutoloader' => array(
                'autoregister_zf' => true,
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/' . __NAMESPACE__,
                ),
            ),
        ));
    }

    protected static function findParentPath($path)
    {
        $dir = __DIR__;
        $previousDir = '.';
        while (!is_dir($dir . '/' . $path)) {
            $dir = dirname($dir);
            if ($previousDir === $dir) return false;
            $previousDir = $dir;
        }
        return $dir . '/' . $path;
    }
}

//Bootstrap::chroot();
Bootstrap::init();
