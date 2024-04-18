<?php 
$image = imagecreate(80,80);

if(isset($_GET['text']))
	$texte_a_ecrire = $_GET['text'];
else
	$texte_a_ecrire = "A";

$orange = imagecolorallocate($image, 255, 128, 0);
$bleu = imagecolorallocate($image, 0, 0, 255);
$bleuclair = imagecolorallocate($image, 156, 227, 254);
$noir = imagecolorallocate($image, 0, 0, 0);
$blanc = imagecolorallocate($image, 255, 255, 255);
$darkred = imagecolorallocate($image, 139,0,0);
$tomato = imagecolorallocate($image, 255,99,71);
$salmon = imagecolorallocate($image, 250,128,114);
$darkorange = imagecolorallocate($image, 255,140,0);
$darkgolden = imagecolorallocate($image, 184,134,11);
$darkkhaki = imagecolorallocate($image, 189,183,107);
$olivedrab = imagecolorallocate($image, 107,142,35);
$darkgreen = imagecolorallocate($image, 0,100,0);
$palegreen = imagecolorallocate($image, 152,251,152);
$turquoise = imagecolorallocate($image, 64,224,208);
$darkslategray = imagecolorallocate($image, 47,79,79);
$indigo = imagecolorallocate($image, 75,0,130);
$darkorchid = imagecolorallocate($image, 153,50,204);

if(isset($_GET['color'])){
	switch ($_GET['color']) {
		case 'orange':
			imagefill($image, 0, 0, $orange);
			break;

		case 'bleu':
			imagefill($image, 0, 0, $bleu);
			break;

		case 'bleuclair':
			imagefill($image, 0, 0, $bleuclair);
			break;

		case 'darkred':
			imagefill($image, 0, 0, $darkred);
			break;

		case 'tomato':
			imagefill($image, 0, 0, $tomato);
			break;

		case 'salmon':
			imagefill($image, 0, 0, $salmon);
			break;

		case 'darkorange':
			imagefill($image, 0, 0, $darkorange);
			break;

		case 'darkgolden':
			imagefill($image, 0, 0, $darkgolden);
			break;

		case 'darkkhaki':
			imagefill($image, 0, 0, $darkkhaki);
			break;

		case 'olivedrab':
			imagefill($image, 0, 0, $olivedrab);
			break;

		case 'darkgreen':
			imagefill($image, 0, 0, $darkgreen);
			break;

		case 'palegreen':
			imagefill($image, 0, 0, $palegreen);
			break;

		case 'turquoise':
			imagefill($image, 0, 0, $turquoise);
			break;

		case 'darkslategray':
			imagefill($image, 0, 0, $darkslategray);
			break;

		case 'indigo':
			imagefill($image, 0, 0, $indigo);
			break;

		case 'darkorchid':
			imagefill($image, 0, 0, $darkorchid);
			break;
		
		default:
			imagefill($image, 0, 0, $bleu);
			break;
	}
}else
	imagefill($image, 0, 0, $bleu);

imagettftext($image, 40, 0, 25, 60, $blanc, "./arial.ttf", $texte_a_ecrire);

header ("Content-type: image/png");
imagepng($image);
imagedestroy($image);
?>