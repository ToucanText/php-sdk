<img src="https://www.toucantext.com/wp-content/uploads/2018/10/ToucanText-Logo.svg" alt="ToucanText" width="250px">

ToucanText PHP SDK
==================

*This library requires a minimum PHP version of 5.5*

This is the PHP SDK library to use ToucanText's API. To use this, you'll need a ToucanText account and have access to your API credentials. Sign up for your [free trial at toucantext.com][signup].

* [Installation](#installation)
* [Usage](#usage)
* [Examples](#examples)
* [Coverage](#api-coverage)

Installation
------------

To use the PHP SDK, [create a ToucanText account][signup].

To install the PHP client to your project, we recommend using [Composer](https://getcomposer.org).

```bash
composer requiure toucantext/php-sdk
```
> You don't need to clone this repository to use the library in your own projects, you can use Composer to install it from Packagist.

If you're new to Composer, here are some resources that you may find useful:

* [Composer's Getting Started page](https://getcomposer.org/doc/00-intro.md) from Composer project's documentation
* [A Beginner's Guide to Composer](https://scotch.io/tutorials/a-beginners-guide-to-composer) from ScotchBox

Instantiating the SDK Client
----------------------------

Pass in the configuration to the client:

```php
$config = [
  'username' => '{your_api_username}',
  'password' => '{your_api_password}'
];

$toucan = new ToucanText\Client($config);
```

**Note:** If you are unsure what your 'api_username' or 'api_password' are, contact info@toucantext.com.

Using the Client
----------------

### Getting all messages

To return a list of all your messages (both inbound and delivery receipts):

```php
// return all your messages
$toucan->messages->all();
```

By default, this returns a maximum of 25 messages but does NOT acknowledge them. To override this, pass the following parameters (the first denotes whether to acknowledge messages; the second for the maximum number of messages to return): 

```php
// return 15 messages maximum and acknowledge them
$toucan->messages->all(true, 15);
```

### Getting inbound messages or delivery receipts only

To return a list of inbound messages or delivery receipts:

```php
// return only inbound messages
$toucan->messages->get('messagesOnly');

// return only delivery receipts
$toucan->messages->get('dlrsOnly');
```

By default, this returns a maximum of 25 inbound messages or delivery receipts but does **NOT** acknowledge them. To override this, pass the following parameters (the second denotes whether to acknowledge messages; the third for the maximum number of messages to return): 

```php
// return 15 inbound messages maximum and acknowledge them
$toucan->messages->get('messagesOnly', true, 15);

// return 15 delivery receipts maximum and acknowledge them
$toucan->messages->get('dlrsOnly', true, 15);
```

### Sending a message

To send a message you, can call the following:

```php
// send a message
$message = [
  'destinationAddress' => '{the_destination_address}',
  'message => '{your_message}'
];

$toucan->messages->send($message);
```

You can also set a source address and request a delivery receipt:

```php
// send a message with source address and request delivery receipt
$message = [
  'sourceAddress' => '{your_source_address}',
  'destinationAddress' => '{the_destination_address}',
  'message' => '{your_message}',
  'deliveryReceipt' => true
];

$toucan->messages->send($message);
```

### Acknowledging delivery receipts and messages

When you retrieve your inbound messages or delivery receipts, there is a MbStorageId element within the response of the query. This ID can be
used to acknowledge messages and delivery receipts individually.

To acknowledge a message or delivery receipt create an array with the ID's to acknowledge and then call the following:

```php
// array of message ID's to acknowledge
$messages = [
    245, 4564, 456
];

$toucan->messages->acknowledge($messages);
```

Handling Exceptions
-------------------

Aside from errors that may occur due to the call, there may be other Exceptions thrown. To handle them, wrap your call in a try catch block:

```php
try {
  $toucan->messages->all();
} catch (Exception $e) {
  // do something with $e
}
```

License
-------

This library is released under the [MIT License][license].

[signup]: https://www.toucantext.com/sign-up/
[license]: LICENSE.md
