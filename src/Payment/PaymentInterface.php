<?php

namespace App\Payment;

use App\Entity\Payment;

interface PaymentInterface
{
  public function isCompleted(): bool;

  public function startPayment(Payment $payment): bool;
}
