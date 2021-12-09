<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Welcome To Provo City School District</title>
  <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
  <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
  <link href="https://fonts.googleapis.com/css?family=Montserrat:600" rel="stylesheet">
  <link rel="stylesheet" href="style.css?v=1.0">
</head>
<body>
	<header class="mainHeader">
		<img src="assets/pcsd-logo-website-header-x2.png" />
		 <div class='time-frame'>
			 <div id='date-part'></div>
			 <div id='time-part'></div>
		</div>
	</header>
	<div class="container">

		<div class="leftColumn">
			<section class="directory">

				<?php
					$cnmenuhandle = curl_init();
					$cnmenuurl = "https://provo.edu/directory_page/district-tv-kiosk/";
					// Set the url
					curl_setopt($cnmenuhandle, CURLOPT_URL, $cnmenuurl);
					// Set the result output to be a string.
					curl_setopt($cnmenuhandle, CURLOPT_RETURNTRANSFER, true);
					$cnmenuoutput = curl_exec($cnmenuhandle);
					// close the curl connection
					curl_close($cnmenuhandle);
					echo $cnmenuoutput;
				?>
			</section>
		</div>
		<div class="rightColumn">
				<section class="websiteNews">
					<?php
						$rss = new DOMDocument();
						$rss->load('https://provo.edu/feed/?cat=192,945');
						$feed = array();
						foreach ($rss->getElementsByTagName('item') as $node) {
							$htmlStr = $node->getElementsByTagName('description')->item(0)->nodeValue;
							$html = new DOMDocument();
							$html->loadHTML($htmlStr);
							//get the first image tag from the description HTML
							$img = $html->getElementsByTagName('img')->item(0)->getAttribute('src');
							$item = array (
								'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
								'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
								'image' => $img,
								'postcontent' => $node->getElementsByTagName('encoded')->item(0)->nodeValue,
								'author' => $node->getElementsByTagName('creator')->item(0)->nodeValue,
								'category' => $node->getElementsByTagName('category')->item(0)->nodeValue,
								'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue
								);
							array_push($feed, $item);
						}
						$limit = 3;
						for($x=0;$x<$limit;$x++) {
							$title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
							$image = $feed[$x]['image'];
							$author = $feed[$x]['author'];
							$postcontent = $feed[$x]['postcontent'];
							$category = $feed[$x]['category'];
							//$link = $feed[$x]['link'];
							$description = $feed[$x]['desc'];
							$removeImage = preg_replace("/<img[^>]+\>/i", "", $postcontent);
							$removeImage = preg_replace("/<video[^>]+\>/i", "", $removeImage);
							$removeAnchor = preg_replace('#<a.*?>.*?</a>#i', '', $removeImage);
							//$result = explode(' </img>',$description);
							$postdate = date('l F d, Y', strtotime($feed[$x]['date']));
							//echo '<p><strong>'.$title.'</strong><br />';
							//echo '<small><em>Posted on '.$date.'</em></small></p>';
							//echo '<p>'.$description.'</p>';
							?>
							<article class="slide">
								<h2><?php echo $title ?></h2>
								<ul>
									<li><img src="//globalassets.provo.edu/image/icons/calendar-ltblue.svg" alt="" /><?php echo $postdate; ?></li>
									<!-- <li><img src="//globalassets.provo.edu/image/icons/person-ltblue.svg" alt="" /><?php echo $author; ?></li> -->
									<!-- <li><img src="//globalassets.provo.edu/image/icons/hamburger-ltblue.svg" alt="" /><?php echo $category; ?></li> -->
								</ul>
								<img src="<?php echo $image ?>" />


								<!--
								<div class="slide-text">
									<p><?php echo $removeAnchor ?></p>
								</div>
								-->
							</article>

							<?php
						}
					?>

				</section>
				<section class="read-more">
					<p>Please visit Provo.edu to read story.</p>
				</section>
				<section class="meetingTimes">
					<!-- produced from calendar.php -->
				</section>
			</div><!-- end of leftColumn -->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="slick/slick.min.js"></script>
	<script type="text/javascript" src="moment.js"></script>
	<script type="text/javascript" src="scripts.js"></script>
</body>
</html>
