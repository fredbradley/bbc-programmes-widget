<?php
/*
 * File: iplayer.class.php
 * Description: Custom built class bespoke to the BBC Programmes Widget for Wordpress.
 * Author: Fred Bradley <hello@fredbradley.co.uk>
 * More Info: http://www.fredbradley.co.uk/portfolio/bbc-programmes-widget
 * Want to learn more about the BBC APIs? See http://www.bbc.co.uk/programmes/developers
 *
 * Last Update: Version 1.0 (February 2013)
 */

// Usage of this file:
// You should not need to edit this file at all. 
// This file simply holds the functions which parse the JSON from the BBC website. 

class BBCIPLAYER {
	function getName($pid) {
		$json = "http://www.bbc.co.uk/programmes/".$pid."/episodes/upcoming.json";
		$curl = $this->file_get_contents_curl($json);
		$decode = json_decode($curl);
		if (isset($_GET['debug'])) {
			echo "<pre>";
			var_dump($decode);
			echo "</pre>";
		}
		$name = $decode->broadcasts{0}->programme->display_titles->title;
		return $name;
	}
	function getUpcoming($pid) {
		$json = "http://www.bbc.co.uk/programmes/".$pid."/episodes/upcoming.json";
		$curl = $this->file_get_contents_curl($json);
		$decode = json_decode($curl);
		if (isset($_GET['debug'])) {
			echo "<pre>";
			var_dump($decode);
			echo "</pre>";
		}
		
		if (empty($decode)) {
			return "<span class=\"error\">Programme ID was not recognised. (Perhaps you put in an 'episode' ID instead?)</span>";
		}
		if (!empty($decode->broadcasts)) {
			$episode = $decode->broadcasts{0};
			
		$key = $episode->service->id;

		$brandimage = "http://static.bbci.co.uk/branding/1.6.1/img/logos/masterbrands/".$key.".png";
		$programmeimage = "http://ichef.bbci.co.uk/images/ic/368x207/";
		$image = "<div class=\"image_container\"><img src=\"".$programmeimage.$episode->programme->image->pid.".jpg\" /></div>";
		$brandimage = "<div class=\"brandimage_container\"><img src=\"".$brandimage."\" /></div>";
		$image = $image.$brandimage;		
			
		//	$html = "<h3 class=\"iplayer_header\">Next On ".$episode->service->title."</h3>";
			$episodeid = $episode->programme->pid;
			
			$link = "http://www.bbc.co.uk/programmes/".$episodeid;
			
			//Check to see the programme is live now!
			$now = time();
			$start = strtotime($episode->start);
			$duration = $episode->duration;
			
			if ($start < $now) {
		//		$html = "<h3 class=\"iplayer_header\">Now live on ".$episode->service->title."</h3>";
				if (property_exists($episode->programme->programme, 'programme')) {
					$type = $episode->programme->ownership->service->type;
				} else {
					$type = $episode->programme->programme->ownership->service->type;
				}
				
				if ($type == "tv") {
					$link = "http://www.bbc.co.uk/iplayer/tv/".$key."/watchlive";
					$ahref = "<a href=\"".$link."\">";
					$start_time = "Watch Live";
				} elseif ($type == "radio") {
					$start_time = "Listen Live";
					$link = "http://www.bbc.co.uk/radio/player/".$key;
					$ahref = "<a onclick=\"javascript:void window.open('".$link."','1361118116552','width=380,height=665,status=1,resizable=1');return false;\" href=\"".$link."\">";
				}
			} else {
				$start_time = "Next live: ".$this->nicetime(strtotime($episode->start));
				$ahref = "<a onClick=\"_gaq.push(['_trackEvent', 'Upcoming', 'Click for Upcoming or Listen Live', 'Upcoming or Listen Live']);
\" href=\"".$link."\">";
			}
			$output = $html.$ahref.$image."</a>".$ahref.$start_time."</a>";
		} else {
			$output = $html."No future episodes of this programme are currently scheduled by the BBC!";
		}
	return $output;
	}

	function getLast($pid) {
		$json = "http://www.bbc.co.uk/programmes/".$pid."/episodes/player.json";
		$curl = $this->file_get_contents_curl($json);
		$decode = json_decode($curl);
		if (isset($_GET['debug'])) {
			echo "<pre>";
			var_dump($decode);
			echo "</pre>";
		}
		if (empty($decode)) {
			return "<span class=\"error\">Programme ID was not recognised. (Perhaps you put in an 'episode' ID instead?)</span>";
		}

		if (!empty($decode->episodes)) {
		//	$list = "<h3>Recent Shows</h3>";
			$list .= "<div id=\"iplayer-slider\" class=\"flexslider\">";
			$list .= "<ul class=\"slides\">";
			krsort($decode->episodes);
			foreach ($decode->episodes as $episode) {

				if (property_exists($episode->programme->programme, 'programme')) {
					$type = $episode->programme->ownership->service->type;
				} else {
					$type = $episode->programme->programme->ownership->service->type;
				}
					
				if ($type == "tv") {
					$availability = substr($episode->programme->media->availability, 0,-9);
				} else {
					$availability = substr($episode->programme->media->availability, 0, -10);
				}
				
				if ($type=="radio") {
					$link = "<a onclick=\"javascript:void window.open('http://www.bbc.co.uk/radio/player/".$episode->programme->pid."','1361118116552','width=380,height=665,status=1,resizable=1');return false;\" href=\"http://www.bbc.co.uk/radio/player/".$episode->programme->pid."\">";
				} else {
					$link = "<a href=\"http://www.bbc.co.uk/programmes/".$episode->programme->pid."\">";
				}	
				$list .= "<li><img src=\"http://ichef.bbci.co.uk/images/ic/368x207/".$episode->programme->image->pid.".jpg\" /><span class=\"episode_title\">".$link.$episode->programme->title."</a></span><br /><span class=\"episode_description\">".$episode->programme->short_synopsis." <em>(".$availability.")</em></span></li>";
			}
			$list .= "</ul></div>";
	               
	        return $list; 
		} else {
			return "<span class=\"error\">No episodes of this programme could be found on BBC iPlayer</span>";
		}
	}

	function file_get_contents_curl($url) {
		$ch = curl_init();
	
		curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	
		$data = curl_exec($ch);
		curl_close($ch);
	
	return $data;
	}

	/*
	 * Takes a unix timestamp and returns a relative time string such as "3 minutes ago",
	 *   "2 months from now", "1 year ago", etc
	 * The detailLevel parameter indicates the amount of detail. The examples above are
	 * with detail level 1. With detail level 2, the output might be like "3 minutes 20
	 *   seconds ago", "2 years 1 month from now", etc.
	 * With detail level 3, the output might be like "5 hours 3 minutes 20 seconds ago",
	 *   "2 years 1 month 2 weeks from now", etc.
	 */
	function nicetime($timestamp, $detailLevel = 1) {
		$periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
		$lengths = array("60", "60", "24", "7", "4.35", "12", "10");

		$now = time();

		// check validity of date
		if(empty($timestamp)) {
			return "Unknown time";
		}

		// is it future date or past date
		if($now > $timestamp) {
			$difference = $now - $timestamp;
			$tense = "ago";
		} else {
			$difference = $timestamp - $now;
			$tense = "from now";
			//$tense = "time";
		}

		if ($difference == 0) {
			return "1 second ago";
		}

		$remainders = array();

		for($j = 0; $j < count($lengths); $j++) {
			$remainders[$j] = floor(fmod($difference, $lengths[$j]));
			$difference = floor($difference / $lengths[$j]);
		}

		$difference = round($difference);

		$remainders[] = $difference;

		$string = "";

		for ($i = count($remainders) - 1; $i >= 0; $i--) {
			if ($remainders[$i]) {
				$string .= $remainders[$i] . " " . $periods[$i];

				if($remainders[$i] != 1) {
					$string .= "s";
				}

				$string .= " ";

				$detailLevel--;
			
				if ($detailLevel <= 0) {
					break;
				}
			}
		}

	return $string . $tense;
	}

} // End Class
?>
