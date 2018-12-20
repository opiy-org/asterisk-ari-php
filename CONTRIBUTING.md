## Contribute
I am happy to hear about your ideas. Please use PSR-2 if you want to contribute.

Possible TODO's:

[composer.json]

- Rename "autoload" namespace from "AriStasisApp" to something better?!


[Docker container]

- Restrict origin of ARI to localhost.
  
  - Add 'origin' header in WebSocketClient requests
 

[DEVELOPEMENT]

- TESTING!!!! This is really complicated because a lot of tests depend on incoming JSON objects from
Asterisk... Maybe use Mockery?

- JSON Validation with justinrainbow/json-schema

- Add a MissingParams model to /messages? This is only required when the WebSocketClient fails during Startup so wayne?!

- @required annotation for models