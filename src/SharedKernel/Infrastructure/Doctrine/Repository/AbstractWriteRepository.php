<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use App\SharedKernel\Domain\Repository\WriteRepositoryInterface;

abstract class AbstractWriteRepository implements WriteRepositoryInterface
{
    public function save(object $entity, bool $flush = true): void
    {
        $this->getManager()->persist($entity);

        if ($flush) {
            $this->getManager()->flush();
        }
    }

    public function delete(object $entity, bool $flush = true): void
    {
        $this->getManager()->remove($entity);

        if ($flush) {
            $this->getManager()->flush();
        }
    }

    public function saveBulk(iterable $entities, int $batchSize = 50): void
    {
        $i = 0;

        foreach ($entities as $entity) {
            $this->getManager()->persist($entity);
            ++$i;

            if ($i % $batchSize === 0) {
                $this->getManager()->flush();
                $this->getManager()->clear();
            }
        }

        $this->getManager()->flush();
        $this->getManager()->clear();
    }

    public function deleteBulk(iterable $entities, int $batchSize = 50): void
    {
        $i = 0;

        foreach ($entities as $entity) {
            $this->getManager()->remove($entity);
            ++$i;

            if ($i % $batchSize === 0) {
                $this->getManager()->flush();
                $this->getManager()->clear();
            }
        }

        $this->getManager()->flush();
        $this->getManager()->clear();
    }

    abstract protected function getManager(): EntityManagerInterface;
}
