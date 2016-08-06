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

### Adjust timeout
The time in seconds to wait on the phantomjs process before giving up. The default timeout is `30s`.

```php
$capture = new \Portrayal\Capture;
$filename = $capture->setTimeout(10)
    ->snap('https://github.com/minicodemonkey/Portrayal', sys_get_temp_dir());
```

### Adjust rendering delay
The time in seconds to wait taking the screenshot after the webpage has loaded. The default value is `0.35s` (`350ms`).

```php
$capture = new \Portrayal\Capture;
$filename = $capture->setRenderDelay(200)
    ->snap('https://github.com/minicodemonkey/Portrayal', sys_get_temp_dir());
```

### Disable animations
This will inject a couple of scripts to disable CSS3 animations as well as jQuery animations. Useful for making sure that subsequent screenshots will have the same state.

```php
$capture = new \Portrayal\Capture;
$filename = $capture->disableAnimations()
    ->snap('https://github.com/minicodemonkey/Portrayal', sys_get_temp_dir());
```

### Change user agent
This allows you to change the HTTP User-Agent header set by the phantomjs process.

```php
$capture = new \Portrayal\Capture;
$filename = $capture->setUserAgent('MyScreenShotApp 1.0')
    ->snap('https://github.com/minicodemonkey/Portrayal', sys_get_temp_dir());
```

### Change browser viewport dimensions
This will change the browser viewport. Please note that this might not necessarily correspond to the exact dimensions of the screenshot. Please see [https://github.com/ariya/phantomjs/issues/10619]() for additional details.

```php
$capture = new \Portrayal\Capture;
$filename = $capture->setViewPort($width = 320, $height = 480)
    ->snap('https://github.com/minicodemonkey/Portrayal', sys_get_temp_dir());
```
