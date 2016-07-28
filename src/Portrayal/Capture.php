<?php

namespace Portrayal;

use Symfony\Component\Process\ProcessBuilder;
use PhantomInstaller\PhantomBinary;

class Capture {

    /**
     * Captures a screenshot of the given url and stores it
     * in the defined storage path.
     *
     * @param  string  $url Full url including protocol
     * @param  string  $storagePath Path to store the image in
     * @param  string  $timeout Timeout in seconds
     * @param  string  $renderDelay The delay to wait after page load before taking screenshot
     * @param  string  $disableAnimations Whether to inject code to disable CSS and jQuery animations
     * @return string  Full path and filename for the screenshot
     */
    public function snap($url, $storagePath, $timeout = 30, $renderDelay = 350, $disableAnimations = false)
    {
        $outputFilename = $storagePath . '/' . sha1($url) . '.png';

        $process = $this->getPhantomProcess($url, $outputFilename, $renderDelay, $disableAnimations);
        
        $process->setTimeout($timeout)
            ->setWorkingDirectory(__DIR__)
            ->run();

        if (!$process->isSuccessful()) {
            throw new Exceptions\CaptureException($process->getOutput() . $process->getErrorOutput());
        }

        return $outputFilename;
    }

    /**
     * Get the PhantomJS process instance.
     *
     * @param  string  $url
     * @param  string  $outputFilename
     * @return \Symfony\Component\Process\Process
     */
    public function getPhantomProcess($url, $outputFilename, $renderDelay, $disableAnimations)
    {
        $phantom = PhantomBinary::BIN;

        return (new ProcessBuilder([$phantom, '--ignore-ssl-errors=true', '--ssl-protocol=tlsv1', 'rasterize.js', $url, $outputFilename, $renderDelay, $disableAnimations ? 'true' : 'false']))
                ->getProcess();
    }

}
