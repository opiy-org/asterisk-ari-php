<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\WebSocketClient\Woketo;

use Nekland\Woketo\Client\{Connection, ConnectorFactory, ConnectorFactoryInterface};
use Nekland\Woketo\Http\Url;
use Nekland\Woketo\Message\MessageHandlerInterface;
use Nekland\Woketo\Rfc6455\{FrameFactory,
    FrameHandler\CloseFrameHandler,
    FrameHandler\PingFrameHandler,
    FrameHandler\RsvCheckFrameHandler,
    FrameHandler\WrongOpcodeFrameHandler,
    MessageFactory,
    MessageProcessor};
use NgVoice\AriClient\Exception\XdebugEnabledException;
use React\EventLoop\{Factory as LoopFactory, LoopInterface};
use function extension_loaded;

/**
 * Modified version of the WebSocketClient provided
 * by the woketo dependency within this library.
 *
 * In order to make the ReactPHP loop resource (used within
 * the nekland/woketo WebSocketClient) available to e.g. Stasis
 * application context, this class provides a public getter
 * for the used loop.
 *
 * @package NgVoice\AriClient\WebSocketClient\Woketo
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 * @author Ahmad Hussain <ahmad@ng-voice.com>
 * @internal
 *
 */
final class ModifiedWoketoWebSocketClient
{
    /**
     * @var Url
     */
    private $url;

    /**
     * @var array
     */
    private $config;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var ConnectorFactoryInterface|null
     */
    private $connectorFactory;

    /**
     * @var LoopInterface
     */
    private $loop;

    /**
     * @var MessageProcessor
     */
    private $messageProcessor;

    /**
     * ModifiedWoketoWebSocketClient constructor.
     *
     * @param string $url Url of the running server
     * @param array $config Configuration List
     * @param ConnectorFactoryInterface|null $connectorFactory Connector Interface
     */
    public function __construct(
        string $url,
        array $config = [],
        ConnectorFactoryInterface $connectorFactory = null
    ) {
        $this->url = new Url($url);
        $this->connectorFactory = $connectorFactory;
        $this->setConfig($config);
    }

    /**
     * Start the woketo web socket client.
     *
     * @param MessageHandlerInterface $handler The message handler for this
     * web socket client
     * @param Connection|null $connection The client connection to the
     * Asterisk REST Interface
     * @param LoopInterface|null $loop The event loop instance
     */
    public function start(
        MessageHandlerInterface $handler,
        Connection $connection = null,
        LoopInterface $loop = null
    ): void {
        if ($this->config['prod'] && extension_loaded('xdebug')) {
            throw new XdebugEnabledException(
                'xdebug is enabled, 
            it\'s a performance issue. Disable that extension 
            or specify "prod" option to false.'
            );
        }

        if ($connection === null) {
            $this->connection = new Connection(
                $this->url,
                $this->getConnectorFactory()->createConnector()->connect(
                    $this->url->getHost() . ':' . $this->url->getPort()
                ),
                $this->getMessageProcessor(),
                $handler,
                $this->loop
            );
        }

        if ($loop === null) {
            $this->loop->run();
        }
    }

    /**
     * Creates a connector factory with the given
     * configuration if none given in the constructor.
     *
     * @return ConnectorFactoryInterface
     */
    private function getConnectorFactory(): ConnectorFactoryInterface
    {
        if ($this->connectorFactory !== null) {
            return $this->connectorFactory;
        }

        $this->connectorFactory = new ConnectorFactory($this->getLoop());
        $this->connectorFactory->setSslOptions($this->config['ssl']);

        $this->connectorFactory->enableDns();
        if (null !== $this->config['dns']) {
            $this->connectorFactory->setDnsServer($this->config['dns']);
        }
        if ($this->url->isSecured()) {
            $this->connectorFactory->enableSsl();
        }

        return $this->connectorFactory;
    }

    /**
     * @inheritDoc
     */
    public function getLoop(): LoopInterface
    {
        if (null !== $this->loop) {
            return $this->loop;
        }

        return $this->loop = LoopFactory::create();
    }

    /**
     * @return MessageProcessor
     */
    private function getMessageProcessor(): MessageProcessor
    {
        if (!empty($this->messageProcessor)) {
            return $this->messageProcessor;
        }

        $this->messageProcessor = new MessageProcessor(
            true,
            new FrameFactory($this->config['frame']),
            new MessageFactory($this->config['message'])
        );

        $this->messageProcessor->addHandler(new PingFrameHandler());
        $this->messageProcessor->addHandler(new CloseFrameHandler());
        $this->messageProcessor->addHandler(new WrongOpcodeFrameHandler());
        $this->messageProcessor->addHandler(new RsvCheckFrameHandler());

        return $this->messageProcessor;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * Set the configuration parameters for this WebSocketClient
     *
     * @param array $config Array of configuration parameters
     *
     * @return self It return the Object itself
     */
    public function setConfig(array $config = []): ModifiedWoketoWebSocketClient
    {
        $this->config = array_merge(
            [
                'frame' => [],
                'message' => [],
                'prod' => false,
                'ssl' => [],
                'dns' => null,
            ],
            $config
        );

        return $this;
    }
}
