<?php
/**
 * Created by andrii
 * Date: 30.01.21
 * Time: 21:48
 */

namespace app\console\commands;


use app\models\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UserSearchCommand extends Command
{
    protected function configure()
    {
        $this->setName('user:search')
            ->setDescription('Поиск пользователей')
            ->setHelp('Поиск пользователей')
            ->addArgument('query', InputArgument::REQUIRED, 'Имя или Email');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $query = $input->getArgument('query');

        $users = User::where('email', 'like', "%$query%")
            ->orWhere('name', 'like', "%$query%")
            ->get();

        if (!$users->count()) {
            $output->writeln("<info>Не найдено пользователей за запросом: $query</info>");
            return Command::SUCCESS;
        }

        $output->writeln($users);

        return Command::SUCCESS;
    }
}
