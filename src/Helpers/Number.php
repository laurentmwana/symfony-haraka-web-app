<?php

namespace App\Helpers;

final class Number
{
  /**
   * @param int|float $totalAmount
   * @param int $numTranches
   * @return array<int, float>
   */
  public static function divideIntoInstallments(int|float $totalAmount, int $numTranches): array
  {
    $installments = [];

    // Initialisation d'une somme temporaire
    $remainingAmount = $totalAmount;

    // Boucle pour générer des tranches aléatoires pour les (n-1) premières tranches
    for ($i = 1; $i < $numTranches; $i++) {
      // Générer un montant aléatoire entre 10% et 90% du montant restant (ou ajuster les bornes selon le besoin)
      $randomAmount = rand(1, (int)($remainingAmount * 0.9));

      // Ajouter le montant à la liste des tranches
      $installments[] = $randomAmount;

      // Soustraire le montant de la somme restante
      $remainingAmount -= $randomAmount;
    }

    // La dernière tranche doit être égale au montant restant pour garantir la somme totale
    $installments[] = $remainingAmount;

    return $installments;
  }
}
