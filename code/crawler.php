<?php
    $pageCrawlerResult = '';

    function crawl_page($url, $depth = 5)
    {
        $result = '';
        static $seen = array();
        if (isset($seen[$url]) || $depth === 0) {
            return;
        }

        $seen[$url] = true;

        $dom = new DOMDocument('1.0');
        @$dom->loadHTMLFile($url);

        $anchors = $dom->getElementsByTagName('a');
        $hrefArray = [];

        foreach ($anchors as $element) {
			// Remove anchors
            $finalLink = explode("#", $element->getAttribute('href'));
            $link = $finalLink[0];

			// Add the protocol
			$adres = substr($link, 0, 7);
			$adresS = substr($link, 0, 8);

			$protocol = 'http://';
			$protocolS = 'https://';

			if($adres != $protocol && $adresS != $protocolS){
				//echo '<br>Brak protokolu<br><br>';
				$link = $url.$link;
			}

			// Push final link to array
            $hrefArray[] = $link;
        }
        $hrefArray = array_unique($hrefArray);

        foreach ($hrefArray as $href) {
            $result .= '<a href="' . $href . '">' . $href . '</a>';
        }

        return $result;
    }

    if(!empty($_GET['url'])){
        $url = $_GET['url'];
    }

    if(isset($url)) {
        if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
            echo 'Not a valid html!!!';
        } else {
            $pageCrawlerResult = crawl_page($url, 2);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Crawler</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div id="header">Crawler</div>
  	<div id="search">
        <form action="" type="GET">
            <div id="search-container">
                <input type="text" id="search-input" name="url" value="<?php if(!empty($_GET['url'])){ echo $url; } ?>">
            </div>
            <div id="submit-container">
                <input id="submit" type="submit" value="Crawl!">
            </div>
        </form>
  	</div>
    <div id="result">
        <?php
            echo $pageCrawlerResult;
        ?>
    </div>
  </body>
</html>
