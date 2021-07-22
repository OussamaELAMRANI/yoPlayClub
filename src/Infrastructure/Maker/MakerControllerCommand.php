<?php

namespace App\Infrastructure\Maker;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakerControllerCommand extends AbstractMakerCommand
{
    protected static $defaultName = 'yo:controller';
    protected const CONTROLLER = 'Controller';
    protected const API_OPTION = 'api';

    protected function configure(): void
    {
        $this
            ->setDescription('Creat Controller based on Yo CMD')
            ->addArgument(static::CONTROLLER, InputArgument::OPTIONAL, 'Controller name')
            ->addOption(static::API_OPTION, null, InputOption::VALUE_NONE, "Controller for API");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $controllerPath = $input->getArgument(static::CONTROLLER);

        if (!is_string($controllerPath)) {
            throw new \RuntimeException('ControllerPath should be a string !');
        }

        if (static::CONTROLLER !== substr($controllerPath, -1 * strlen(static::CONTROLLER))) {
            $controllerPath .= static::CONTROLLER;
        }

        $parts = explode('/', $controllerPath);
        if (1 === $partCount = count($parts)) {
            $namespace = '';
            $className = $parts[0];
        } else {
            $namespace = '\\' . implode('\\', array_slice($parts, 0, -1));
            $className = $parts[$partCount - 1];
        }

        $api = $input->getOption('api');
        if (false === $api) {
            $basePath = 'src/Http/Controller/';
        } else {
            $basePath = 'src/Http/Api/Controller/';
        }

        $params = [
            'namespace' => $namespace,
            'class_name' => $className,
            'api' => $api,
        ];

        $this->createFile('controller', $params, "{$basePath}{$controllerPath}.php");

        $io->success("{$className} has been successfully created !");

        return Command::SUCCESS;
    }

}
