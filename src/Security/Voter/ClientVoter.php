<?php

namespace App\Security\Voter;

use App\Entity\Client;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ClientVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        if (!$subject instanceof Client) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {

        return $token->getUser() === $subject;
    }
}
