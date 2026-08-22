<?php

$dir = __DIR__ . '/../public/frontend/pwa';
if (!is_dir($dir)) {
    mkdir($dir, 0755, true);
}

foreach ([192, 512] as $size) {
    $img = imagecreatetruecolor($size, $size);
    $bg = imagecolorallocate($img, 139, 123, 168);
    $white = imagecolorallocate($img, 255, 255, 255);
    imagefilledrectangle($img, 0, 0, $size, $size, $bg);

    $text = 'DJ';
    $fontSize = (int) ($size * 0.22);
    $fontFile = __DIR__ . '/../public/backend/fontawesome/webfonts/fa-solid-900.ttf';
    if (file_exists($fontFile)) {
        $bbox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth = abs($bbox[2] - $bbox[0]);
        $textHeight = abs($bbox[7] - $bbox[1]);
        imagettftext(
            $img,
            $fontSize,
            0,
            (int) (($size - $textWidth) / 2),
            (int) (($size + $textHeight) / 2),
            $white,
            $fontFile,
            $text
        );
    } else {
        $font = 5;
        $tw = imagefontwidth($font) * strlen($text);
        $th = imagefontheight($font);
        imagestring($img, $font, (int) (($size - $tw) / 2), (int) (($size - $th) / 2), $text, $white);
    }

    imagepng($img, $dir . '/icon-' . $size . '.png');
    imagedestroy($img);
}

echo "PWA icons generated in {$dir}\n";
