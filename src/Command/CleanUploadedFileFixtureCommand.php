<?php

namespace App\Command;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:clean-uploaded-file-fixture',
    description: "Nettoie tous kes fichiers générés par les fixtures.",
)]
class CleanUploadedFileFixtureCommand extends Command
{
    public function __construct(
        private readonly Filesystem $filesystem,
        private readonly string $uploadDir = 'public/images/profiles/uploads'
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->filesystem->exists($this->uploadDir)) {
            $output->writeln("<comment>Le dossier {$this->uploadDir} n’existe pas, rien à nettoyer.</comment>");
            return Command::SUCCESS;
        }

        $files = glob($this->uploadDir . '/*');

        if (empty($files)) {
            $output->writeln("<info>Aucun fichier à supprimer.</info>");
            return Command::SUCCESS;
        }

        foreach ($files as $file) {
            if (is_file($file)) {
                $this->filesystem->remove($file);
            }
        }

        $output->writeln("<info>Dossier nettoyé : {$this->uploadDir}</info>");
        return Command::SUCCESS;
    }
}
