<?php

/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 */

/**
 * [GENERAL]
 * - We need a LICENCE! Also see if the used libraries are free to integrate.
 * - Error logs should really be exceptions so the person using the library has to handle them.
 *   - But really also the guzzle exceptions? They make code in the class that uses the AriManager really messy.
 *
 * [Writing a wrapping Asterisk application with Laravel]
 * - Think of a simple turn key setup (which also includes to start and supervise the RabbitMQ workers)
 *   - How can we automatically install stuff? Dockerfile?
 * - PDO transactional for concurrent conference database calls (avoids two database users read/write because
 *   of optimistic database usage).
 * - Integrate Swagger for php
 * - Integrate Laravel Nova :)
 *
 * [DEVELOPEMENT]
 * - Mockery
 * - Pact
 *
 * [composer.json]
 * - Rename "autoload" namespace from "AriStasisApp" to something better
 * - Move test frameworks to require-dev
 *
 * [Asterisk]
 * - Restrict origin of ARI to localhost.
 *   - Add this to 'origin' header in AriWebSocketClient
 *
 * [RabbitMQ]
 * - What if someone is already in a call and has to be pushed into a conference that exists elsewhere?
 *   - Have a deeper thought about bridging via ARI to another asterisk (in a cluster)
 */