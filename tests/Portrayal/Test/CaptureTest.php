<?php

namespace Portrayal\Test;

use Portrayal\Capture;

class CaptureTest extends \PHPUnit_Framework_TestCase
{
	/**
     * Just a simple test to ensure that the snap function
     * is behaving correctly.
     */
    public function testCapture() {
        $capture = new Capture();
        $filename = $capture->snap('https://github.com/minicodemonkey/Portrayal', sys_get_temp_dir());

        $this->assertTrue(file_exists($filename));
        $this->assertGreaterThan(100, filesize($filename));

        // Clean up
        @unlink($filename);
    }

    public function testCaptureWithoutAnimations() {
        $capture = new Capture();
        $filename = $capture
            ->disableAnimations()
            ->snap('https://github.com/minicodemonkey/Portrayal', sys_get_temp_dir());

        $this->assertTrue($capture->getDisableAnimations());
        $this->assertTrue(file_exists($filename));
        $this->assertGreaterThan(100, filesize($filename));

        // Clean up
        @unlink($filename);
    }

    public function testCaptureWithCustomTimeout() {
        $capture = new Capture();
        $capture->setTimeout(120);

        $this->assertEquals(120, $capture->getTimeout());
    }

    public function testCaptureWithInvalidCustomTimeout() {
        $this->setExpectedException(\InvalidArgumentException::class);
        $capture = new Capture();
        $capture->setTimeout('not valid');
    }

    public function testCaptureWithCustomRenderDelay() {
        $capture = new Capture();
        $capture->setRenderDelay(2);

        $this->assertEquals(2, $capture->getRenderDelay());
    }

    public function testCaptureWithInvalidCustomRenderDelay() {
        $this->setExpectedException(\InvalidArgumentException::class);
        $capture = new Capture();
        $capture->setRenderDelay(-5);
    }

    public function testCaptureWithCustomUserAgent() {
        $capture = new Capture();
        $filename = $capture
            ->setUserAgent('test')
            ->snap('https://github.com/minicodemonkey/Portrayal', sys_get_temp_dir());

        $this->assertEquals('test', $capture->getUserAgent());
        $this->assertTrue(file_exists($filename));
        $this->assertGreaterThan(100, filesize($filename));

        // Clean up
        @unlink($filename);
    }

    public function testCaptureWithCustomViewPort() {
        $capture = new Capture();
        $filename = $capture
            ->setViewPort(1920, 1080)
            ->snap('https://github.com/minicodemonkey/Portrayal', sys_get_temp_dir());

        $this->assertEquals(1920, $capture->getViewPortWidth());
        $this->assertEquals(1080, $capture->getViewPortHeight());
        $this->assertTrue(file_exists($filename));

        list($imageWidth, $imageHeight) = getimagesize($filename);
        $this->assertEquals(1920, $imageWidth);
        $this->assertGreaterThan(500, $imageHeight); // Height is dynamic based on the page

        // Clean up
        @unlink($filename);
    }

    public function testCaptureInvalidUrl() {
        $this->setExpectedException(\Portrayal\Exceptions\CaptureException::class);
        $capture = new Capture();
        $filename = $capture->snap('http://somelongdomainnamethatdoesnotexistatall' . uniqid() . '.com', sys_get_temp_dir());
    }

}