<p align="center">
    <a href="https://payme.uz" target="_blank">
        <img src="https://cdn.paycom.uz/documentation_assets/payme_01.png" height="50px">
    </a>
    <a href="https://click.uz" target="_blank">
        <img src="https://click.uz/wp-content/themes/click_theme/assets/img/logo.png" height="50px">
    </a>
    <a href="https://upay.uz" target="_blank">
        <img src="http://upay.uz/images/upay_logo_new.png" height="50px">
    </a>
    <a href="https://woy-wo.uz" target="_blank">
        <img src="https://woy-wo.uz/themes/woywo/images/content/logo.png" height="50px">
    </a>
    <h1 align="center">Payment module</h1>
    <br>
</p>

Payment migration module for yii2 [Payme.uz](http://payme.uz/) [Click.uz](http://click.uz/) [Upay.uz](http://upay.uz/)  [woy-wo.uz](http://woy-wo.uz/).

[![Total Downloads](https://img.shields.io/packagist/dt/rakhmatov/yii2-payment.svg)](https://packagist.org/packages/rakhmatov/yii2-payment)
[![Maintainability](https://api.codeclimate.com/v1/badges/104774b128e64518058e/maintainability)](https://codeclimate.com/github/irakhmatov/yii2-payment/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/104774b128e64518058e/test_coverage)](https://codeclimate.com/github/irakhmatov/yii2-payment/test_coverage)

DIRECTORY STRUCTURE
-------------------

```
components              contains components
controllers             contains controllers which is handles requests
dto                     contains data transfer objects
exeptions
migrations              contains migrations
models
```


USAGE
-----

add payment module in your configuration file

```
'modules' => [
    ...
    'payment' => [
        'class' => 'rakhmatov\payment\Module'
    ]
    ...
]
```

in application params file add
```
    'paycom' => [
        'login' => 'Paycom',
        'merchat_id' => 'your_merchant_id',
        'key' => 'your_key',
        'test_key' => 'your_test_key',
    ]
```


well, now you can check, for example: 
https://example.com/payment/paycom 
or 
https://example.com/payment/click