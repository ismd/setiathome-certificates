<?php
date_default_timezone_set('GMT');
$image = createCert('ismd', '14 June 2011', '15,585', '13.47 quadrillion');

// Uncomment if you want to see certificate in browser
//header('Content-Type: image/png');
//imagepng($image);
// ... or this if you want to save it in file
imagepng($image, 'cert1.png');
imagedestroy($image);

function createCert($name, $date, $cobblestones, $operations) {
    $width = 900;
    $height = 650;

    $font = 'optima';

    $text = array(
        array(
            'text' => 'Certificate of Computation',
            'size' => 40,
            'top'  => 134,
        ),
        array(
            'text' => 'This certifies that',
            'size' => 19,
            'top'  => 225,
        ),
        array(
            'text' => $name,
            'size' => 24,
            'top'  => 285,
        ),
        array(
            'text' => 'has participated in the SETI@home project since ' . $date . ', and has contributed ' . $cobblestones,
            'size' => 12,
            'top'  => 330,
        ),
        array(
            'text' => "Cobblestones of computation ($operations floating-point operations) to SETI@home's search",
            'size' => 12,
            'top'  => 350,
        ),
        array(
            'text' => 'for extraterrestrial life.',
            'size' => 12,
            'top'  => 370,
        ),
        array(
            'text' => 'Dr. David P. Anderson',
            'size' => 13,
            'top'  => 490,
        ),
        array(
            'text' => 'Director, SETI@home',
            'size' => 13,
            'top'  => 510,
        ),
        array(
            'text' => date('j F Y'),
            'size' => 13,
            'top'  => 550,
        ),
    );

    $im = imagecreatetruecolor($width, $height);

    $black = imagecolorallocate($im, 0, 0, 0);
    $white = imagecolorallocate($im, 255, 255, 255);

    // Background
    imagefill($im, 0, 0, $white);

    imagesetthickness($im, 8);
    imagerectangle($im, 0, 0, $width, $height, $black);

    // Writing text
    for ($i = 0; $i < 6; $i++) {
        $string = $text[$i];
        $bbox = imagettfbbox($string['size'], 0, $font, $string['text']);
        imagettftext($im, $string['size'], 0, $width / 2 - ($bbox[2] - $bbox[0]) / 2, $string['top'], $black, $font, $string['text']);
    }

    $sig = imagecreatefrompng('http://setiathome.berkeley.edu/images/grey_sig_220.png');
    imagecopy($im, $sig, 78, 430, 0, 0, imagesx($sig), imagesy($sig));

    for ($i = 6; $i < 9; $i++) {
        $string = $text[$i];
        imagettftext($im, $string['size'], 0, 80, $string['top'], $black, $font, $string['text']);
    }

    $logo = imagecreatefromgif('http://setiathome.berkeley.edu/logo7.gif');
    imagecopy($im, $logo, 380, 460, 0, 0, imagesx($logo), imagesy($logo));

    $logo = imagecreatefrompng('http://setiathome.berkeley.edu/images/uc_logo_150.png');
    imagecopy($im, $logo, 670, 420, 0, 0, imagesx($logo), imagesy($logo));

    return $im;
}
