<?php namespace App\Security;

use App\Entity\User as AppUser;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
{
    if (!$user instanceof AppUser) {
        return;
    }

    // user account is expired, the user may be notified
    if (!$user->getActive()) {
        throw new CustomUserMessageAuthenticationException('Nem aktív felhasználó');
    }
}

public function checkPostAuth(UserInterface $user)
{
if (!$user instanceof AppUser) {
return;
};
// user account is expired, the user may be notified
    if (!$user->getActive() ) {
        throw new AccountExpiredException('Lejárt felhasználó');
    }
}
}