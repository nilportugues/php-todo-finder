<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 11/9/15
 * Time: 10:10 PM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\TodoFinder\Command;

use NilPortugues\TodoFinder\Finder\FileParser;
use NilPortugues\TodoFinder\Command\Exceptions\ConfigFileException;
use NilPortugues\TodoFinder\Finder\FileSystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FinderCommand extends Command
{
    const COMMAND_NAME = 'find';
    const CONFIG_FILE  = 'php_todo_finder.yml';
    const TODO_FINDER  = 'todo_finder';

    /**
     * @var array
     */
    private $errors = [];

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription(
                'Looks into the code using a user-defined list of to-do phrases and stops commit if the'
                .' total amount increased or is above a threshold.'
            )
            ->addArgument(self::COMMAND_NAME, InputArgument::REQUIRED, 'File Path')
            ->addOption('config', '-c', InputOption::VALUE_OPTIONAL, 'Config File', self::CONFIG_FILE);
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null
     * @throws Exceptions\ConfigFileException
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path       = $input->getArgument(self::COMMAND_NAME);
        $realPath   = realpath($path);
        $configFile = $input->getOption('config');

        $finder = new FileParser($configFile);

        if (file_exists($configFile)) {
            $this->scanFiles($path, $finder);

            if (!empty($this->errors)) {
                $output->writeln("<info>To-do expressions were found:</info>\n");
                foreach ($this->errors as $file => $lines) {
                    foreach ($lines as $line) {
                        $output->writeln(
                            sprintf(
                                "<comment> - .%s:</comment> %s",
                                str_replace($realPath, '', $file),
                                $line
                            )
                        );
                    }
                }

                if (count($this->flatten($this->errors)) > $finder->getTotalAllowed()) {
                    throw new \Exception('To-do statements are piling up! Isn\'t it time to address this issue?');
                }
            }

            return $output->writeln("<info>\nCongratulations! To-do statements are under control.\n</info>");
        }

        throw new ConfigFileException($configFile);
    }

    /**
     * @param            $path
     * @param FileParser $finder
     */
    protected function scanFiles($path, FileParser $finder)
    {
        $fileSystem = new FileSystem();

        foreach ($fileSystem->getFilesFromPath($path) as $file) {
            $tokens = token_get_all(file_get_contents($file));
            foreach ($tokens as $token) {
                $this->scanForTodoFinder($finder, $token, $file);
            }
        }
    }

    /**
     * @param FileParser $finder
     * @param            $token
     * @param            $file
     */
    protected function scanForTodoFinder(FileParser $finder, $token, $file)
    {
        if (is_array($token) && count($token) === 3) {
            $type       = $token[0];
            $code       = $token[1];
            $lineNumber = $token[2];

            if (in_array($type, [T_COMMENT, T_DOC_COMMENT], \true)) {
                foreach ($finder->getTodoExpressions() as $todoExpression) {
                    if (false !== strpos(\strtolower($code), \strtolower($todoExpression))) {
                        $this->errors[$file][$lineNumber] = \sprintf(
                            '\'%s\' found on line %s.',
                            $todoExpression,
                            $lineNumber
                        );
                    }
                }
            }
        }
    }

    private function flatten(array $array)
    {
        $return = array();
        array_walk_recursive(
            $array,
            function ($a) use (&$return) {
                $return[] = $a;
            }
        );

        return $return;
    }
}
