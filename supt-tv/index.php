<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Welcome To Provo City School District</title>
	<link rel="stylesheet" type="text/css" href="slick/slick.css" />
	<link rel="stylesheet" type="text/css" href="slick/slick-theme.css" />
	<link href="https://fonts.googleapis.com/css?family=Montserrat:600" rel="stylesheet">
	<link rel="stylesheet" href="style.css?v=1.0">
</head>

<body>
	<div id="wrapper">
		<header id="header">
			<img src="assets/pcsd-logo-website-header-x2.png" />
			<div class='time-frame'>
				<div id='date-part'></div>
				<div id='time-part'></div>
			</div>
		</header>
		<main>
			<section id="news">
				<?php

				$rss = new DOMDocument();
				$context = stream_context_create(array(
					'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
					),
				));
				libxml_set_streams_context($context);
				$rss->load('https://provo.edu/category/news/feed/');
				$feed = array();
				foreach ($rss->getElementsByTagName('item') as $node) {

					$htmlStr = $node->getElementsByTagName('description')->item(0)->nodeValue;
					// print_r($htmlStr);
					$html = new DOMDocument();
					@$html->loadHTML($htmlStr);
					//get the first image tag from the description HTML
					$img = $html->getElementsByTagName('img')->item(0)->getAttribute('src');

					$item = array(
						'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
						'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
						'image' => $img,
						'postcontent' => $node->getElementsByTagName('encoded')->item(0)->nodeValue,
						'author' => $node->getElementsByTagName('creator')->item(0)->nodeValue,
						'category' => $node->getElementsByTagName('category')->item(0)->nodeValue,
						'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue
					);
					// print_r($item);
					array_push($feed, $item);
				}
				// print_r($feed);
				$limit = 3;
				for ($x = 0; $x < $limit; $x++) {
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
						<img src="<?php echo $image ?>" />
						<h1><?php echo $title ?></h1>
						<ul>
							<li><img src="//globalassets.provo.edu/image/icons/calendar-ltblue.svg" alt="" /><?php echo $postdate; ?> /</li>
							<li><img src="//globalassets.provo.edu/image/icons/person-ltblue.svg" alt="" /><?php echo $author; ?> /</li>
							<li><img src="//globalassets.provo.edu/image/icons/hamburger-ltblue.svg" alt="" /><?php echo $category; ?></li>
						</ul>
						<div class="slide-text">

							<?php echo $removeAnchor ?>
						</div>
					</article>

				<?php
				}

				?>


			</section>

			<section id="sidebar">

			</section>



		</main>
		<footer class="read-more">
			<p>Please visit Provo.edu to read entire story.</p>
		</footer>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script type="text/javascript" src="slick/slick.min.js"></script>
		<script type="text/javascript" src="moment.js"></script>
		<script type="text/javascript" src="scripts.js"></script>
</body>

</html>