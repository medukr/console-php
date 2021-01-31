<?php
/**
 * Created by andrii
 * Date: 30.01.21
 * Time: 20:22
 */

namespace app\console\commands;


use app\models\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserAllCommand extends Command
{
    protected function configure()
    {
        $this->setName('user:all')
            ->setDescription('Показать всех пользователей')
            ->setHelp('Показать всех пользователей');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $users = User::all();


        foreach ($users as $user) {

            $output->writeln($user->id.' | '.$user->name.' | '. $user->email);
        }

        return Command::SUCCESS;
    }
}
