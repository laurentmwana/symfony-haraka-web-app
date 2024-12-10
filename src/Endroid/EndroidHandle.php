<?php

namespace App\Endroid;

use App\Helpers\TokenGenerator;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class EndroidHandle
{

    public static function write(string $data): File
    {
        $qr = (new Builder(
            writer: new PngWriter(),
            data: $data,
            encoding: new Encoding('UTF-8'),
            size: 200,
            margin: 10
        ))->build();

        $name = sprintf("%s.png", TokenGenerator::alpha(10));

        $temp = sprintf(
            "%s/%s",
            sys_get_temp_dir(),
            $name
        );

        file_put_contents($temp, $qr->getString());

        return new UploadedFile(
            $temp,
            $name,
            'image/png',
            null, // Size (optional)
            true  // Mark as test mode to avoid permission issues
        );
    }
}
