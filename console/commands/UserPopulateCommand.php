<?php
namespace app\console\commands;

use app\models\User;
use Faker\Factory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserPopulateCommand extends Command
{
    protected function configure()
    {
        $this->setName('user:populate')
            ->setDescription('Создает кучу новых пользователей')
            ->setHelp('Создает нового пользователя');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 20; $i++ ) {
            $user = new User();
            $user->name = $faker->name();
            $user->email = $faker->email;
            $user->password = $faker->password();
            $user->save();
        }

        return Command::SUCCESS;
    }
}
