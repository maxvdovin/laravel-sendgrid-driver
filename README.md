Laravel SendGrid Driver
====

Extend [s-ichikawa/laravel-sendgrid-driver](https://github.com/s-ichikawa/laravel-sendgrid-driver) with optional ability to write all requests and responses to log file.

## Install
Add repo to repositories section to your composer.phar

    ```json
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/maxvdovin/laravel-sendgrid-driver.git"
        }
    ]
    ```

and

    ```json
    "require": {
        "s-ichikawa/laravel-sendgrid-driver": "dev-logging",
    },
    ```

# Configuration

```php
$app['config']->set('services.sendgrid.logging', true);
```