# Laravel Legacy Encrypter [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/hendeavors/legacy-encrypter/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/hendeavors/legacy-encrypter/?branch=master)

This encryption package provides support for the legacy Mcrypt encrypter used by Laravel 5.0 through 5.2. It is primarily intended to be used to migrate your data to the new OpenSSL based encrypter used in 5.1 through the latest release of Laravel.

#### Usage Example

```php
use Laravel\LegacyEncrypter\McryptEncrypter;

$encrypter = new McryptEncrypter($encryptionKey);

$encrypted = $encrypter->encrypt('I am encrypted!');

$decrypted = $encrypter->decrypt($encrypted);
```
