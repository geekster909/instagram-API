<?php
$access_token 	= ""; 
$user_id 	  	  = ""; 
$url 			      = "https://api.instagram.com/v1/users/" . $user_id . "/media/recent/?access_token=" . $access_token . "&count=25";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
$result = curl_exec($ch);
curl_close($ch);

$instagramJSON = json_decode( $result );
// echo '<pre>'; print_r($instagramJSON->data[0]); echo '</pre>'; die();
foreach ( $instagramJSON->data as $image )
{	
	if( property_exists($image, 'videos') ){
		$rows[] =  array(
    	"id"	=> $image->id,
    	"type"	=> $image->type,
	    "src"   => $image->videos->standard_resolution->url,
	    "link"	=> $image->link,
	    "text"  => $image->caption->text,
	    "likes" => $image->likes->count
	    );
	} else {
		$rows[] =  array(
	    	"id"	=> $image->id,
	    	"type"	=> $image->type,
	    	"src"   => $image->images->standard_resolution->url,
	    	"link"	=> $image->link,
		    "text"  => $image->caption->text,
		    "likes" => $image->likes->count
	    );
	}
}

$file_name = "recent.csv";
$fh = fopen($file_name, 'w');

foreach ( $rows as $row )
{
    fputcsv($fh, $row);
}

fclose($fh);
