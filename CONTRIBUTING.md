## Contribute
I am happy to hear about your ideas. Please use PSR-2 if you want to contribute.

Possible TODO's:

[Asterisk Docker container]

- Restrict origin of ARI to localhost?
  
  - Add 'origin' header in WebSocketClient requests
 

[DEVELOPEMENT]

- TESTING!!!! This is really complicated because a lot of tests depend on incoming JSON objects from
Asterisk... Maybe use Mockery?

- JSON Validation with justinrainbow/json-schema

[Models]

- Add a MissingParams model to /messages? This is only required when the WebSocketClient fails during Startup,
so will we really need it?!

- Check for correct @required annotation in model attributes. Compare them to the .json files in the 
doc/ directory