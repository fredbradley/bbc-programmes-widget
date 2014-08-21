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
	require_once(dirname(__FILE__)."/setup.php"); 
	require_once(dirname(__FILE__)."/iplayer.class.php");
	$iplayer = new BBCIPLAYER;
	$programme_id = $_GET['id'];

?>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type='text/javascript' src='js/jquery.flexslider-min.js?ver=3.5.1'></script>
	<script type="text/javascript" src="js/scripts.js"></script>
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<!--<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">-->
	<link rel="stylesheet" href="css/styles.css">
	<title><?php echo $iplayer->getName($programme_id); ?>'s BBC Programmes widget!</title>
</head>
<body>

<div class="container">
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<div class="iplayer">
				<div class="iplayer_item">
					<?php echo $iplayer->getUpcoming($programme_id); ?>
				</div>
				<div class="spacer">&nbsp;</div>
				<div class="iplayer_item">
					<?php echo $iplayer->getLast($programme_id); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</body>
</html>
