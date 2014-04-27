# RoaveDeveloperTools

[![Build Status](https://travis-ci.org/Roave/RoaveDeveloperTools.svg?branch=master)](https://travis-ci.org/Roave/RoaveDeveloperTools)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Roave/RoaveDeveloperTools/badges/quality-score.png?s=873e09d7bee3555861102ec2c51a911ea8ebd3a4)](https://scrutinizer-ci.com/g/Roave/RoaveDeveloperTools/)
[![Code Coverage](https://scrutinizer-ci.com/g/Roave/RoaveDeveloperTools/badges/coverage.png?s=6fbbfa9a5c3931b72af1d8be11db01aa20310c26)](https://scrutinizer-ci.com/g/Roave/RoaveDeveloperTools/)
[![Dependency Status](https://www.versioneye.com/php/roave:roave-developer-tools/dev-master/badge.png)](https://www.versioneye.com/php/roave:roave-developer-tools/dev-master)
[![Latest Stable Version](https://poser.pugx.org/roave/roave-developer-tools/v/stable.png)](https://packagist.org/packages/roave/roave-developer-tools)
[![License](https://poser.pugx.org/roave/roave-developer-tools/license.png)](https://packagist.org/packages/roave/roave-developer-tools)

**RoaveDeveloperTools** is a set of utilities to inspect and monitor the state of a PHP application's lifecycle.
It currently only works with ZendFramework 2 applications, but Symfony 2 and Laravel 4 adapters are planned.

RoaveDeveloperTools is the successor of [ZendDeveloperTools](https://github.com/zendframework/ZendDeveloperTools/),
and it will likely get merged back into it if it gets enough traction.

## Installation

```sh
php composer.phar require roave/roave-developer-tools:dev-master@DEV
```

Then, in your ZF2 application, enable the module `Roave\DeveloperTools`
