<div class="instagram-feed">
<?php
	function fetchData($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 20);
	$result = curl_exec($ch);
	curl_close($ch); 
	return $result;
	}
	$instagramToken = '';
	$user_id = '';
	$result = fetchData("https://api.instagram.com/v1/users/$user_id/media/recent/?access_token=$instagramToken&count=20");
	$result = json_decode($result, true);

	// echo '<pre>';
	// print_r($result);
	// echo '</pre>'; 

	foreach ($result['data'] as $post):
	// echo '<pre>'; print_r($post); echo '</pre>'; 

	// echo $post['link'];

	$instagramImage = $post['images']['standard_resolution']['url'];
	$imageLink = $post['link'];
?>
	<div class="instagram--item">
		<a href="<?php echo $imageLink; ?>" target="_blank">
			<img src="<?php echo $instagramImage; ?>"/>
		</a>
	</div>
<?php endforeach; ?>
</div>