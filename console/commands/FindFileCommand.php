<?php
/**
 * Created by andrii
 * Date: 30.01.21
 * Time: 22:18
 */

namespace app\console\commands;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class FindFileCommand extends Command
{
    protected function configure()
    {
        $this->setName('find:file')
            ->setDescription('Поиск файла')
            ->setHelp('Поиск файла')
            ->addArgument('filename', InputArgument::REQUIRED, 'Наименование файла для поиска');

    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = $input->getArgument('filename');

        $finder = new Finder();
        $finder->in(__DIR__ )
//            ->name('*.php')
            ->name("*$filename*")
            ->sortByName()

            ->files();


        $output->writeln($finder);


        return Command::SUCCESS;
    }
}
