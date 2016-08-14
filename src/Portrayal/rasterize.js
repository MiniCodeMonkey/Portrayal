var fs = require('fs'),
	page = require('webpage').create(),
	system = require('system'),
	address, output, size, renderTimeout, disableAnimations;

if (system.args.length !== 8) {
	console.log('Usage: rasterize.js URL filename renderTimeout disableAnimations userAgent width height');
	phantom.exit(1);
} else {
	address = system.args[1];
	output = system.args[2];
	renderTimeout = system.args[3];
	disableAnimations = system.args[4] === 'true';
	page.settings.userAgent = system.args[5];
	page.viewportSize = { width: system.args[6], height: system.args[7] };
	//page.clipRect = { left: 0, top: 0, width: system.args[6], height: system.args[7] };
	page.zoomFactor = 1;
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
						'transition: none !important;' +
						'-webkit-animation: none !important;' +
						'-moz-animation: none !important;' +
						'-ms-animation: none !important;' +
						'-o-animation: none !important;' +
						'animation: none !important;';

					var animationStyles = document.createElement('style');
					animationStyles.type = 'text/css';
					animationStyles.innerHTML = '* {' + disableAnimationStyles + '}';
					document.head.appendChild(animationStyles);
				});
			}

			window.setTimeout(function () {
				page.render(output);
				phantom.exit();
			}, renderTimeout);
		}
	});
}