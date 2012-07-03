$(document).ready(function($) {
	$('pre').addClass('prettyprint');
	//$('.banner').hide();
	$('textarea').autosize();
	$('.banner').getTwitterFeed("stojg", 10, false);
	prettyPrint();
});

(function($){
	$.fn.getTwitterFeed = function(userid, count, reply){


		var banner = $(this),
			feed = banner.find('.feed'),
			interval = 10000,
			speed = 1000,
			slideUpHeight = 18;


		var linkify = function(text){
			text = text.replace(/(https?:\/\/)([\w\-:;?&=+.%#\/]+)/gi, '<a href="$1$2">$2</a>').replace(/(^|\W)@(\w+)/g, '$1<a href="http://twitter.com/$2">@$2</a>').replace(/(^|\W)#(\w+)/g, '$1<a href="http://search.twitter.com/search?q=%23$2">#$2</a>');

			return text;
		};

		var relativeDate = function(date){
			if (navigator.appName === 'Microsoft Internet Explorer') return '';

			var unit = {
				now: 'Now',
				minute: '1 min',
				minutes: ' mins',
				hour: '1 hr',
				hours: ' hrs',
				day: 'Yesterday',
				days: ' days',
				week: '1 week',
				weeks: ' weeks'
			};

			var current = new Date(),
				tweet = new Date(date),
				diff = (((current.getTime() + (1 * 60000)) - tweet.getTime()) / 1000),
				day_diff = Math.floor(diff / 86400);
			
			if (day_diff === 0){
				if (diff < 60) return unit.now;
				else if (diff < 120) return unit.minute;
				else if (diff < 3600) return Math.floor(diff / 60) + unit.minutes;
				else if (diff < 7200) return unit.hour;
				else if (diff < 86400) return Math.floor(diff / 3600) + unit.hours;
				else return '';
			} else if (day_diff == 1) {
				return unit.day;
			} else if (day_diff < 7) {
				return day_diff + unit.days;
			} else if (day_diff == 7) {
				return unit.week;
			} else if (day_diff > 7) {
				return Math.ceil(day_diff / 7) + unit.weeks;
			} else {
				return '';
			}
		};

		if ($(window).width() > 600){

			var url = 'https://api.twitter.com/1/statuses/user_timeline/'+userid+'.json?count='+count+'&exclude_replies='+(reply ? '0' : '1')+'&trim_user=true&callback=?';
			
			$.getJSON(url, function(json){
				var length = json.length,
					fragment = document.createDocumentFragment(),
					counts = 0,
					timeout;

				for (var i=0; i<length; i++){
					var item = document.createElement('li');
					item.innerHTML = linkify(json[i].text) + ' <small>'+relativeDate(json[i].created_at)+'</small>';
					fragment.appendChild(item);
				}

				var play = function(){
					timeout = setTimeout(function(){
						feed.animate({top: '-='+slideUpHeight}, speed, function(){
							$(this).append($(this).children().eq(counts).clone());
							counts++;
							play();
						});
					}, interval);
				};

				var pause = function(){
					clearTimeout(timeout);
				};

				banner.on('mouseenter', pause).on('mouseleave', play)
				.children('.loading').hide().end()
				.children('.inner').show()
				.children('.feed').append(fragment);

				play();
			});
		}
	};
})(jQuery);

// Autosize 1.8 - jQuery plugin for textareas
// (c) 2011 Jack Moore - jacklmoore.com
// license: www.opensource.org/licenses/mit-license.php

(function ($, undefined) {
	var 
	hidden = 'hidden',
	copy = '<textarea style="position:absolute; top:-9999px; left:-9999px; right:auto; bottom:auto; box-sizing:content-box; word-wrap:break-word; height:0 !important; min-height:0 !important; overflow:hidden">',
	// line-height is omitted because IE7/IE8 doesn't return the correct value.
	copyStyle = [
		'fontFamily',
		'fontSize',
		'fontWeight',
		'fontStyle',
		'letterSpacing',
		'textTransform',
		'wordSpacing'
	],
	oninput = 'oninput',
	onpropertychange = 'onpropertychange',
	test = $(copy)[0];

	test.setAttribute(oninput, "return");

	if ($.isFunction(test[oninput]) || onpropertychange in test) {
		$.fn.autosize = function (className) {
			return this.each(function () {
				var 
				ta = this,
				$ta = $(ta),
				mirror,
				minHeight = $ta.height(),
				maxHeight = parseInt($ta.css('maxHeight'), 10),
				active,
				i = copyStyle.length,
				resize,
				boxOffset = $ta.css('box-sizing') === 'border-box' ? $ta.outerHeight() - $ta.height() : 0;

				if ($ta.data('mirror') || $ta.data('ismirror')) {
					// if autosize has already been applied, exit.
					// if autosize is being applied to a mirror element, exit.
					return;
				} else {
					mirror = $(copy).data('ismirror', true).addClass(className || 'autosizejs')[0];

					resize = $ta.css('resize') === 'none' ? 'none' : 'horizontal';

					$ta.data('mirror', $(mirror)).css({
						overflow: hidden, 
						overflowY: hidden, 
						wordWrap: 'break-word',
						resize: resize
					});
				}

				// Opera returns '-1px' when max-height is set to 'none'.
				maxHeight = maxHeight && maxHeight > 0 ? maxHeight : 9e4;

				// Using mainly bare JS in this function because it is going
				// to fire very often while typing, and needs to very efficient.
				function adjust() {
					var height, overflow;
					// the active flag keeps IE from tripping all over itself.  Otherwise
					// actions in the adjust function will cause IE to call adjust again.
					if (!active) {
						active = true;

						mirror.value = ta.value;

						mirror.style.overflowY = ta.style.overflowY;

						// Update the width in case the original textarea width has changed
						mirror.style.width = $ta.css('width');

						// Needed for IE to reliably return the correct scrollHeight
						mirror.scrollTop = 0;

						// Set a very high value for scrollTop to be sure the 
						// mirror is scrolled all the way to the bottom.
						mirror.scrollTop = 9e4;

						height = mirror.scrollTop;
						overflow = hidden;
						if (height > maxHeight) {
							height = maxHeight;
							overflow = 'scroll';
						} else if (height < minHeight) {
							height = minHeight;
						}
						ta.style.overflowY = overflow;

						ta.style.height = height + boxOffset + 'px';
						
						// This small timeout gives IE a chance to draw it's scrollbar
						// before adjust can be run again (prevents an infinite loop).
						setTimeout(function () {
							active = false;
						}, 1);
					}
				}

				// mirror is a duplicate textarea located off-screen that
				// is automatically updated to contain the same text as the 
				// original textarea.  mirror always has a height of 0.
				// This gives a cross-browser supported way getting the actual
				// height of the text, through the scrollTop property.
				while (i--) {
					mirror.style[copyStyle[i]] = $ta.css(copyStyle[i]);
				}

				$('body').append(mirror);

				if (onpropertychange in ta) {
					if (oninput in ta) {
						// Detects IE9.  IE9 does not fire onpropertychange or oninput for deletions,
						// so binding to onkeyup to catch most of those occassions.  There is no way that I
						// know of to detect something like 'cut' in IE9.
						ta[oninput] = ta.onkeyup = adjust;
					} else {
						// IE7 / IE8
						ta[onpropertychange] = adjust;
					}
				} else {
					// Modern Browsers
					ta[oninput] = adjust;
				}

				$(window).resize(adjust);

				// Allow for manual triggering if needed.
				$ta.bind('autosize', adjust);

				// Call adjust in case the textarea already contains text.
				adjust();
			});
		}; 
	} else {
		// Makes no changes for older browsers (FireFox3- and Safari4-)
		$.fn.autosize = function () {
			return this;
		};
	}

}(jQuery));