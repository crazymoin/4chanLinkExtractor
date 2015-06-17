<?php
// you will need a php server to run this
// example use
// yourdomain.com/link.php?l=http://boards.4chan.org/gif/thread/7129066


if(isset($_GET['l']) ) {
	$a = $_GET['l'];
} else {
  echo 'oops! need a link man! user ?l=4chanlinkorsomething.html ';
  exit;
}

$html = file_get_contents($a);

//Create a new DOM document
$dom = new DOMDocument;

//Parse the HTML. The @ is used to suppress any parsing errors
//that will be thrown if the $html string isn't valid XHTML.
@$dom->loadHTML($html);

//Get all links. You could also use any other tag name here,
//like 'img' or 'table', to extract other tags.
$links = $dom->getElementsByTagName('a');

$datarr = array();

//Iterate over the extracted links and display their URLs
foreach ($links as $link){
  
  // check if the link is a 4chan media file or not
	if (preg_match("/i.4cdn.org/", $link->getAttribute('href'))) {
    
    // attach http: to all as few links have http and few haven't.
		$a = 'http:'.str_replace("http:", "", $link->getAttribute('href'));
		
		// Put all links to an array
		$datarr[] = $a;
	}
	
	
}

// sometime, you will find same file linked twice, so we put them in an array and remove all the duplicate link here
$ff = array_unique($datarr);
$num = 0;
foreach ($ff as $value) {
  
	echo $value.'<br />';
	
	// 4chan have a 4000 words limitation on every post, so easy way to deal with it!
	
	if($num > 40) { echo '<br /><br />'; $num = 0;}
	else { $num++;}
	
}
?>