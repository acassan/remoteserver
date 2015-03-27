<?php

namespace RemoteServerBundle\Server;

/**
 * Class Sftp
 * @package RemoteServerBundle\Server
 */
Final Class Sftp extends BaseFtp
{
    /**
     * @inheritdoc
     */
    public function connect()
    {
        $this->setFtp(ssh2_connect($this->getFtpHost(), $this->getFtpPort()));
        $result = ssh2_auth_password($this->getFtp(), $this->getFtpUser(), $this->getFtpPassword());

        if (false === $result) {
            throw new \Exception("Can't log in to ". $this->getFtpHost());
        }
    }

    /**
     * @inheritdoc
     */
    public function get($localFile, $remoteFile, $mode = FTP_ASCII)
    {
        $sftp   = ssh2_sftp($this->getFtp());

        if(false === copy("ssh2.sftp://$sftp".$remoteFile, $localFile)) {
            throw new \Exception("Unable to get file:". $remoteFile);
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function send($remoteFile, $localFile, $contentType = null)
    {
        $sftp   = ssh2_sftp($this->getFTP());

        if(false === copy($localFile, "ssh2.sftp://$sftp".$remoteFile)) {
            throw new \Exception("Cant upload file on FTP server");
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function close()
    {
        return $this->reset();
    }
}
