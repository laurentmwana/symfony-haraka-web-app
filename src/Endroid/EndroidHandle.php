<?php

namespace App\Endroid;

use App\Helpers\TokenGenerator;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Label\Font\NotoSans;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class EndroidHandle
{
    /**
     * Génère un QR code à partir d'une donnée et retourne un fichier temporaire.
     *
     * @param string $data Le contenu à inclure dans le QR code.
     * @param string|null $label Optionnel : un texte à afficher sous le QR code.
     * @return UploadedFile
     */
    public static function write(string $data, ?string $label = null): UploadedFile
    {
        // Construction du QR code
        $builder = Builder::create()
            ->data($data)
            ->encoding(new Encoding('UTF-8'))
            ->size(300)
            ->margin(10);

        // Ajout d'une étiquette si elle est définie
        if ($label) {
            $builder->labelText($label)
                ->labelFont(new NotoSans(20));
        }

        $result = $builder->build();

        // Génération d'un nom unique pour le fichier
        $name = sprintf("%s.png", TokenGenerator::alpha(10));

        // Chemin du fichier temporaire
        $tempPath = sprintf("%s/%s", sys_get_temp_dir(), $name);

        // Écriture du QR code dans le fichier
        file_put_contents($tempPath, $result->getString());

        // Retourne le fichier temporaire comme UploadedFile
        return new UploadedFile(
            $tempPath,
            $name,
            'image/png',
            null, // Taille (null pour ne pas recalculer)
            true  // Mode test pour éviter les problèmes de permissions
        );
    }
}
