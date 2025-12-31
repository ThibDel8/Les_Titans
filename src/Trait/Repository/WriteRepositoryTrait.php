<?php

declare(strict_types=1);

namespace App\Trait\Repository;

use Doctrine\ORM\EntityManagerInterface;

trait WriteRepositoryTrait
{
    abstract protected function getEntityManager(): EntityManagerInterface;

    public function save(object $entity, bool $flush = true): void
    {
        $manager = $this->getEntityManager();
        $manager->persist($entity);

        if ($flush) {
            $manager->flush();
        }
    }

    public function delete(object $entity, bool $flush = true): void
    {
        $manager = $this->getEntityManager();
        $manager->remove($entity);

        if ($flush) {
            $manager->flush();
        }
    }

    public function saveBulk(
        iterable $entities,
        int $batchSize = 50,
        bool $flush = true
    ): void {
        $manager = $this->getEntityManager();
        $i = 0;

        foreach ($entities as $entity) {
            $manager->persist($entity);
            ++$i;

            if ($flush && $i % $batchSize === 0) {
                $manager->flush();
                $manager->clear();
            }
        }

        if ($flush) {
            $manager->flush();
            $manager->clear();
        }
    }

    public function deleteBulk(
        iterable $entities,
        int $batchSize = 50,
        bool $flush = true
    ): void {
        $manager = $this->getEntityManager();
        $i = 0;

        foreach ($entities as $entity) {
            $manager->remove($entity);
            ++$i;

            if ($flush && $i % $batchSize === 0) {
                $manager->flush();
                $manager->clear();
            }
        }

        if ($flush) {
            $manager->flush();
            $manager->clear();
        }
    }
}
