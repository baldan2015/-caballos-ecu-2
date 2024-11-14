<?
 if (file_exists("img/qcruz.png")) {
     $flagCruz="img/qcruz.png";
} else {
     
	$flagCruz=DIR_LEVEL_MOD_POE."img/qcruz.png";
}
switch($rows[17])
			{
				case '1':$status="<img src='".$flagCruz."' border=0 width='16' height=14 alt='Falleci '> ";break;
				default: $status="&nbsp;";
			}
?>