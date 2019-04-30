# Mailing

Discover mailserver configuration from email address

## Installation

Install the package via composer

```bash
composer require fidelosoftware/mailing
```

## Usage

```php
$oMailServer = new \FideloSoftware\Mailing\AutoConfig\MailServer();

$oConfig = $oMailServer->discover(new \FideloSoftware\Mailing\Email('your@email.address'));
```