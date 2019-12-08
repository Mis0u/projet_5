<?php

namespace App\Listener;

use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class HashPasswordListener
{
    /**
     * @var UserPasswordEncoderInterface User password encoder
     */
    private $userPasswordEncoder;
    /**
     * HashPasswordListener constructor.
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }
    /**
     * Listen pre persist event on User entity
     * @param User $user
     */
    public function prePersist(User $user): void
    {
        $this->encodePassword($user);
    }
    /**
     * Listen pre update event on User entity
     * @param User $user
     */
    public function preUpdate(User $user): void
    {
        $this->encodePassword($user);
    }
    /**
     * Encode user's password with plain password
     * @param User $user
     */
    private function encodePassword(User $user): void
    {
        if (null === $user->getPlainPassword()) {
            return;
        }
        $user->setPassword($this->userPasswordEncoder->encodePassword($user, $user->getPlainPassword()));
        $user->setPlainPassword(null);
    }
}
