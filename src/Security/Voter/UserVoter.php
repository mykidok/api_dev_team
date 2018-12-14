<?php

namespace App\Security\Voter;


use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        return 'ROLE_VOTER' === $attribute && $subject instanceof User;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        if (!$subject instanceof User || !\in_array('ROLE_USER', $subject->getRoles())) {
            return false;
        }

        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        if ($user === $subject) {
            return true;
        }

        return false;
    }
}