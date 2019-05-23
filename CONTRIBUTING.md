## Contribute
I am happy to hear about your ideas. Please stick to the PSR-2 PHP coding standards if you want to contribute.

Possible TODO's:

[Asterisk Docker container]

- Restrict origin of ARI to localhost?
  - Add 'origin' header to WebSocketClient requests

[Models]

- Also handle 'null' return values in code, not covered yet! (e.g. $channel->getChannelvars()).
    They throw exceptions right now.

- declare(strict_types = 1) in every class.
        
[Testing]

- Edit mocked objects and expect them to receive given parameters ($mock->with(...))

/**
 * Final classes cannot be mocked in phpunit, so this depending library removes the
 * final class tag on-the-fly in order to be able to test those classes.
 * @see https://www.tomasvotruba.cz/blog/2019/03/28/how-to-mock-final-classes-in-phpunit/
 */
 
[README]
 - Recommend to users that they should chunk their bigger application
 contexts into small Application chunks and move them from one app into another.
 Remember this is an asynchronous programming principle. Hard to keep everything in mind!