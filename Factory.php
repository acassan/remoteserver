<?php

namespace RemoteServerBundle;

use RemoteServerBundle\Server\Ftp;
use RemoteServerBundle\Server\ServerInterface;
use RemoteServerBundle\Server\Sftp;
use RemoteServerBundle\Server\XmlRpc;

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
            $rserver = new Sftp();
        }
        elseif(strstr($dsn, 'ftp')) {
            $rserver = new Ftp();
        }
        else {
            throw new \Exception("[RemoteServerFactory] Can not create remote server from dsn: '{$dsn}'");
        }

        $rserver->buildFromDsn($dsn);

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
                $rserver = new Sftp();
                break;
            case 'ftp':
                $rserver = new Ftp();
                break;
            case 'xmlrpc':
                $rserver = new XmlRpc();
                break;
            default:
                throw new \Exception("[RemoteServerFactory] Can not create remote server for protocol: '{$protocol}'");
        }

        $rserver->buildFromParameters($protocol, $option);

        return $rserver;
    }

    public function createRemoteServer($protocol)
    {
        switch($protocol) {
            case 'xmlrpc':
        }
    }
}
