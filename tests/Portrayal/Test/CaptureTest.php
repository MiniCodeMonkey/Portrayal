<?php

namespace Portrayal\Test;

use Portrayal\Capture;
class ParserTest extends \PHPUnit_Framework_TestCase
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
        $filename = $capture->snap('https://github.com/minicodemonkey/Portrayal', sys_get_temp_dir(), 350, true);

        $this->assertTrue(file_exists($filename));
        $this->assertGreaterThan(100, filesize($filename));

        // Clean up
        @unlink($filename);
    }

    public function testCaptureInvalidUrl() {
        $this->setExpectedException(\Portrayal\Exceptions\CaptureException::class);
        $capture = new Capture();
        $filename = $capture->snap('http://somelongdomainnamethatdoesnotexistatall' . uniqid() . '.com', sys_get_temp_dir());
    }

}