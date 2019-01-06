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
doc/ directory.
    - Also handle 'null' return values in code, not covered yet! (e.g. $channel->getChannelvars()).
    They throw exceptions right now.
        
- Check lowerCamelCase attributes and switch to lower snake case, otherwithe jsonmapping won't work!

[Bugreport to Asterisk]
- Bridges Client -> createWithId returns a 200 OK when a bridge with the given ID already exists and
is updated through this request. We need to handle this!

