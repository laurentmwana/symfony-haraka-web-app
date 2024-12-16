<?php

namespace App\Doctrine;

use App\Entity\User;
use App\Owner\UserStudentOwnerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use App\Owner\UserOwnerInterface;

class CurrentUserExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
  public function __construct(private Security $security) {}

  public function applyToItem(\Doctrine\ORM\QueryBuilder $queryBuilder, \ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, \ApiPlatform\Metadata\Operation|null $operation = null, array $context = []): void
  {
    $this->addWhere($resourceClass, $queryBuilder);
  }

  public function applyToCollection(\Doctrine\ORM\QueryBuilder $queryBuilder, \ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, \ApiPlatform\Metadata\Operation|null $operation = null, array $context = []): void
  {
    $this->addWhere($resourceClass, $queryBuilder);
  }

  private function addWhere(string $resourceClass, \Doctrine\ORM\QueryBuilder $queryBuilder): void
  {

    $user = $this->security->getUser();

    if (!($user instanceof User)) {
      return;
    }

    $reflectionClass = new \ReflectionClass($resourceClass);


    if ($reflectionClass->implementsInterface(UserStudentOwnerInterface::class)) {
      $alias = $queryBuilder->getRootAliases()[0];
      $queryBuilder
        ->andWhere("$alias.student = :current_user_student_owner")
        ->setParameter('current_user_student_owner', $user->getStudent()->getId());
    }

    if ($reflectionClass->implementsInterface(UserOwnerInterface::class)) {
      $alias = $queryBuilder->getRootAliases()[0];
      $queryBuilder
        ->andWhere("$alias.user = :current_user_owner")
        ->setParameter('current_user_owner', $user->getId());
    }
  }
}
