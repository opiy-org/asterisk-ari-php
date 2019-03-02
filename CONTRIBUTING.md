## Contribute
I am happy to hear about your ideas. Please use PSR-2 if you want to contribute.

Possible TODO's:

[Asterisk Docker container]

- Restrict origin of ARI to localhost?
  - Add 'origin' header in WebSocketClient requests

[Models]

- Also handle 'null' return values in code, not covered yet! (e.g. $channel->getChannelvars()).
    They throw exceptions right now.
        
[Bugreport to Asterisk]
- Bridges Client -> createWithId returns a 200 OK when a bridge with the given ID already exists and
is updated through this request. We need to handle this!

[Testing]
- We expect the JSONs to look like the mocked ones. Including Lists ob Objects. But do they really look like this?
