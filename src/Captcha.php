<?php

namespace App;

class Captcha
{
    const CAPTCHA_LENGTH = 6;
    const CAPTCHA_WIDTH = 180;
    const CAPTCHA_HEIGHT = 60;
    const CAPTCHA_FONT = 5;
    const HICKNESS = 3;

    public function generate(): void
    {
        $code = $this->generateCode();
        $_SESSION['captcha'] = $code;

        $image = $this->createImage();

        $this->drawCode($image, $code);
        $this->outputImage($image);
    }


    public function validate(string $answer): bool
    {
        $correctAnswer = $_SESSION['captcha'] ?? '';

        unset($_SESSION['captcha']);

        return $correctAnswer !== ''
            && strtoupper(trim($answer)) === strtoupper($correctAnswer);
    }

    private function generateCode(): string
    {
        $randomString = $this->getRandomStr();
        return substr($randomString, 0, self::CAPTCHA_LENGTH);
    }

    private function createImage()
    {
        $image = imagecreatetruecolor(
            self::CAPTCHA_WIDTH,
            self::CAPTCHA_HEIGHT
        );

        $background = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $background);

        return $image;
    }

    private function drawCode(\GdImage $image, string $code): void
    {
        $textColor = imagecolorallocate($image, 30, 30, 30);

        $textWidth = imagefontwidth(self::CAPTCHA_FONT) * strlen($code);
        $textHeight = imagefontheight(self::CAPTCHA_FONT);

        $x = (self::CAPTCHA_WIDTH - $textWidth) / 2;
        $y = (self::CAPTCHA_HEIGHT - $textHeight) / 2;

        $lineColor = imagecolorallocate($image, 150, 150, 150);

        imagesetthickness($image, self::HICKNESS);

        imageline(
            $image,
            10,
            self::CAPTCHA_HEIGHT / 2,
            self::CAPTCHA_WIDTH - 10,
            self::CAPTCHA_HEIGHT / 2,
            $lineColor
        );

        imagesetthickness($image, 1);

        imagestring($image, self::CAPTCHA_FONT, (int) $x, (int) $y, $code, $textColor);
    }

    private function outputImage(\GdImage $image): void
    {
        header('Content-Type: image/png');
        imagepng($image);
    }

    private function getRandomStr(): string
    {
        return str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789');
    }
}