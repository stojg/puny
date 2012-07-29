<?php require 'partials/header.php'; ?>

<div class="row">
	<div class="span8 offset2">
		<h1>Reading Cinema</h1>
	</div>
</div>

<div class="row">
	<div class="span8 offset2">
		<article>
			<header>
				<h2>
					Courteney Place
				</h2>	
			</header>
			<?php
# http://readingcinemas.co.nz/displaysession/showSessionTimeByLoctaion/Courtenay%20Centr/rating
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