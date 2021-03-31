# Silocale by @przeslijmi

Silocale is simplest localization tool for PHP application.

## Usage example.
```
use Przeslijmi\Silocale\Silocale;

// Create Silocale object to use - and give uris where files with locales are beeing held.
// If language `en-us` is used file `en-us.php` will be searched in every location and required if present.
$loc = new Silocale([
    'dirA/',
    'vendor/app/locale/dirB/',
], 'en-us');

// Get translation for given message id.
$loc->get('message.id.to.get.translation');
```

### Conctructor second parameter

If you ignore second parameter `Accept-Language` header is used.

