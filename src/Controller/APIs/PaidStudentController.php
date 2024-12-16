<?php

namespace App\Controller\APIs;

use App\Repository\PaidRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class  PaidStudentController extends AbstractController
{

  public function __construct(
    private readonly NormalizerInterface $normalizer,
    private PaidRepository $paidRepository
  ) {}

  public function __invoke(string $token): JsonResponse
  {
    $data = $this->paidRepository->findResponseQrcode($token);

    $dataPaid = $this->normalizer->normalize($data, null, [
      'groups' => ['read:paid:item']
    ]);

    return new JsonResponse($dataPaid);
  }
}
