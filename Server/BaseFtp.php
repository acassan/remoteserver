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
     * @var boolean
     */
    private $ftp_dsn;

    /**
     * Constructor
     */
    public function __construct()
    {

    }

    /**
     * Extract and process dsn
     * @param $protocol
     * @param array $dsnParameters
     * @return bool
     * @throws \Exception
     */
    public function buildFromParameters($protocol, array $dsnParameters)
    {
        if(!isset($dsnParameters['user'])) {
            throw new \Exception("[RemoteServerBaseFTP] Missing 'user' parameters");
        }

        if(!isset($dsnParameters['password'])) {
            throw new \Exception("[RemoteServerBaseFTP] Missing 'password' parameters");
        }

        if(!isset($dsnParameters['host'])) {
            throw new \Exception("[RemoteServerBaseFTP] Missing 'host' parameters");
        }

        if(!isset($dsnParameters['directory'])) {
            $dsnParameters['directory'] = '/';
        }

        $this
            ->setFtpUser($dsnParameters['user'])
            ->setFtpPassword($dsnParameters['password'])
            ->setFtpHost($dsnParameters['host'])
            ->setFtpDir($dsnParameters['directory']);

        $dsn = sprintf("%s://%s:%s@%s%s",
            $protocol,
            $dsnParameters['user'],
            $dsnParameters['password'],
            $dsnParameters['host'],
            $dsnParameters['directory']
        );

        $this->setFtpDsn($dsn);

        return true;
    }

    /**
     * Extract and process dsn
     * @param $dsn
     * @return bool
     * @throws \Exception
     */
    public function buildFromDsn($dsn)
    {
        preg_match("#s?ftp://(.+):(.+)@([^/]+)(/(.*))?#", $dsn, $dsnExtract);

        if(count($dsnExtract)< 4) {
            throw new \Exception("Incorrect dsn provided: ". $dsn);
        }

        $this->setFtpDsn($dsn)
            ->setFtpUser($dsnExtract[1])
            ->setFtpPassword($dsnExtract[2])
            ->setFtpHost($dsnExtract[3])
            ->setFtpDir("/");

        // If FTP dir entered
        if(array_key_exists(4, $dsnExtract)) {
            $this->setFtpDir($dsnExtract[4]);
        }

        return true;
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
     * @return bool
     */
    public function getFtpDsn()
    {
        return $this->ftp_dsn;
    }

    /**
     * @param $dsn
     * @return $this
     */
    public function setFtpDsn($dsn)
    {
        $this->ftp_dsn = $dsn;

        return $this;
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
