<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class DateTimeRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // Inject dependencies if needed
    }

    public function ago(\DateTime|string $date): string
    {
        // Convertir la date en objet DateTime si nécessaire
        $obj = $date instanceof \DateTime ? $date : new \DateTime($date);

        $now = new \DateTime();

        // Calcul de la différence en secondes
        $timeDifference = $now->getTimestamp() - $obj->getTimestamp();
        $secondsDifference = floor($timeDifference);
        $minutesDifference = floor($secondsDifference / 60);
        $hoursDifference = floor($minutesDifference / 60);
        $daysDifference = floor($hoursDifference / 24);
        $monthsDifference = floor($daysDifference / 30);
        $yearsDifference = floor($monthsDifference / 12);

        // Retourner la chaîne de caractères en fonction de la différence
        if ($secondsDifference < 60) {
            return "il y a $secondsDifference seconde" . ($secondsDifference > 1 ? "s" : "");
        } elseif ($minutesDifference < 60) {
            return "il y a $minutesDifference minute" . ($minutesDifference > 1 ? "s" : "");
        } elseif ($hoursDifference < 24) {
            return "il y a $hoursDifference heure" . ($hoursDifference > 1 ? "s" : "");
        } elseif ($daysDifference < 7) {
            return "il y a $daysDifference jour" . ($daysDifference > 1 ? "s" : "");
        } elseif ($monthsDifference < 12) {
            return "il y a $monthsDifference mois";
        } else {
            return "il y a $yearsDifference an" . ($yearsDifference > 1 ? "s" : "");
        }
    }
}
