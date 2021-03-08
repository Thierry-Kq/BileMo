<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\User;
use App\Exception\UserNotOwnedException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;


class UserDataPersister implements ContextAwareDataPersisterInterface
{
    private $entityManager;

    private $security;

    public function __construct(
        EntityManagerInterface $entityManager,
        Security $security
    ) {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof User;
    }

    public function persist($data, array $context = [])
    {
        if (isset($context['item_operation_name'])) {
            $this->checkAuthClient($data, $context);
        }
        $client = $this->security->getUser();

        $data->setClient($client);

        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    public function remove($data, array $context = [])
    {
        $this->checkAuthClient($data, $context);

        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }

    public function checkAuthClient($data, $context)
    {
        if ($this->security->getUser() !== $data->getClient()) {
            throw new UserNotOwnedException('Cet utilisateur ne vous appartient pas.');
        }
    }
}