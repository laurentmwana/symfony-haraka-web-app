<?php

namespace App\Security\Voter;

use App\Entity\Paid;
use App\Entity\User;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * @extends Voter<string, Paid>
 */
final class PaidVoter extends Voter
{
    public const VIEW = 'PAID_VIEW';

    /**
     * @param string $attribute
     * @param Paid|null $subject
     * @return bool
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::VIEW])
            && $subject instanceof Paid;
    }

    /**
     * @param string $attribute
     * @param Paid|null $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        if (!$subject instanceof Paid) {
            return false;
        }

        return match ($attribute) {
            self::VIEW => $this->canView($subject, $user),
            default => throw new \LogicException('This code should not be reached!'),
        };
    }

    private function canView(Paid $paid, User $user): bool
    {
        return $this->canEdit($paid, $user);
    }

    private function canEdit(Paid $paid, User $user): bool
    {
        return $user->getStudent() === $paid->getStudent();
    }
}
