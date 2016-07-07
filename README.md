# Facebook Messenger PHP Wrapper

This package is a wrapper around the majority of the functionality of the Facebook Messenger platform. A list of features not yet implemented is below.

This package is still in development; so please do submit pull requests / issues you are having.

## Installation
Just use compser to bring it in.
```sh
composer require davidpiesse/facebook_messenger_php
```
## Usage
To use it just call the Messenger class and insert your token
```php
$messenger = new Messenger($token);
```
and then to send a text message
```php
$messenger->sendMessage(new TextMessage('Foo Bar'),'recipient_id);
```

## Demo
A demo project (Laravel based) will be released soon.
In the meantime you can interact with a demo ChatBot created with this wrapper.

Search for **@laravelmessengerbot** in Facebook messenger and you can test a load of the function.

## Todo
Things still to implement
  - User Profile
  - Receipt Template
  - All Airline Templates
  - Sending of a file stream

Current dependencies are GuzzleHttp/Guzzle and TightenCo/collect. These allow the pacckage to make easy requests to the FB Messenger API and also deal with arrays in a super amazing way.

## License
MIT

## Who to call for help
Just add an issue or send me an email at piesse [at] gmail [dot] com or on Twitter @mapdev
