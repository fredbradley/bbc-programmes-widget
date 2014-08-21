// Google Analytics

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-24018806-15']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

jQuery(document).ready(function(){
var menuID = jQuery('#slides');
	findA = menuID.find('a');
	findA.click(function(event){
		_gaq.push(['_trackEvent', 'iPlayer Clicks', 'Pop out click', 'iPlayer Clicks']);
	});
});



// Flexslider
jQuery(function($){
	$(window).load(function() {

	//testimonials widget js
	$('#iplayer-slider').flexslider({
		animation: "slide", //Select your animation type (fade/slide)
		slideshow: true, //Should the slider animate automatically by default? (true/false)
		slideshowSpeed: 5000, //Set the speed of the slideshow cycling, in milliseconds
		animationDuration: 500, //Set the speed of animations, in milliseconds
		directionNav: true, //Create navigation for previous/next navigation? (true/false)
		controlNav: false, //Create navigation for paging control of each slide? (true/false)
		keyboardNav: true, //Allow for keyboard navigation using left/right keys (true/false)
		touchSwipe: true, //Touch swipe gestures for left/right slide navigation (true/false)
		prevText: "<i class='fa fa-chevron-left'></i>", //Set the text for the "previous" directionNav item
		nextText: "<i class='fa fa-chevron-right'></i>", //Set the text for the "next" directionNav item
		pausePlay: false, //Create pause/play dynamic element (true/false)
		pauseText: 'Pause', //Set the text for the "pause" pausePlay item
		playText: 'Play', //Set the text for the "play" pausePlay item
		randomize: false, //Randomize slide order on page load? (true/false)
		slideToStart: 0, //The slide that the slider should start on. Array notation (0 = first slide)
		animationLoop: true, //Should the animation loop? If false, directionNav will received disabled classes when at either end (true/false)
		pauseOnAction: true, //Pause the slideshow when interacting with control elements, highly recommended. (true/false)
		pauseOnHover: false //Pause the slideshow when hovering over slider, then resume when no longer hovering (true/false)
	});

	});
});

// 