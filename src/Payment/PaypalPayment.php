<?php

namespace App\Payment;

final class PaypalPayment implements PaymentInterface
{
  private bool $completed = false;

  public function __construct(
    public readonly string $secret,
    public readonly string $clientId,
  ) {}

  public function isCompleted(): bool
  {
    return $this->completed;
  }

  public function startPayment(\App\Entity\Payment $payment): bool
  {
    return false;
  }
}
