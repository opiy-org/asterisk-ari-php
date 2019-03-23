## Contribute
I am happy to hear about your ideas. Please stick to the PSR-2 PHP coding standards if you want to contribute.

Possible TODO's:

[Asterisk Docker container]

- Restrict origin of ARI to localhost?
  - Add 'origin' header to WebSocketClient requests

[Models]

- Also handle 'null' return values in code, not covered yet! (e.g. $channel->getChannelvars()).
    They throw exceptions right now.
        
[Testing]

- Edit mocked objects and expect them to receive given parameters ($mock->with(...))