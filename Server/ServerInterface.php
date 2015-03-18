<?php

namespace RemoteServerBundle\Server;

/**
 * Interface ServerInterface
 * @package RemoteServerBundle\Server
 */
interface ServerInterface
{
    /**
     * Connect to server
     * @return mixed
     */
    public function connect();

    /**
     * Reset the current connection
     * @return boolean
     */
    public function reset();

    /**
     * Close the connection
     * @return bool
     * @throws \Exception
     */
    public function close();
}
