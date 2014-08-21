<?php
/*
	Plugin Name: BBC Programmes Widget
	Plugin URI: http://www.fredbradley.co.uk/portfolio/bbc-programmes-widget
	Description: This will create a widget to put on your site that when given a BBC Programme ID as a variable it will show visitors, how long until the show (your show) will next be broadcast on the BBC, but also *if* your show (Radio or TV) is available on the BBC iPlayer it will list the available shows. If they are radio shows, they will automatically pop-out in the UKRadioplayer skin.
	Version: 1.0
	Author: Fred Bradley
	Author URI: http://www.fredbradley.co.uk
	License: A "Slug" license name e.g. GPL2
*/

/* 
	BBC Programmes Widget. 
    Copyright (C) 2013  Fred Bradley

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>
*/

/* Configs
 ****************/

date_default_timezone_set('Europe/London');






require_once(dirname(__FILE__)."/iplayer.class.php");
$iplayer = new BBCIPLAYER;

$programme_id = $_GET['id'];

?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-24018806-15']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> 
<script type='text/javascript' src='jquery.flexslider-min.js?ver=3.5.1'></script>

<script type="text/javascript">
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
		prevText: "Previous", //Set the text for the "previous" directionNav item
		nextText: "Next", //Set the text for the "next" directionNav item
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
</script>
<style>
body {
	margin: 0px;
}

div.image_container img {
	width: 100%;
	height: 112.5px;
}

div.image_container {
	width: 200px;
	height: 112.5px;
	margin: auto;
}

div.brandimage_container img {
	width: 100%;
	max-width: 90px;
}

div.brandimage_container {
	width: 90px;
	height: 10px;
	position: relative;
	top:-36px;
}

div.container {
	width:250px;
	margin: auto;
	background:-webkit-linear-gradient(rgba(113,22,93,0.62) 0%, #ffffff 100%);
	min-height: 800px;
	padding-top:20px;
}
div.container div.iplayer {
	width: 200px;
	margin: auto;
}
.iplayer ul {
	list-style: none;
	margin:0px;
	padding:0px;
}
.iplayer ul span.episode_title {
	font-weight: bold;
}
.iplayer ul.span.episode_description {
	clear: both;
}
.iplayer .flexslider .next {
	float: right;
}
.iplayer .flexslider .prev {
	float: left;
}
.spacer {
	margin:5px;
}


/*-----------------------------------------------------------------------------------*/
/* = Image Slider
/*-----------------------------------------------------------------------------------*/


/* FlexSlider necessary styles */
.flexslider {width: 100%; margin: 0; padding: 0;}
.flexslider .slides > li {display: none;} /* Hide the slides before the JS is loaded. Avoids image jumping */
.flexslider .slides img {max-width: 100%; display: block;}
.flex-pauseplay span {text-transform: capitalize;}

.slides:after {content: "."; display: block; clear: both; visibility: hidden; line-height: 0; height: 0;} 
html[xmlns] .slides {display: block;} 
* html .slides {height: 1%;}

.no-js .slides > li:first-child {display: block;}


</style>

<title><?php echo $iplayer->getName($programme_id); ?>'s BBC Programmes widget!</title>
<script>
jQuery(document).ready(function(){
var menuID = jQuery('#slides');
	findA = menuID.find('a');
	findA.click(function(event){
		_gaq.push(['_trackEvent', 'iPlayer Clicks', 'Pop out click', 'iPlayer Clicks']);
	});
	
});
</script>
</head>
<body>

<div class="container">
	<div class="iplayer">
		<div class="iplayer_item">
			<?php echo $iplayer->getUpcoming($programme_id); ?>
		</div>
		<div class="spacer">&nbsp;</div>
		<div class="iplayer_item">
			<?php echo $iplayer->getLast($programme_id); ?>
		</div>
	</div>
	<div style="margin:10px;padding-top:30px;font-style:italic;font-size:15px;color:#fff;">Intrigued? See example for <a href="bbcprogrammes.php?id=p012j2kn">Harriet Scott's BBC London 4am show...</a></div>
</div>
</body>
</html>