<?php

declare(strict_types=1);

namespace App\Tests;

use App\Admin\User\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AbstractWebTestCase extends WebTestCase
{
    protected KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = self::createClient();
    }

    protected static function getRepository(string $entityClass): object
    {
        return self::getEntityManager()
            ->getRepository($entityClass)
        ;
    }

    protected function getLoggedUser(string $userId): KernelBrowser
    {
        $user = self::getRepository(User::class)->find($userId);

        return $this->client->loginUser($user);
    }

    protected static function getEntityManager(): EntityManagerInterface
    {
        return self::getContainer()
            ->get(EntityManagerInterface::class)
        ;
    }
}
