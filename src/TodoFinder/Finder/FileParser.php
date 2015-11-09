<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 11/9/15
 * Time: 10:53 PM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\TodoFinder\Finder;

use Symfony\Component\Yaml\Yaml;

class FileParser
{
    const TODO_FINDER = 'todo_finder';
    const TOTAL_ALLOWED = 'total_allowed';
    const EXPRESSIONS = 'expressions';

    /**
     * @var array
     */
    private $file;

    /**
     * @param string $file
     */
    public function __construct($file)
    {
        $yaml = new Yaml();
        $file = (array) $yaml->parse($file, true);

        $this->validateFileStructure($file);
        $this->file = $file;
    }

    /**
     * @param array $file
     *
     * @throws FileParserException
     */
    private function validateFileStructure(array &$file)
    {
        if (false === array_key_exists(self::TODO_FINDER, $file)) {
            throw new FileParserException(
                sprintf(
                    'Provided YAML file does not compile with the required format. '
                    .'Expected \'%s\' key to be present but none was found.',
                    self::TODO_FINDER
                )
            );
        }

        $this->assertYamlKey($file[self::TODO_FINDER], self::TOTAL_ALLOWED);
        $this->assertYamlKey($file[self::TODO_FINDER], self::EXPRESSIONS);
    }

    /**
     * @param array  $file
     * @param string $key
     *
     * @throws FileParserException
     */
    private function assertYamlKey(array &$file, $key)
    {
        if (false === array_key_exists($key, $file)) {
            throw new FileParserException(
                sprintf(
                    'Provided YAML file does not compile with the required format. '
                    .'Expected \'%s\' key under \'%s\' to be present but none was found.',
                    $key,
                    self::TODO_FINDER
                )
            );
        }
    }

    /**
     * @throws FileParserException
     * @return int
     */
    public function getTotalAllowed()
    {
        $totalAllowed = $this->file[self::TODO_FINDER][self::TOTAL_ALLOWED];
        $totalAllowedInt = (int) $totalAllowed;

        if (!is_numeric($totalAllowed) && $totalAllowed != $totalAllowedInt) {
            throw new FileParserException(
                'Provided value for %s was expected to be an integer but %s was given',
                self::TOTAL_ALLOWED,
                gettype($totalAllowed)
            );
        }

        return (int) $totalAllowedInt;
    }

    /**
     * @throws FileParserException
     * @return array
     */
    public function getTodoExpressions()
    {
        $list = $this->file[self::TODO_FINDER][self::EXPRESSIONS];

        if (!is_array($list)) {
            throw new FileParserException(
                'Provided value for %s was expected to be an array but %s was given',
                self::EXPRESSIONS,
                gettype($list)
            );
        }

        arsort($list);

        return (array) $list;
    }
}
