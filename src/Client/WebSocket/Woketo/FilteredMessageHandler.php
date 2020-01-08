<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Client\WebSocket\Woketo;

use Monolog\Logger;
use Nekland\Woketo\Core\AbstractConnection;
use Nekland\Woketo\Exception\WebsocketException;
use Nekland\Woketo\Message\MessageHandlerInterface;
use NgVoice\AriClient\Client\WebSocket\AbstractWebSocketClient;
use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use NgVoice\AriClient\Helper;

/**
 * Class FilteredMessageHandler tells Asterisk to send only messages to the
 * Stasis application that are actually handled.
 *
 * @package NgVoice\AriClient\WebSocket\Woketo
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class FilteredMessageHandler implements MessageHandlerInterface
{
    protected Logger $logger;

    private AbstractWebSocketClient $abstractWebSocketClient;

    /**
     * RemoteAppMessageHandler constructor.
     *
     * @param AbstractWebSocketClient $abstractWebSocketClient For helpful
     * methods that avoid duplicated code
     * @param Logger|null $logger The logger for the message handler
     */
    public function __construct(
        AbstractWebSocketClient $abstractWebSocketClient,
        Logger $logger = null
    ) {
        $this->abstractWebSocketClient = $abstractWebSocketClient;

        if ($logger === null) {
            $logger = Helper::initLogger(self::class);
        }

        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     *
     * On connection to the web socket, we tell Asterisk only to send messages we are
     * actually handling in our application. This will increase performance.
     *
     * @throws AsteriskRestInterfaceException In case the connection handler logic fails
     */
    public function onConnection(AbstractConnection $connection): void
    {
        $this->logger->info(
            sprintf(
                "Successfully connected to Asterisk web socket server '%s'",
                $connection->getIp()
            )
        );

        $this->abstractWebSocketClient->onConnectionHandlerLogic();
    }

    /**
     * Every incoming message from Asterisk will be handled within
     * the provided StasisApplicationInterface
     *
     * @inheritdoc
     *
     * @param string $data The message from the Asterisk web socket server.
     * @param AbstractConnection $connection Representation of the connection
     * to a web socket server
     *
     * @return void
     */
    public function onMessage(string $data, AbstractConnection $connection): void
    {
        $this->logger->debug(
            sprintf(
                "Asterisk web socket server '%s' sent raw message: '%s'",
                $connection->getIp(),
                $data
            ),
            [__FUNCTION__]
        );

        $this->abstractWebSocketClient->onMessageHandlerLogic($data);
    }

    /**
     * @inheritdoc
     */
    public function onDisconnect(AbstractConnection $connection): void
    {
        $this->logger->warning(
            "Connection to Asterisk on address '{$connection->getIp()}' disconnected.",
            [__FUNCTION__]
        );
    }

    /**
     * @inheritdoc
     *
     * @throws WebsocketException When something goes wrong during the web socket
     * connection.
     */
    public function onError(
        WebsocketException $websocketException,
        AbstractConnection $connection
    ): void {
        $this->logger->error(
            sprintf(
                "Error occurred on web socket connection '%s'."
                . "Error Code: '%s' | Error message: '%s'",
                $connection->getIp(),
                (string) $websocketException->getCode(),
                $websocketException->getMessage()
            ),
            [__FUNCTION__]
        );
        throw $websocketException;
    }

    /**
     * @inheritDoc
     */
    public function onBinary(string $data, AbstractConnection $connection): void
    {
        // Binary received never
    }
}
