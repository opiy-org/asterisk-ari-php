<?php
/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 */

use AriStasisApp\BasicStasisApp;

require_once '../vendor/autoload.php';

/**
 * Class ExampleStasisApp
 *
 * You cannot break anything while writing your own stasis app. Simply extend a BasicStasisApp class and handle
 * the events in your handleEvents() function.
 *
 */
class ExampleStasisApp extends BasicStasisApp
{
    /**
     * {@inheritdoc}
     */
    function handleEvents()
    {
        $this->handle('StasisStart', function()
        {
            $this->logger->info("Stasis Application started. Calling Alice.");
            $this->channels->originate('SIP/Alice');
        });

        $this->handle('StasisEventName', function($eventBody)
        {
            $channelId = $eventBody->channelId;
            $channelDetails = $this->channels->get($channelId);
            $this->logger->debug("Details of the Asterisk channel {$channelId}: {$channelDetails}");

            $asteriskInfo = $this->asterisk->getInfo();
            $this->logger->info("Asterisk Info: {$asteriskInfo}");
        });

        $this->handle('OtherStasisEventName', function()
        {
            $bridges = $this->bridges->list();
            $this->logger->info("All bridges on the Asterisk: {$bridges}");
        });

        $this->handle('StasisEnd', function()
        {
            $this->stop();
            $this->logger->info("Terminated");
            exit();
        });

        // And so on...
    }
}

/**
 * Start your stasis app with a script that simply calls
 *
 *     $app = new ExampleStasisApp();
 *     $app->run();
 *
 * You can then hand that script over to a monitoring app e.g. 'supervisor'.
 * supervisor is easy to use an will restart your stasis app in case it has crashed.
 *
 * !! Please keep in mind, that your stasis app will run in the background forever as long as the WebSocket
 * connection is alive if you don't close it yourself !!
 */
$app = new ExampleStasisApp();
$app->run();