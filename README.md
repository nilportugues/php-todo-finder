[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nilportugues/php_todo_finder/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nilportugues/php_todo_finder/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/de4fc897-e1bc-4ab2-9ac2-b3518538fad1/mini.png)](https://insight.sensiolabs.com/projects/de4fc897-e1bc-4ab2-9ac2-b3518538fad1)
[![Latest Stable Version](https://poser.pugx.org/nilportugues/php_todo/v/stable)](https://packagist.org/packages/nilportugues/php_todo)
[![Total Downloads](https://poser.pugx.org/nilportugues/php_todo/downloads)](https://packagist.org/packages/nilportugues/php_todo)
[![License](https://poser.pugx.org/nilportugues/php_todo/license)](https://packagist.org/packages/nilportugues/php_todo)


## Why
Keep the @todo count for each commit.

Do not allow commits if the total amount of @todo increased or is above a user-defined threshold.

Purpose is to keep the @todo list low and forcing cleaning the code or resolving them.


## Installation

Use [Composer](https://getcomposer.org) to install the package:

```
$ composer require nilportugues/php_todo
```

## Usage

It is really this simple:

```
$ php bin/php_todo find <path/to/directory>
```

### Configuration file

- Define the todo annotations to look for in the code.
- Define the amount of @todo that will be tolerated.

When run the first time, if no `php_todo_finder.yml` file is found you will have to create it.

A configuration for instance, should formatted as follows:

```yml
todo_finder:
  total_allowed: 5
  expressions:
    - @todo
    - TODO
    - refactor
    - FIX ME
```

You can specify an alternate location for the configuration file by passing in the `-c` parameter. Example:

```
$  php bin/php_todo check -c configs/php_todo_finder.yml src/
```

## Based on the ideas from:

- http://jezenthomas.com/using-git-to-manage-todos/

## Contribute

Contributions to the package are always welcome!

* Report any bugs or issues you find on the [issue tracker](https://github.com/nilportugues/php_todo_finder/issues/new).
* You can grab the source code at the package's [Git repository](https://github.com/nilportugues/php_todo_finder).


## Support

Get in touch with me using one of the following means:

 - Emailing me at <contact@nilportugues.com>
 - Opening an [Issue](https://github.com/nilportugues/php_todo_finder/issues/new)


## Authors

* [Nil Portugués Calderó](http://nilportugues.com)
* [The Community Contributors](https://github.com/nilportugues/php_todo_finder/graphs/contributors)


## License
The code base is licensed under the [MIT license](LICENSE).
