<?php

namespace App\Listener;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsDoctrineListener(event: Events::preUpdate, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
class PasswordHasherSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private UserPasswordHasherInterface $hasher,
    ) {
    }

    public function hashPassword(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if(!$entity instanceof User) {
            return;
        }

        if($entity->getPassword()) {
            $hashedPassword = $this->hasher->hashPassword($entity, $entity->getPassword());
            $entity->setPassword($hashedPassword);
        }
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $this->hashPassword($args);
    }

    public function prePersist(PrePersistEventArgs $args): void
    {
        $this->hashPassword($args);
    }


    public static function getSubscribedEvents(): array
    {
        return [
            Events::prePersist => ['hashPassword'],
            Events::preUpdate => ['hashPassword'],
        ];
    }
}