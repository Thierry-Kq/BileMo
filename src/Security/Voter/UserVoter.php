<?php


namespace App\Security\Voter;


use App\Entity\Client;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{

    protected function supports(string $attribute, $subject)
    {
        if (!$subject instanceof User) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $client = $token->getUser();
        if (!$client instanceof Client) {
            return false;
        }

        $user = $subject;

        return $client === $user->getClient();
    }
}