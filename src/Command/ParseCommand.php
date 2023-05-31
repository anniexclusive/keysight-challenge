<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('app:parse')]
class ParseCommand extends Command
{
    private $output;

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'File Path')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if (!$arg1 || !str_ends_with($arg1, 'root.prog')) {
            die('please provide a valid filepath argument');
        }
        $this->output = basename($arg1).PHP_EOL."\n";
        $this->displayImportStructure($arg1);
        echo str_replace(PHP_EOL, '', $this->output);

        $io->success('SUCCESS');

        return Command::SUCCESS;
    }

    public function displayImportStructure(string $rootProgramPath, string $indentation = "   "): void
    {
        $fileContent = file_get_contents($rootProgramPath);

        // Find import statements using regular expressions
        preg_match_all('/import\s+(.+);/', $fileContent, $matches);

        if (!empty($matches[1])) {
            foreach ($matches[1] as $import) {
                $importPath = trim($import);

                // Print the import path with proper indentation
                $this->output .= $indentation . basename($import).PHP_EOL . "\n";

                // Recursively call
                $importFilePath = dirname($rootProgramPath) . '/' . $importPath;
                $this->displayImportStructure($importFilePath, $indentation . "   ");
            }
        }
    }
}
