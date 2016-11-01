# Facebook Messenger PHP Wrapper

This package is a wrapper around the majority of the functionality of the Facebook Messenger platform. A list of features not yet implemented is below.

This package is still in development; so please do submit pull requests / issues you are having.

## Installation
Just use compser to bring it in.
```sh
composer require davidpiesse/facebook_messenger_php
```
Currently we are in dev mode so you may need to set ```minimum-stability:"dev"``` in your composer.json

## Demo
A demo project (Laravel based) is [here](https://github.com/davidpiesse/messenger-bot)
In the meantime you can interact with a demo ChatBot created using this wrapper.

Search for **@laravelmessengerbot** in Facebook messenger and you can test a load of the function.
Or go here https://www.facebook.com/laravelmessengerbot/

## Todo
Things still to implement
  - User Profile
  - All Airline Templates
  - Sending of a file stream
  - Payments

Current dependencies are GuzzleHttp/Guzzle, rappasoft/laravel-helpers and illuminate/http. These allow the package to make easy requests to the FB Messenger API and also deal with arrays in a super amazing way.

## License
MIT

## Who to call for help
Just add an issue or send me an email at piesse [at] gmail [dot] com or on Twitter @mapdev

#Sending Messages
## Usage
To send messages to a user create an instance of the Messenger class and insert your token
```php
$messenger = new Messenger($token);
```
and then to send a text message
```php
$messenger->sendMessage(new TextMessage('Foo Bar'),'recipient_id');
```
[Facebook API Link](https://developers.facebook.com/docs/messenger-platform/send-api-reference)

Still writing this...

# Incoming Webhook
For Facebook Messenger you provide a webhook URL for their API to contact your server when certain events occur. [-Link-](https://developers.facebook.com/docs/messenger-platform/webhook-reference)

Most of these revolve around incoming messages from a user; be it a text message, attachment, postback etc. these are all handled by the **Callback** object.

Pass in an array of data from the post request {in Laravel use ``` $request->all()```}
```php
$callback = new Callback($request->all());
```
The data incoming should look similar to this
```json
{
  "object":"page",
  "entry":[
    {
      "id":"PAGE_ID",
      "time":1458692752478,
      "messaging":[
        {
          "sender":{
            "id":"USER_ID"
          },
          "recipient":{
            "id":"PAGE_ID"
          },
          ...
        }
      ]
    }
  ]
}  
```
The ```$callback``` object parses all this information and allows you to easily retrieve it and determine what to do with it.

## Structure
Below is a guide on how to find the data you want in the Callback object
Within a normal Facbook Webhook POST request are two top level parameters:
+```object``` (always  = ```'page'```)
+```entry``` (almost always one & a collection of ```Entry``` objects)

To get at the data you must iterate ```$callback->entries``` to make sure you do not miss a batch of messages.

The Callback also has three methods ```textMessages()```, ```postbackMessages()```, and ```attachmentMessages()```. These give you quick access to an array of ```EntryMessages``` of these specific types.

Within an 'entry' are a couple of properties and a array of ```EntryMessages```
+ ```id``` (Page ID)
+ ```time``` (Timestamp)
+ ```messaging``` (Array of entry messages)

```Entry``` has the first two properties plus a ```message``` array (Laravel Collection).
This is the array of ```EntryMessages```.

This array of entry messages is where all the real information is.
There are two main parts to it. THe shell (EntryMessage) contains the ```sender_id``` and ```recipient_id``` along with a ```timestamp```. 

It also provides you a set of boolean return methods to determine what type of message it is.
+ ```isText()```
+ ```isPostback()```
+ ```isRead()```
+ ```isDelivered()```
+ ```isAuthentication()```
+ ```isAccountLinking()```
+ ```isEcho()```

Each of these allow you to filter the type of message it is and access its ```$entry_message->message``` or other dynamic property appropriately.

### Read
If the message is of type Read then ```$entry_message->read``` is set and is of type ```Read```
##### Properties
+ ```watermark```
+ ```seq```

### Delivered
If the message is of type Read then ```$entry_message->delivery``` is set and is of type ```Delivered```
##### Properties
+ ```watermark```
+ ```seq```
+ ```mids[]```

### Authentication
If the message is of type Read then ```$entry_message->authentication``` is set and is of type ```Authentication```
##### Properties
+ ```ref```

### Account Linking
If the message is of type Read then ```$entry_message->account_linking``` is set and is of type ```AccountLinking```
##### Properties
+ ```status```
+ ```authorization_token```
+ ```linked``` (bool)
+ ```unlinked``` (bool)

### Postback
If the message is of type Read then ```$entry_message->postback``` is set and is of type ```POstback```
##### Properties
+ ```payload```

### Message
If the message is of type Read then ```$entry_message->message``` is set and is of type ```Message```
##### Properties
+ ```mid```
+ ```seq```
+ ```isText``` (bool)
+ ```isSticker``` (bool)
+ ```hasAttachments``` (bool)
+ ```text```
+ ```quick_reply```
+ ```attachments[]```
    
### Echo
The same as ```$entry_message->message``` except with some more properties attached.
##### Additional Properties
+ ```app_id```
+ ```mid```
+ ```metadata``` (bool)
+ ```seq``` (bool)


# Examples
Here are some code snippets to get you started

```php
//create a callback object
$callback = new Callback($request->all())
```

```php
//get all textmessages from the callback (regardless of entry or EntryMessage)
$textmessages = $callback->textMessages(); //returns Entry Message collection
```

```php
//check if EntryMessage $entrymessage is a postback and return the payload string
if($entrymessage->isPostback)
    return $entrymessage->postback->payload;
```

```php
//get URL of an image attachment sent to you 0- assuming onely one attachment and entry etc.
if($entrymessage->isMessage){
    if($entrymessage->message->hasAttachments && ($entrymessage->message->attachments[0]->isImage){
        $image_url = $entrymessage->message->attachments[0]->url;
    }
}
```

As Laravel Collection is iuncluded it is a great way to delve into your callback easily
```php
$callback = new Callback($request->all())
$callback->entries->each(function ($entry){
    //for each entry access their entry messages
    $entry->messages->each(function($entrymessage){
        //get sender_id to send a message back
        $sender_id = $entrymessage->sender_id;
        //for each entry message check is a postback or a message
        if($entrymessage->isPostback){
            //Do something with the postback
            $payload = $entrymessage->postback->payload;
        }else if($entrymessage->isMessage){
            //do somethingwith the message
            $message = $entrymessage->message;
        }
    });
});
```






