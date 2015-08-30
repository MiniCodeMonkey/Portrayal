[![Build Status](https://travis-ci.org/MiniCodeMonkey/Portrayal.png?branch=master)](https://travis-ci.org/minicodemonkey/Portrayal)

# Portrayal

This simple, self-contained library allows you to capture screenshots using PhantomJS.

The library is much inspired by [Laravel Cashier](https://github.com/laravel/cashier)'s PDF generation process.

## Installation

You can install this package through Composer. Edit your project's `composer.json` file to require `minicodemonkey/portrayal`.

```json
"require": {
	"minicodemonkey/portrayal": "1.*"
}
```

Now run `composer update` from the terminal, and you're good to go!

> You can also just run `composer require "minicodemonkey/portrayal:1.*"`

## Usage
```php
$capture = new \Portrayal\Capture;
$filename = $capture->snap('https://github.com/minicodemonkey/Portrayal', sys_get_temp_dir());

// $filename = /var/folders/6_/htvcfzcd4cb_w9z6bgpmnx5h0000gn/T/d0582362c2ffbf50ee119e504bb64fdc6bba5abd.png
```

You can adjust the timeout value by appending a third parameter to `snap(...)`. E.g. 15 second timeout: `$filename = $capture->snap('https://github.com/minicodemonkey/Portrayal', sys_get_temp_dir(), 15);`
