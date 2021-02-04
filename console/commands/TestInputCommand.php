<?php
/**
 * Created by andrii
 * Date: 04.02.21
 * Time: 21:57
 */

namespace app\console\commands;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class TestInputCommand extends Command
{
    protected function configure()
    {
        $this->setName('test:input');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        //Ответить да нет
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Continue with this action?[yes/no]: ', false);

        $answer = $helper->ask($input, $output, $question);
        print_r($answer);
        echo PHP_EOL;

        // ввести текстом ответ
        $question = new Question('Please enter the name of the bundle: ', 'AcmeDemoBundle');

        $bundleName = $helper->ask($input, $output, $question);
        print_r($bundleName);
        echo PHP_EOL;

        // выбрать из вариантов
        $question = new ChoiceQuestion(
            'Please select your favorite color (defaults to red)',
            // choices can also be PHP objects that implement __toString() method
            ['red', 'blue', 'yellow'],
            0
        );
        $question->setErrorMessage('Color %s is invalid.');

        $color = $helper->ask($input, $output, $question);
        print_r($color);
        echo PHP_EOL;

        // выбрать из вариантов с множественным выбором
        $question = new ChoiceQuestion(
            'Please select your favorite colors (defaults to red and blue)',
            ['red', 'blue', 'yellow'],
            '0,1'
        );
        $question->setMultiselect(true);

        $colors = $helper->ask($input, $output, $question);
        print_r($colors);
        echo PHP_EOL;


        // Автодополнение ответов
        $bundles = ['AcmeDemoBundle', 'AcmeBlogBundle', 'AcmeStoreBundle'];
        $question = new Question('Please enter the name of a bundle', 'FooBundle');
        $question->setAutocompleterValues($bundles);

        $bundleName = $helper->ask($input, $output, $question);
        print_r($bundleName);
        echo PHP_EOL;


        // Автодополнение сгенерированное на лету
        $callback = function (string $userInput): array {
            // Strip any characters from the last slash to the end of the string
            // to keep only the last directory and generate suggestions for it
            $inputPath = preg_replace('%(/|^)[^/]*$%', '$1', $userInput);
            $inputPath = '' === $inputPath ? '.' : $inputPath;

            // CAUTION - this example code allows unrestricted access to the
            // entire filesystem. In real applications, restrict the directories
            // where files and dirs can be found
            $foundFilesAndDirs = @scandir($inputPath) ?: [];

            return array_map(function ($dirOrFile) use ($inputPath) {
                return $inputPath.$dirOrFile;
            }, $foundFilesAndDirs);
        };

        $question = new Question('Please provide the full path of a file to parse');
        $question->setAutocompleterCallback($callback);

        $filePath = $helper->ask($input, $output, $question);
        print_r($filePath);
        echo PHP_EOL;

        // скрывать ввод, например, пароль
        $question = new Question('What is the database password?');
        $question->setHidden(true);
        $question->setHiddenFallback(false);

        $password = $helper->ask($input, $output, $question);
        print_r($password);
        echo PHP_EOL;


        // Установить свой валидатор
        $question = new Question('Please enter the name of the bundle', 'AcmeDemoBundle');
        $question->setValidator(function ($answer) {
            if (!is_string($answer) || 'Bundle' !== substr($answer, -6)) {
                throw new \RuntimeException(
                    'The name of the bundle should be suffixed with \'Bundle\''
                );
            }

            return $answer;
        });
        $question->setMaxAttempts(2);

        $bundleName = $helper->ask($input, $output, $question);
        print_r($bundleName);
        echo PHP_EOL;

        return self::SUCCESS;
    }
}
