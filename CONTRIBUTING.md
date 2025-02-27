# Contributing

Contributions are welcome. This project accepts pull requests on
[GitHub](https://github.com/omnicolor/slack).

This project adheres to a [code of conduct](CODE_OF_CONDUCT.md). By
participating in this project and its community, you are expected to uphold this
code.

## Communication Channels

You can find help and discussion in the following places:

* GitHub Issues: <https://github.com/omnicolor/slack/issues>

## Reporting Bugs

Report bugs using the project's
[issue tracker](https://github.com/omnicolor/slack/issues).

⚠️ _**ATTENTION!!!** DO NOT include passwords or other sensitive information in
your bug report._

When submitting a bug report, please include enough information to reproduce
the bug. A good bug report includes the following sections:

* **Description:** Provide a short and clear description of the bug.
* **Steps to reproduce:** Provide steps to reproduce the behavior you are
  experiencing. Please try to keep this as short as possible. If able, create a
  reproducible script without any framework you are using. This will help us
  to quickly debug the issue.
* **Expected behavior:** Provide a short and clear description of what you
  expect to happen.
* **Screenshots or output:** If applicable, add screenshots or program output
  to help explain your problem.
* **Environment details:** Provide details about the system where you're using
  this package, such as PHP version and operating system.
* **Additional context:** Provide any additional context that may help us debug
  the problem.

## Fixing Bugs

This project welcomes pull requests to fix bugs! If you see a bug report that
you'd like to fix, please feel free to do so. Following the directions and
guidelines described in the "Adding New Features" section below, you may create
bugfix branches and send pull requests.

## Adding New Features

If you have an idea for a new feature, it's a good idea to check out the
[issues](http://github.com/omnicolor/slack/issues) or active
[pull requests](https://github.com/omnicolor/slack/pulls) first to see if
anyone is already working on the feature. If not, feel free to submit an issue
first, asking whether the feature is beneficial to the project. This will save
you from doing a lot of development work only to have your feature rejected. We
don't enjoy rejecting your hard work, but some features don't fit with the
goals of the project.

When you do begin working on your feature, here are some guidelines to
consider:

* Your pull request description should clearly detail the changes you have
  made. We will use this description to update the CHANGELOG. If there is no
  description, or it does not adequately describe your feature, we may ask you
  to update the description.
* omnicolor/slack follows a superset of **[PSR-12 coding standard][psr-12]**.
  Please ensure your code does, too. _Hint: run `composer style` and
  `composer static` to check._
* Please **write tests** for any new features you add.
* Please **ensure that tests pass** before submitting your pull request.
  GitHub actions automatically runs tests for pull requests. However,
  running the tests locally will help save time. _Hint: run `composer test`._
* **Use topic/feature branches.** Please do not ask to pull from your main
  branch.
* **Submit one feature per pull request.** If you have multiple features you
  wish to submit, please break them into separate pull requests.

## Developing

To develop this project, you will need [PHP](https://www.php.net) 8.3 or
greater and [Composer](https://getcomposer.org).

After cloning this repository locally, execute the following commands:

``` bash
cd /path/to/repository
composer install
```

Now, you are ready to develop!

### Tooling

This project uses [CaptainHook](https://github.com/CaptainHookPhp/captainhook)
to validate all staged changes prior to commit.

### Commands

To see all the commands available for contributing to this project:

``` bash
composer list
```

### Coding Standards

This project follows a superset of
[PSR-12](https://www.php-fig.org/psr/psr-12/) coding standards, enforced by
[PHP CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) and
[PHP-cs-fixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer).

CaptainHook will run coding standards checks before committing.

You may lint the codebase manually using the following commands:

``` bash
# PHP-cs-fixer style check
composer php-cs-fixer

# PHP_CodeSniffer style check
composer phpcs
```

or you can run both together:

``` bash
composer style
```

### Static Analysis

This project uses
[PHP-Parallel-Lint](https://github.com/php-parallel-lint/PHP-Parallel-Lint) and
[PHPStan](https://github.com/phpstan/phpstan) to provide static analysis of PHP
code.

CaptainHook will run static analysis checks before committing.

You may run static analysis manually across the whole codebase with the
following commands:

``` bash
# Lint
composer lint

# Static analysis
composer phpstan
```

or you can run both together:

``` bash
composer static
```

### Running Tests

The following must pass before we will accept a pull request. If this does not
pass, it will result in a complete build failure. Before you can run this, be
sure to `composer install`.

To run all the tests and coding standards checks, execute the following from
the command line, while in the project root directory:

``` bash
composer test
```

If you'd like to see code coverage metrics for the project, you'll need XDebug
installed and run:

``` bash
composer coverage
```

PHPUnit will generate a report in the coverage/ directory.

CaptainHook will automatically run all tests before pushing to the remote
repository.
