<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Shared\Parser;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParseCommand extends Command
{
    public function __construct()
    {
        parent::__construct('parse');
    }

    protected function configure()
    {
        $this->setDescription('Parse input from stdin and pretty-print the result.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $input = stream_get_contents(STDIN);

        $result = Parser::parse($input);

        if ($result !== null) {
            ob_start();
            print_r($result);
            $output->writeln(ob_get_clean());
            return Command::SUCCESS;
        } else {
            $output->getErrorOutput()->writeln('Parsing failed or returned no result.');
            return Command::FAILURE;
        }
    }
}

$application = new Application();
$application->add(new ParseCommand());
$application->setDefaultCommand('parse', true);
$application->run();
