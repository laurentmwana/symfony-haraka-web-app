<?php

namespace App\Controller\APIs;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class MeController
{
  public function __construct(
    private readonly Security $security,
    private readonly NormalizerInterface $normalizer,
    private UserRepository $userRepository
  ) {}

  public function __invoke(): JsonResponse
  {
    $user = $this->security->getUser();

    $data = $this->userRepository->findMe($user);

    $dataUser = $this->normalizer->normalize($data, null, [
      'groups' => ['read:user:item']
    ]);

    return new JsonResponse($dataUser);
  }
}
