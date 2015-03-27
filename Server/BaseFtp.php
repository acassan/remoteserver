<?php

namespace RemoteServerBundle\Server;

/**
 * Class BaseFtp
 * @package RemoteServerBundle\Server
 */
Abstract class BaseFtp implements FileServerInterface, ServerInterface
{
    /**
     * FTP Resource
     */
    private $ftp;

    /**
     * @var string
     */
    private $ftp_host;

    /**
     * @var integer
     */
    private $ftp_port;

    /**
     * @var string
     */
    private $ftp_user;

    /**
     * @var string
     */
    private $ftp_password;

    /**
     * @var string
     */
    private $ftp_dir;

    /**
     * @param array $configuration
     */
    public function __construct(array $configuration)
    {
        $this
        ->setFtpHost($configuration['host'])
        ->setFtpPort($configuration['port'])
        ->setFtpUser($configuration['username'])
        ->setFtpPassword($configuration['password'])
        ->setFtpDir($configuration['path']);
    }

    /**
     * Reset the connection
     * @return bool
     */
    public function reset()
    {
        unset($this->ftp);
        $this->ftp = null;

        return true;
    }

    /**
     * @return string
     */
    public function getFtpHost()
    {
        return $this->ftp_host;
    }

    /**
     * @param $host
     * @return $this
     */
    public function setFtpHost($host)
    {
        $this->ftp_host = $host;

        return $this;
    }

    /**
     * @return int
     */
    public function getFtpPort()
    {
        return $this->ftp_port;
    }

    /**
     * @param $ftp_port
     * @return $this
     */
    public function setFtpPort($ftp_port)
    {
        $this->ftp_port = $ftp_port;

        return $this;
    }

    /**
     * @return string
     */
    public function getFtpUser()
    {
        return $this->ftp_user;
    }

    /**
     * @param $ftpUser
     * @return $this
     */
    public function setFtpUser($ftpUser)
    {
        $this->ftp_user = $ftpUser;

        return $this;
    }

    /**
     * @return string
     */
    public function getFtpPassword()
    {
        return $this->ftp_password;
    }

    /**
     * @param $ftpPassword
     * @return $this
     */
    public function setFtpPassword($ftpPassword)
    {
        $this->ftp_password = $ftpPassword;

        return $this;
    }

    /**
     * @return string
     */
    public function getFtpDir()
    {
        return $this->ftp_dir;
    }

    /**
     * @param $ftpDir
     * @return $this
     */
    public function setFtpDir($ftpDir)
    {
        $this->ftp_dir = $ftpDir;

        return $this;
    }

    public function getFtp()
    {
        if(is_null($this->ftp)) {
            $this->connect();
        }

        return $this->ftp;
    }

    /**
     * @param $ftpRessource
     * @return $this
     */
    public function setFtp($ftpRessource)
    {
        $this->ftp = $ftpRessource;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function delete($pathToFile)
    {
        throw new \Exception(sprintf("Function '%s' not implemented in %s class", 'delete()', get_class($this)));
    }

    /**
     * @inheritdoc
     */
    public function getFilesInFolder($path)
    {
        throw new \Exception(sprintf("Function '%s' not implemented in %s class", 'getFilesInFolder()', get_class($this)));
    }

    /**
     * @inheritdoc
     */
    public function createDirectory($directoryName, $path = "/")
    {
        throw new \Exception(sprintf("Function '%s' not implemented in %s class", 'createDirectory()', get_class($this)));
    }

    /**
     * @inheritdoc
     */
    public function getFileModificationTime($filepath)
    {
        throw new \Exception(sprintf("Function '%s' not implemented in %s class", 'getFileModificationTime()', get_class($this)));
    }

    /**
     * @inheritdoc
     */
    public function getFileSize($filepath)
    {
        throw new \Exception(sprintf("Function '%s' not implemented in %s class", 'getFileModificationTime()', get_class($this)));
    }
}
