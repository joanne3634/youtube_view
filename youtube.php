<?php
require_once 'log.php';

$new_dir_logs = './';
if (!file_exists($new_dir_logs)) {
	mkdir($new_dir_logs, 0777, true);
}

$head = array('WINNER - 센치해(SENTIMENTAL) M/V', 'WINNER - BABY BABY M/V', 'WINNER - 좋더라(I’M YOUNG) M/V', "MINO - '몸(BODY)' M/V", 'WINNER - 공허해(empty) M/V','WINNER - 컬러링(COLOR RING) M/V','TIMESTAMP');

$playlist_ID = 'PLihL1B00sa9QYGjcuUZszOg0gZpxdwb4s';
$API_key = 'AIzaSyB_AcV0klVjbNHGOiZhikikFZhfK2NmTII';
$maxResults = 10;

$ret = array();
$Playlist_JSON = file_get_contents("https://www.googleapis.com/youtube/v3/playlistItems?maxResults={$maxResults}&part=contentDetails&playlistId={$playlist_ID}&key={$API_key}");
$Playlist_JSON_Data = json_decode($Playlist_JSON,true);

foreach( $Playlist_JSON_Data['items'] as $key => $value ){
	$videoId = $value['contentDetails']['videoId'];
	$Video_JSON = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=statistics,snippet&id={$videoId}&key={$API_key}");
	$Video_JSON_Data = json_decode($Video_JSON,true);
	$video_title = $Video_JSON_Data['items'][0]['snippet']['title'];
	print($video_title." ");
	$views = $Video_JSON_Data['items'][0]['statistics']['viewCount'];
	print($views."\n");
	$ret[$video_title] = $views;
}
$ret['TIMESTAMP'] = date("Y-m-d H:i:s");
$filename = '/home/joanne3634/public_html/youtube_view/views.csv';
$log_file = new Log($filename, $head);
$log_file->write_csv($ret);
?>