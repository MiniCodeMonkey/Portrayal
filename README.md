[![Build Status](https://travis-ci.org/MiniCodeMonkey/Portrayal.png?branch=master)](https://travis-ci.org/minicodemonkey/Portrayal)

# Portrayal

This simple, self-contained library allows you to capture screenshots using PhantomJS.

## Installation

You can install this package through Composer. Edit your project's `composer.json` file to require `minicodemonkey/portrayal`.

```json
"require": {
	"minicodemonkey/portrayal": "1.*"
}
```

You will also need to add post-install and post-update scripts to `composer.json` as well as a `config` entry to set up the `phantomjs` binary dependency:

```json
"config": {
    "bin-dir": "bin"
},
"scripts": {
    "post-install-cmd": [
        "PhantomInstaller\\Installer::installPhantomJS"
    ],
    "post-update-cmd": [
        "PhantomInstaller\\Installer::installPhantomJS"
    ]
}
```

Now run `composer update` from the terminal, and you're good to go!

> For more information, check out [jakoch/phantomjs-installer](https://github.com/jakoch/phantomjs-installer)

## Usage
```php
$capture = new \Portrayal\Capture;
$filename = $capture->snap('https://github.com/minicodemonkey/Portrayal', sys_get_temp_dir());

// $filename = /var/folders/6_/htvcfzcd4cb_w9z6bgpmnx5h0000gn/T/d0582362c2ffbf50ee119e504bb64fdc6bba5abd.png
```

You can adjust the timeout value by appending a third parameter to `snap(...)`. E.g. 15 second timeout:

```php
$filename = $capture->snap('https://github.com/minicodemonkey/Portrayal', sys_get_temp_dir(), $timeout = 15);
```

You can also adjust the render delay (default: 350ms) as well as whether or not to disable animations.

```php
$filename = $capture->snap('https://github.com/minicodemonkey/Portrayal', sys_get_temp_dir(), $timeout = 15, $renderDelay = 350, $disableAnimations = true);
```
