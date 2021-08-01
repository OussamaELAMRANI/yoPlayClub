<?php

namespace App\Infrastructure\Maker;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Twig\Environment;

abstract class AbstractMakerCommand extends Command
{
    public function __construct(
        string | null $name = null,
        protected Environment $twig,
        protected string $projectDir
    ) {
        parent::__construct($name);
    }

    /**
     * Create File content on subdirectory based on Twig.
     *
     * @param array<string, mixed> $params
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    protected function createFile(string $template, array $params, string $output): void
    {
        $content = $this->twig->render("@maker/{$template}.twig", $params);
        $filename = "{$this->projectDir}/{$output}";
        $directory = dirname($filename);
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        @file_put_contents($filename, $content);
    }

    protected function askDomain(SymfonyStyle $io): string
    {
        // construct list of domain using autocompletion.
        $domains = [];
        $files = (new Finder())->in("{$this->projectDir}/src/Domain")->depth(0)->directories();

        /** @var SplFileInfo $file */
        foreach ($files as $file) {
            $domains[] = $file->getBasename();
        }

        // Ask question to the USER
        $q = new Question('Select a domaine');
        $q->setAutocompleterValues($domains);

        return $io->askQuestion($q);
    }
}
