<?php
namespace app\console\commands;

use app\models\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class UserCreateCommand extends Command
{
    protected function configure()
    {
        $this->setName('user:create')
            ->setDescription('Создает нового пользователя')
            ->setHelp('Создает нового пользователя')
            ->addOption('username', 'u', InputOption::VALUE_REQUIRED, 'Имя пользователя')
            ->addOption('email', 'e', InputOption::VALUE_REQUIRED, 'Email пользователя')
            ->addOption('password', 'p', InputOption::VALUE_REQUIRED, 'Пароль пользователя');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $username = $input->getOption('username');
        $email = $input->getOption('email');
        $password = $input->getOption('password');

        $this->validateUsername($username);
        $this->validateEmail($email);
        $this->validatePassword($password);

        $user = new User();
        $user->name = $username;
        $user->password = $password;
        $user->email = $email;
        $user->save();

        $output->writeln('Создан пользователь с id: ' . $user->id);
        return Command::SUCCESS;
    }

    private function validateUsername($username)
    {
        if (empty($username)) {
            throw new InvalidOptionException('Пустое имя пользователя');
        }
    }

    private function validateEmail($email)
    {
        if (empty($email)) {
            throw new InvalidOptionException('Пустое email пользователя');
        }
    }

    private function validatePassword($password)
    {
        if (empty($password)) {
            throw new InvalidOptionException('Пустое password пользователя');
        }
    }

}
