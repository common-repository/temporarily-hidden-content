
(function($) {
	
	function temphcFixMarginBottom(element) {
		var marginBottom = $(element).css('margin-bottom');
		if (marginBottom === 0 || marginBottom === '0px') {
			var parents = $(element).parents();
			if (parents.length > 0) {
				var parent = parents[0];
				var childs = $(parent).find('> p');
				if (childs.length > 0) {
					var child = childs[0];
					var paragraphMarginBottom = $(child).css('margin-bottom');
					$(element).css('margin-bottom', paragraphMarginBottom);
				}
			}
		}
	}

	function temphcGetDatetime(timestamp, year, month, day, hour, minute, second) {
		var timestampDiff = new Date().getTime() - (timestamp * 1000);
		var date = new Date(Date.UTC(year, month, day, hour, minute, second)).getTime();
		date = (timestampDiff < 0) ? date - Math.abs(timestampDiff) : date + Math.abs(timestampDiff);
		return new Date(date);
	}

	$(function() {
		var temphcSelector = $(`.${temphc.class_main}`);
		if (temphcSelector.length > 0) {
			temphcFixMarginBottom(temphcSelector);
			temphcSelector.each(function() {
				var _self = this;
				var timestamp = $(_self).data('timestamp');
				var year = $(_self).data('year');
				var month = parseInt($(_self).data('month')) - 1;
				var day = $(_self).data('day');
				var hour = parseInt($(_self).data('hour'));
				var minute = $(_self).data('minute');
				var second = $(_self).data('second');
				$(_self).find(`.${temphc.class_prefix}-countdown`).temporarilyHiddenContent({
					timestamp: temphcGetDatetime(timestamp, year, month, day, hour, minute, second),
					callback: function(days, hours, minutes, seconds) {
						if (days > 0 || hours > 0 || minutes > 0 || seconds > 0) {
							var messageDay = days === 1 ? temphc.translations.day : temphc.translations.days;
							var messageHour = hours === 1 ? temphc.translations.hour : temphc.translations.hours;
							var messageMinute = minutes === 1 ? temphc.translations.minute : temphc.translations.minutes;
							var messageSecond = seconds === 1 ? temphc.translations.second : temphc.translations.seconds;
							var messageAnd = temphc.translations.and;
							var message = `${days} ${messageDay}, ${hours} ${messageHour}, ${minutes} ${messageMinute} ${messageAnd} ${seconds} ${messageSecond}`;
							$(_self).find(`.${temphc.class_prefix}-message`).first().html(message);
						} else {
							$(_self).find(`.${temphc.class_prefix}-countdown`).remove();
							$(_self).find(`.${temphc.class_prefix}-message`).remove();
							$(`<a href="#" class="${temphc.class_prefix}-button-refresh">`).html(temphc.translations.refreshButton).click(function(e) {
								e.preventDefault();
								location.reload();
								return false;
							}).appendTo(_self);
						}
					}
				});
			});
		}
	});

	$.fn.temporarilyHiddenContent = function(prop) {
		var _self = this;
		var options = $.extend({
			callback: function() {},
			timestamp: 0
		}, prop);
		var countdownCounters = {
			'days': 24 * 60 * 60,
			'hours': 60 * 60,
			'minutes': 60,
			'seconds': null
		};
		(function(element, options) {
			$.each(countdownCounters, function(key, value) {
				var digitsLength = 2;
				if (key === 'days') {
					left = Math.floor((options.timestamp - (new Date())) / 1000);
					var currentDigitsLength = Math.floor(left / (24 * 60 * 60));
					if (currentDigitsLength.toString().length > 2) {
						digitsLength = currentDigitsLength.toString().length;
					}
				}
				var countdownDigitsHtml = '';
				for (i = 0; i < digitsLength; i++) {
					countdownDigitsHtml += `<span><span class="${temphc.class_prefix}-countdown-static">0</span></span>`;
				}
				$(`<span class="${temphc.class_prefix}-countdown-${key}">`).html(countdownDigitsHtml).appendTo(element);
			});
		})(this, options);
		(function nextSecond() { 
			var timeLeft = Math.floor((options.timestamp - (new Date())) / 1000);
			timeLeft = timeLeft < 0 ? 0 : timeLeft;
			var currentValues = {};
			$.each(countdownCounters, function(key, value) {
				var number = value ? Math.floor(timeLeft / value) : timeLeft;
				currentValues[key] = number;
				changeDigits(_self, key, number);
				timeLeft = value ? 	timeLeft - (number * value) : timeLeft;
			});
			if ($(_self).parent().length > 0) {
				options.callback(currentValues['days'], currentValues['hours'], currentValues['minutes'], currentValues['seconds']);
				setTimeout(nextSecond, 1000);
			}
		})();
		function changeDigits(element, counterName, number) {
			var digitsLength = $(element).find(`.${temphc.class_prefix}-countdown-${counterName}`).find('> span').length;
			if (digitsLength > 0) {
				number = number.toString();
				numberLength = number.length;
				if (digitsLength > numberLength) {
					for (i = 0; i < (digitsLength - numberLength); i++) {
						number = '0' + number;
						numberLength++;
					}
				}
				$(element).find(`.${temphc.class_prefix}-countdown-${counterName}`).find('> span').each(function(key, value) {
					var numberDigit = number.substring(key, key + 1);
					var numberDigitElement = $(this).find('> span')
					if (!numberDigitElement.is(':animated') && numberDigitElement.html() != numberDigit) {
						var replacement = $('<span>').css({ top: '-1em', opacity: 0 }).html(numberDigit);
						numberDigitElement.before(replacement).removeClass(`.${temphc.class_prefix}-countdown-static`)
							.animate({ top: '1em', opacity: 0 }, 'fast', function() {
								numberDigitElement.remove();
							});
						replacement.delay(100).animate({ top: 0, opacity: 1 }, 'fast',function() {
							replacement.addClass(`.${temphc.class_prefix}-countdown-static`);
						});
					}
				});
			}
		}
		return _self;
	};

})(jQuery);
