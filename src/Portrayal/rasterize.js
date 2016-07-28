var fs = require('fs'),
	page = require('webpage').create(),
	system = require('system'),
	address, output, size, renderTimeout, disableAnimations;

page.settings.userAgent = 'Portrayal (https://github.com/minicodemonkey/portrayal) 1.1.1';

if (system.args.length < 3 || system.args.length > 6) {
	console.log('Usage: rasterize.js URL filename');
	phantom.exit();
} else {
	address = system.args[1];
	output = system.args[2];
	renderTimeout = system.args[3] || 350;
	disableAnimations = system.args[4] && system.args[4] === 'true';
	page.viewportSize = { width: 1280, height: 600 };
	page.onConsoleMessage = function(msg) { console.log(msg); };
	page.open(address, function (status) {
		if (status !== 'success') {
			console.log('Unable to load the address!');
			phantom.exit(1);
		} else {
			if (disableAnimations) {
				page.evaluate(function() {
					// Disable jQuery animations
					try {
						$.fx.off = true;
					} catch (e) {
						// Fail silently if jQuery is not present
					}

					// Disable CSS animations
					var disableAnimationStyles = '-webkit-transition: none !important;' +
						'-moz-transition: none !important;' +
						'-ms-transition: none !important;' +
						'-o-transition: none !important;' +
						'transition: none !important;'

					window.onload = function() {
						var animationStyles = document.createElement('style');
						animationStyles.type = 'text/css';
						animationStyles.innerHTML = '* {' + disableAnimationStyles + '}';
						document.head.appendChild(animationStyles);
					};
				});
			}

			window.setTimeout(function () {
				page.render(output);
				phantom.exit();
			}, renderTimeout);
		}
	});
}