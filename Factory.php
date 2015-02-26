<?php

namespace RemoteServerBundle;

use RemoteServerBundle\Server\Ftp;
use RemoteServerBundle\Server\ServerInterface;
use RemoteServerBundle\Server\Sftp;

/**
 * Class Factory
 * @package RemoteServerBundle
 */
Class Factory
{
    /**
     * @param $dsn
     * @return ServerInterface
     * @throws \Exception
     */
    public function createFromDsn($dsn)
    {
        if(strstr($dsn, 'sftp')) {
            $rserver = new Sftp($dsn);
        }
        elseif(strstr($dsn, 'ftp')) {
            $rserver = new Ftp($dsn);
        }
        else {
            throw new \Exception("[RemoteServerFactory] Can not create remote server from dsn: '{$dsn}'");
        }

        return $rserver;
    }

    /**
     * @param $protocol
     * @param array $option
     * @return ServerInterface
     * @throws \Exception
     */
    public function createFromOptions($protocol, array $option)
    {
        switch($protocol) {
            case 'sftp':
                $rserver = new Sftp(array_merge(['protocol' => $protocol, $option]));
                break;
            case 'ftp':
                $rserver = new Ftp(array_merge(['protocol' => $protocol, $option]));
                break;
            default:
                throw new \Exception("[RemoteServerFactory] Can not create remote server for protocol: '{$protocol}'");
        }

        return $rserver;
    }
}
