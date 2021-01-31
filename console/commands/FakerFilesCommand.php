<?php
/**
 * Created by andrii
 * Date: 30.01.21
 * Time: 22:36
 */

namespace app\console\commands;


use Faker\Factory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FakerFilesCommand extends Command
{
    protected function configure()
    {
        $this->setName('faker:files')
            ->setHelp('Генерируем случайные файлы')
            ->setDescription('Генерируем случайные файлы')
            ->addArgument('count', InputArgument::REQUIRED, 'Необходимое количество файлов');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $count = $input->getArgument('count');
        $faker = Factory::create();

        for ($i = 1; $i <= $count; $i++) {
            file_put_contents(__DIR__ .'/../../files/' . $faker->md5 . '.txt', $faker->name);
        }

        return Command::SUCCESS;
    }
}
