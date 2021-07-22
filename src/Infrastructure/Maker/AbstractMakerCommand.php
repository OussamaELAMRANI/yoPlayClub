<?php

namespace App\Infrastructure\Maker;

use Symfony\Component\Console\Command\Command;
use Twig\Environment;

abstract class AbstractMakerCommand extends Command
{
    public function __construct(
        string|null $name = null,
        protected Environment $twig,
        protected string $projectDir
    )
    {
        parent::__construct($name);
    }

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
}
