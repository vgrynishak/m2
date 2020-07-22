<?php
namespace App\Tests\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class TestInitEnvironmentCommand extends Command
{
    private const ALLOWED_ENV = ['test', 'dev'];
    protected static $defaultName = 'tests:init_env';

    protected function configure()
    {
        $this->setName('init_env')
            ->setDescription('Init Environment')

        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!in_array($_ENV['APP_ENV'], self::ALLOWED_ENV)) {
            throw new \Exception("This command is only allowed in the TEST Or DEV environment");
        }

        $processDropDatabase = new Process(['bin/console', 'doctrine:database:drop', '--force', '--env='.$_ENV['APP_ENV']]);
        $processDropDatabase->mustRun();
        echo $processDropDatabase->getOutput();

        $processCreateDatabase = new Process(['bin/console', 'doctrine:database:create', '--env='.$_ENV['APP_ENV']]);
        $processCreateDatabase->mustRun();
        echo $processCreateDatabase->getOutput();

        $processMigrationsMigrate = new Process(['bin/console', 'doctrine:migrations:migrate', '--env='.$_ENV['APP_ENV']], null, null, null, 600);
        $processMigrationsMigrate->mustRun();
        echo $processMigrationsMigrate->getOutput();

        $processFixturesLoad = new Process(['bin/console', 'doctrine:fixtures:load', '--append', '--env='.$_ENV['APP_ENV']]);
        $processFixturesLoad->mustRun();
        echo $processFixturesLoad->getOutput();
    }
}
