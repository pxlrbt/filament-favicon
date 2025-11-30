![header](./.github/resources/pxlrbt-favicon.png)


# Filament Favicon

[![Latest Version on Packagist](https://img.shields.io/packagist/v/pxlrbt/filament-favicon.svg?include_prereleases)](https://packagist.org/packages/pxlrbt/filament-favicon)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE.md)
![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/pxlrbt/filament-favicon/code-style.yml?branch=main&label=Code%20style&style=flat-square)
[![Total Downloads](https://img.shields.io/packagist/dt/pxlrbt/filament-favicon.svg)](https://packagist.org/packages/pxlrbt/filament-favicon)


## Installation via Composer

| Plugin Version | Filament Version | PHP Version |
|----------------|------------------|-------------|
| 1.x            | ^4.x        | \> 8.0      |

```bash
composer require pxlrbt/filament-favicon
```

## Column

## Entry


## Contributing

If you want to contribute to this packages, you may want to test it in a real Filament project:

- Fork this repository to your GitHub account.
- Create a Filament app locally.
- Clone your fork in your Filament app's root directory.
- In the `/filament-favicon` directory, create a branch for your fix, e.g. `fix/error-message`.

Install the packages in your app's `composer.json`:

```json
"require": {
    "pxlrbt/filament-favicon": "dev-fix/error-message as main-dev",
},
"repositories": [
    {
        "type": "path",
        "url": "filament-favicon"
    }
]
```

Now, run `composer update`.

## Credits
- [Dennis Koch](https://github.com/pxlrbt)
- [All Contributors](../../contributors)
