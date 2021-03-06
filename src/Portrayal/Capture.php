<?php

namespace Portrayal;

use InvalidArgumentException;
use Symfony\Component\Process\ProcessBuilder;
use PhantomInstaller\PhantomBinary;

class Capture {

    private $timeout = 30;
    private $renderDelay = 0.35;
    private $disableAnimations = false;
    private $userAgent = 'Portrayal (https://github.com/minicodemonkey/portrayal) 2.0.0';
    private $viewPortWidth = 1280;
    private $viewPortHeight = 600;
    private $cookiesFile = null;

    /**
     * Captures a screenshot of the given url and stores it
     * in the defined storage path.
     *
     * @param  string  $url Full url including protocol
     * @param  string  $storagePath Path to store the image in
     */
    public function snap($url, $storagePath)
    {
        $outputFilename = $storagePath . '/' . sha1($url) . '.png';

        $process = $this->getPhantomProcess($url, $outputFilename);
        
        $process->setTimeout($this->timeout)
            ->setWorkingDirectory(__DIR__)
            ->run();

        if (!$process->isSuccessful()) {
            throw new Exceptions\CaptureException($process->getOutput() . $process->getErrorOutput());
        }

        return $outputFilename;
    }

    public function getTimeout() {
        return $this->timeout;
    }

    public function setTimeout($timeout) {
        if (!is_numeric($timeout) || $timeout <= 0) {
            throw new InvalidArgumentException();
        }

        $this->timeout = $timeout;

        return $this;
    }

    public function getRenderDelay() {
        return $this->renderDelay;
    }

    public function setRenderDelay($renderDelay) {
        if (!is_numeric($renderDelay) || $renderDelay <= 0) {
            throw new InvalidArgumentException();
        }

        $this->renderDelay = $renderDelay;

        return $this;
    }

    public function getDisableAnimations() {
        return $this->disableAnimations;
    }

    public function disableAnimations() {
        $this->disableAnimations = true;

        return $this;
    }

    public function getUserAgent() {
        return $this->userAgent;
    }

    public function setUserAgent($userAgent) {
        $this->userAgent = $userAgent;

        return $this;
    }

    public function getViewPortWidth() {
        return $this->viewPortWidth;
    }

    public function getViewPortHeight() {
        return $this->viewPortHeight;
    }

    public function setViewPort($width, $height) {
        if (!is_numeric($width) || $width <= 0 || !is_numeric($height) || $height <= 0) {
            throw new InvalidArgumentException();
        }

        $this->viewPortWidth = $width;
        $this->viewPortHeight = $height;

        return $this;
    }

    public function getCookiesFile() {
        return $this->cookiesFile;
    }

    public function setCookiesFile($cookiesFile) {
        $this->cookiesFile = $cookiesFile;

        return $this;
    }

    /**
     * Get the PhantomJS process instance.
     *
     * @param  string  $url
     * @param  string  $outputFilename
     * @return \Symfony\Component\Process\Process
     */
    public function getPhantomProcess($url, $outputFilename)
    {
        $phantom = PhantomBinary::BIN;

        $argumentsList = [];
        if ($this->cookiesFile) {
            $argumentsList[] = '--cookies-file=' . $this->cookiesFile;
        }

        $argumentsList[] = '--ignore-ssl-errors=true';
        $argumentsList[] = '--ssl-protocol=tlsv1';
        $argumentsList[] = 'rasterize.js';
        $argumentsList[] = $url;
        $argumentsList[] = $outputFilename;
        $argumentsList[] = $this->renderDelay * 1000;
        $argumentsList[] = $this->disableAnimations ? 'true' : 'false';
        $argumentsList[] = $this->userAgent;
        $argumentsList[] = $this->viewPortWidth;
        $argumentsList[] = $this->viewPortHeight;

        return (new ProcessBuilder(array_merge([$phantom], $argumentsList)))->getProcess();
    }

}
