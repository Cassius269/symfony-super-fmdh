<?php

namespace App\Security\Voter;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class ListingVoter extends Voter
{
    public const DELETE = 'LISTING_DELETE';
    public const UPDATE = 'LISTING_UPDATE';

    public function __construct(private Security $security)
    {
        
    }
    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::DELETE, self::UPDATE])
            && $subject instanceof \App\Entity\Listing;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::DELETE:
                // logic to determine if the user can DELETE
                if(($this->security->isGranted('ROLE_AGENT') && $subject->getAgent()->getEmail() == $user->getEmail()) || $this->security->isGranted('ROLE_ADMIN') || $this->security->isGranted('ROLE_SUPER_ADMIN')){
                    return true;
                }
                // return true or false
                break;
            case self::UPDATE:
                // logic to determine if the user can DELETE
                if(($this->security->isGranted('ROLE_AGENT') && $subject->getAgent()->getEmail() == $user->getEmail()) || $this->security->isGranted('ROLE_ADMIN') || $this->security->isGranted('ROLE_SUPER_ADMIN')){
                    return true;
                }
                // return true or false
                break;                
        }

        return false;
    }
}
