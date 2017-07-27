<?php

namespace yii2tech\tests\unit\html2pdf;

use yii\helpers\ArrayHelper;
use Yii;
use yii\helpers\FileHelper;

/**
 * Base class for the test cases.
 */
class TestCase extends \PHPUnit\Framework\TestCase
{
    public static $params;

    protected function setUp()
    {
        parent::setUp();
        $this->mockApplication();
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->destroyApplication();
        $this->removeTestFilePath();
    }

    /**
     * Returns a test configuration param from /data/config.php
     * @param  string $name params name
     * @param  mixed $default default value to use when param is not set.
     * @return mixed  the value of the configuration param
     */
    public static function getParam($name, $default = null)
    {
        if (static::$params === null) {
            static::$params = require(__DIR__ . '/data/config.php');
        }

        return isset(static::$params[$name]) ? static::$params[$name] : $default;
    }

    /**
     * Populates Yii::$app with a new application
     * The application will be destroyed on tearDown() automatically.
     * @param array $config The application configuration, if needed
     * @param string $appClass name of the application class to create
     */
    protected function mockApplication($config = [], $appClass = '\yii\console\Application')
    {
        new $appClass(ArrayHelper::merge([
            'id' => 'testapp',
            'basePath' => __DIR__,
            'vendorPath' => $this->getVendorPath(),
        ], $config));
    }

    /**
     * @return string vendor path
     */
    protected function getVendorPath()
    {
        return dirname(__DIR__) . '/vendor';
    }

    /**
     * Destroys application in Yii::$app by setting it to null.
     */
    protected function destroyApplication()
    {
        Yii::$app = null;
    }

    /**
     * @return string test file path
     */
    protected function getTestFilePath()
    {
        return Yii::getAlias('@runtime/html2pdf-test');
    }

    /**
     * Ensures test file path exists.
     * @return string test file path
     */
    protected function ensureTestFilePath()
    {
        $path = $this->getTestFilePath();
        FileHelper::createDirectory($path);
        return $path;
    }

    /**
     * Removes the test file path.
     */
    protected function removeTestFilePath()
    {
        $path = $this->getTestFilePath();
        FileHelper::removeDirectory($path);
    }
}
