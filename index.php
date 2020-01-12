<?php
$data = trim((string) filter_input(INPUT_POST, 'data'));
if ($data !== "") {
	$date = date("Y-m-d,H:i:s");
	$addr = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : "-";
	$agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "-";
	$log = $date . "," . $data . "," . $addr . "," . $agent;
	error_log($log . "\r\n", 3, "./data.txt");
	print($log);
	exit;
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
	<title>GPSサンプル</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script type="text/javascript">
		function putGeo(lat, lng, acc, code) {
			$.ajax({
				type: "POST",
				url: ".",
				data: "data=" + decodeURIComponent(lat + "," + lng + "," + acc + "," + code),
				success: function(res) {
					alert(res);
				}
			});
		}

		function getGeo() {
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(
					geoSuccess, geoError, {
						enableHighAccuracy: true,
						timeout: 8000
					}
				);
			} else {
				putGeo("-", "-", "-", "-");
			}
		}

		function geoSuccess(pos) {
			putGeo(pos.coords.latitude, pos.coords.longitude, pos.coords.accuracy, 0);
		}

		function geoError(err) {
			putGeo("-", "-", "-", err.code);
		}
		$(document).ready(function() {
			$('#gps').on("click", getGeo);
		});
	</script>
</head>

<body>
	<input type="button" id="gps" value="GPS取得">
</body>

</html>