<?php require 'partials/header.php'; ?>
<style>
	div.each-movie {
		clear:both;
	}
	div.each-movie a {
		color: #000;
		text-decoration: none;
	}
	div.movie-cover {
		float:left;
	}

	div.movie_rating {
		display: none;
	}
	div.each-row {
		font-size:10px;
		width: 600px;
	}
	div.movie-info h3 {
		color: #000 !important;
	}
	div.movie-info {
		padding-left: 150px;
	}
	div.gold-sched {
		background-color: gold;
	}

	div.titanxc-sched {
		background-color: #999;
	}
	.div 
</style>
<div class="row">
	<div class="span8 offset2">
		<h1>Reading Cinema</h1>
	</div>
</div>

<div class="row">
	<div class="span8 offset2">
		<article>
			<header>
				<h2>Courteney Place</h2>	
			</header>
			<?php
# http://readingcinemas.co.nz/displaysession/showSessionTimeByLoctaion/Courtenay%20Centr/
			// create a new cURL resource
$ch = curl_init();
// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, "http://readingcinemas.co.nz/displaysession/showSessionTimeByLoctaion/Courtenay%20Centr/rating");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_0) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11',
        'Accept-Language:en-US,en;q=0.8,sv;q=0.6'
));
// grab URL and pass it to the browser
$prup = curl_exec($ch);
// close cURL resource, and free up system resources
curl_close($ch);
curl_init();
			?>
		</article>
	</div>
</div>


<?php require 'partials/footer.php'; ?>