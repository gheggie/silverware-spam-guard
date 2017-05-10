# SilverWare Spam Guard Module

[![Latest Stable Version](https://poser.pugx.org/silverware/spam-guard/v/stable)](https://packagist.org/packages/silverware/spam-guard)
[![Latest Unstable Version](https://poser.pugx.org/silverware/spam-guard/v/unstable)](https://packagist.org/packages/silverware/spam-guard)
[![License](https://poser.pugx.org/silverware/spam-guard/license)](https://packagist.org/packages/silverware/spam-guard)

A form spam protection module for [SilverStripe v4][silverstripe-framework].

## Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Issues](#issues)
- [Contribution](#contribution)
- [Attribution](#attribution)
- [Maintainers](#maintainers)
- [License](#license)

## Requirements

- [SilverStripe Framework v4][silverstripe-framework]

## Installation

Installation is via [Composer][composer]:

```
$ composer require silverware/spam-guard
```

## Configuration

As with all SilverStripe modules, configuration is via YAML. An extension to the base `Form` class is
applied via `config.yml`. Configuration is also used to define the default Spam Guard instance via the
SilverStripe dependency injector:

```yaml
SilverStripe\Core\Injector\Injector:
  DefaultSpamGuard:
    class: SilverWare\SpamGuard\Guards\SimpleSpamGuard
    properties:
      name: SimpleGuard
      title: 'Leave this field empty'
      timeLimit: 5
```

The default instance `SimpleSpamGuard` uses a honeypot approach for preventing spam, combined with a minimum form
submission time, defined by the `timeLimit` property.

## Usage

Once installed, you can enable simple spam protection on your forms by using the following code:

```php
$form = Form::create( ... );

if ($form->hasMethod('enableSpamProtection')) {
    $form->enableSpamProtection();
}
```

By using `hasMethod` to check for the spam protection method, instead of `hasExtension`,
we enable interoperability between this extension and the SilverStripe SpamProtection extension
with no changes required to the form code.

### Arguments

The `enableSpamProtection` method accepts an optional array of arguments with the following keys:

- `class` - class of the Spam Guard instance to use
- `name` - name of the Spam Guard form field
- `title` - title of the Spam Guard form field
- `insertBefore` - insert the Spam Guard form field before a field with this name
- `insertAfter` - insert the Spam Guard form field after a field with this name

For example:

```php
if ($form->hasMethod('enableSpamProtection')) {
    $form->enableSpamProtection([
        'class' => CustomSpamGuard::class,
        'name' => 'CustomSpamGuard'
        'title' => 'Tasty Spam',
        'insertAfter' => 'Message'
    ]);
}
```

### Writing your own Spam Guard class

Spam Guard instances must implement the `SilverWare\SpamGuard\Interfaces\SpamGuard` interface. Your
implementation must include the following methods:

- `getFormField()` - answers the form field responsible for spam protection
- `getDefaultName()` - answers the default name for the form field
- `getDefaultTitle()` - answers the default title for the form field

## Issues

Please use the [GitHub issue tracker][issues] for bug reports and feature requests.

## Contribution

Your contributions are gladly welcomed to help make this project better.
Please see [contributing](CONTRIBUTING.md) for more information.

## Attribution

- Inspired by the [SilverStripe SpamProtection module][silverstripe-spamprotection].

## Maintainers

[![Colin Tucker](https://avatars3.githubusercontent.com/u/1853705?s=144)](https://github.com/colintucker) | [![Praxis Interactive](https://avatars2.githubusercontent.com/u/1782612?s=144)](http://www.praxis.net.au)
---|---
[Colin Tucker](https://github.com/colintucker) | [Praxis Interactive](http://www.praxis.net.au)

## License

[BSD-3-Clause](LICENSE.md) &copy; Praxis Interactive

[composer]: https://getcomposer.org
[silverstripe-framework]: https://github.com/silverstripe/silverstripe-framework
[silverstripe-spamprotection]: https://github.com/silverstripe/silverstripe-spamprotection
[issues]: https://github.com/praxisnetau/silverware-spam-guard/issues
