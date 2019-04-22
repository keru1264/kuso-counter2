<?php
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    throw new Exception(sprintf('Please run "composer require google/apiclient:~2.0" in "%s"', __DIR__));
}
require_once __DIR__ . '/vendor/autoload.php';

if (empty($_GET['id'])){
    return require_once 'setup.php';
}
extract(GetParam($_GET));

$fonts = [
    '1' => ['\'Noto Serif\'' => 'url(\'fnt/noto-serif-v7-latin-regular.woff2\') format(\'woff2\')' ],
    '2' => ['\'Ubuntu Mono\'' => 'url(\'fnt/ubuntu-mono-v8-latin-regular.woff2\') format(\'woff2\')'],
    '3' => ['\'VT323\'' => 'url(\'fnt/vt323-v10-latin-regular.woff2\') format(\'woff2\')'],
    '4' => ['\'SHPinscher-Regular\'' => 'url(\'fnt/SHPinscher-Regular.woff2\') format(\'woff2\')'],
    '5' => ['\'33535gillsansmt\'' => 'url(\'fnt/33535gillsansmt.woff\') format(\'woff\')']
];

$shadows = sprintf('-0 -%1$s %2$s #000000, 0 -%1$s %2$s #000000, -0 %1$s %2$s #000000, 0 %1$s %2$s #000000, -%1$s -0 %2$s #000000,
	%1$s -0 %2$s #000000, -%1$s 0 %2$s #000000, %1$s 0 %2$s #000000, -1px -%1$s %2$s #000000, 1px -%1$s %2$s #000000,
	-1px %1$s %2$s #000000, 1px %1$s %2$s #000000, -%1$s -1px %2$s #000000, %1$s -1px %2$s #000000, -%1$s 1px %2$s #000000,
	%1$s 1px %2$s #000000, -2px -%1$s %2$s #000000, 2px -%1$s %2$s #000000, -2px %1$s %2$s #000000, 2px  %1$s %2$s #000000,
	-%1$s -2px %2$s #000000, %1$s -2px %2$s #000000, -%1$s 2px %2$s #000000, %1$s 2px %2$s #000000, -%1$s -%1$s %2$s #000000,
	%1$s -%1$s %2$s #000000, -%1$s %1$s %2$s #000000, %1$s %1$s %2$s #000000, -%1$s -%1$s %2$s #000000, %1$s -%1$s %2$s #000000,
	-%1$s %1$s %2$s #000000, %1$s %1$s %2$s #000000', $line, $thicc);
	
function GetParam(array $get):array {
    $ready_style = [
        'fontsize' => null,
        'color' => null,
        'bgcolor' => null,
        'line' => null,
        'thicc' => null,
        'align' => null
    ];
    $styles =[
        'fontsize' => ['chr' => false, 'min' => 1, 'max' => 480, 'def' => '79px'],
        'color' => ['chr' => true, 'def' => '#ffffff'],
        'bgcolor' => ['chr' => true, 'def' => '#00FF00'],
        'line' => ['chr' => false, 'min' => 0, 'max' => 6, 'def' => '6px'],
        'thicc' => ['chr' => false, 'min' => 0, 'max' => 6, 'def' => '3px'],
        'align' => ['chr' => true, 'def' => 'auto']
        ];

    foreach ($styles as $key => $value){
        if (isset($get[$key])){
            if ($value['chr']){
                $ready_style[$key] = $get[$key];
            }elseif (is_numeric($get[$key]) && $get[$key] >= $value['min'] && $get[$key] <= $value['max']){
                $ready_style[$key] = $get[$key]."px";
            }else{
                $ready_style[$key] = $value['def'];
            }
        }else{
            $ready_style[$key] = $value['def'];
        }
    }
    return $ready_style;
}

foreach ($fonts as $key => $value){
    if ($_GET['font'] == $key){
       $font = key($value);
       $fonturl = $value[$font];
       break;
    } else {
        $font = '\'Roboto\'';
        $fonturl = 'url(\'fnt/Roboto.woff2\') format(\'woff2\')';
    }
}

$client = new Google_Client();
$client->setApplicationName('kaloviy counter');
$client->setDeveloperKey('API_KEY');

$service = new Google_Service_YouTube($client);

try {
	$response = $service->videos->listVideos('liveStreamingDetails', ['id' => $_GET['id']]);
	if(!$response['items']) {
		$stat = '';
	} else {
		$stat = $response['items'][0]['liveStreamingDetails']['concurrentViewers'];
	}
}
catch(Exception $e) {
	$color = 'red';
	$bgcolor = 'black';
	$fontsize = '20px';
	$thicc = '1px';
	$line = '0px';
	$stat = 'daily quota was hit, try later';
}
?>
<html>
<title>kaloviy counter</title>
<head>

<script src="js/jquery-3.4.0.min.js"></script>
<script src="js/popper.min.js"></script>
<script type="text/javascript">
$(document).ready(function re() {
	$.ajax({url: location.href,
		success: function(data) {
			$("#re").html($(data).find('#stat'));
		}, 
		complete: function() {
			setTimeout(re, 30000);
		}
	})
})
</script>
<style>
@font-face {
	font-family: <?php echo $font; ?>;
	src: <?php echo $fonturl; ?>;
}
html {
	text-align: <?php echo $align; ?>;
	background: <?php echo $bgcolor; ?>;
	font-family: <?php echo $font; ?>;
	font-size: <?php echo $fontsize; ?>;
	text-shadow: <?php echo $shadows; ?>;
	
}
#re p {
	margin-top: 0px;
	margin-bottom: 0px;
	margin-left: 4px;
	color: <?php echo $color; ?>;"
</style>
</head>
<body>
<div id="re">
<p id="stat"><?php echo $stat; ?></p>
</div>
<noscript>
<p style="color: white; font-size: 16px;">turn on javascript to auto-update</p>
</noscript>
</body>
</html>
