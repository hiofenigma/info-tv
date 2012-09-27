<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="refresh" content="1800" />
    <meta charset="UTF-8" /> 
	<script src='jquery-1.8.0.min.js'></script> 
	<script>
		$(document).ready(function(){
			clock();
			$('#headline').fadeIn('slow', function(){

				//load titles (right) 
				$.get('ajax.php', function(data){
					$('#news').delay(500).fadeOut(1000,function(){
						$(this).html(data).fadeIn(400);
						loadContent(0);
					});

				});


			});
			loadMain(1000, 0);
			setInterval('clock()',1000);
		});

		function loadMain(delay, c){
//			http://enigma.hiof.no/info-tv-article.php?aid=378
				 $.get('/info-tv-article.php?c='+c, function(data){
                                        $('#main').delay(delay).fadeOut(1000,function(){
                                                $(this).html(data).fadeIn(400);
                                                loadMain(5000, c+1);
                                        });

                                });

		}

		function loadContent(count){
			$.get('ajax.php?c='+count, function(data) {
				$('#news').delay(200000).fadeOut(1000,function(){
					$(this).html(data).fadeIn(400);
					count+=1;
					loadContent(count);
				});
			});
		}

		function clock(){
			$.get('clock.php', function(data) {
                                //$('#clock').fadeOut(500,function() {
				$('#clock').html(data);
                        });
		}
	</script>
	<link href="style.css" rel="stylesheet" />
</head>
<body>
<div id='logo'>
	<table style='margin:0px;padding:0px;border-collapse:collapse;width:100%;'>
		<tr>
			<td><div id='headline' class='startHidden'><h1>:info-tv</h1></div></td>
			<td><div id='clock'>00:00</div></td>
		</tr>
	</table>
</div>
<table style='width:100%;'>
	<tr>
		<td>
			<div id='main'></div>
		</td>
		<td style='width:50%'>
			<div id='news' style='width:100%;'>Velkommen til Enigma sin info-tv.</div>
		</td>
	</tr>
</table>
<?php

header('Content-type: text/html; charset=utf-8');
//echo "hello.."; 

?>
</body>
</html>
