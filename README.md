yii2-jsonvalidator
=

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```bash
composer require mirkhamidov/yii2-jsonvalidator "@dev"
```

or add

```
"mirkhamidov/yii2-jsonvalidator": "*"
```

to the require section of your `composer.json` file.


Usage
-----

```php
/** @inheritdoc */
public function rules()
{
    return ArrayHelper::merge(parent::rules(), [
        ...,
        ['params_data', \mirkhamidov\validators\JsonValidator::class],
        ...,
    ]);
}
```