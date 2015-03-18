<?php

namespace RemoteServerBundle\Server;

/**
 * Class Ftp
 * @package RemoteServerBundle\Server
 */
Final Class Ftp extends BaseFtp
{
    /**
     * @throws \Exception
     */
    public function connect()
    {
        $this->setFtp(ftp_connect($this->getFtpHost()));

        if (true !== ftp_login($this->getFtp(), $this->getFtpUser(), $this->getFtpPassword())) {
            throw new \Exception("Can't log in to ". $this->getFtpHost() ." with user ". $this->getFtpUser());
        }

        $this->setPassiveMode();
    }

    /**
     * @inheritdoc
     */
    public function get($localFile, $remoteFile, $mode = FTP_ASCII)
    {
        if(false === ftp_get($this->getFtp(), $localFile, $remoteFile, $mode)) {
            throw new \Exception("Unable to get file:". $remoteFile);
        }

        return true;
    }

    /**
     * @param $localFile
     * @param $remoteFile
     * @param int $mode
     * @return bool
     */
    public function getAsynchronously($localFile, $remoteFile, $mode = FTP_ASCII)
    {
        $localFilRes = fopen($localFile, 'w');
        return ftp_nb_fget($this->getFtp(), $localFilRes, $remoteFile, $mode);
    }

    /**
     * @return int
     */
    public function AsynchronouslyContinue()
    {
        return ftp_nb_continue($this->getFtp());
    }

    /**
     * @inheritdoc
     */
    public function send($remoteFile, $localFile, $mode = FTP_BINARY)
    {
        if(false === ftp_put($this->getFtp(),$remoteFile,$localFile, $mode)) {
            throw new \Exception("Cant upload file on FTP server");
        }

        return true;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function setActiveMode()
    {
        if (false === ftp_pasv($this->getFTP(), false)) {
            throw new \Exception("Can't switch to ACTIVE mode in ". $this->getFtpHost());
        }

        return true;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function setPassiveMode()
    {
        if (false === ftp_pasv($this->getFtp(), true)) {
            throw new \Exception("Can't switch to PASSIVE mode in ". $this->getFtpHost());
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function getFilesInFolder($filePath)
    {
        $result = ftp_nlist($this->getFtp(), $filePath);
        if(false === $result) {
            throw new \Exception("Unable to list file in folder: ". $filePath);
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function close()
    {
        if(!ftp_close($this->getFtp())) {
            throw new \Exception("Unable to close FTP connection");
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function createDirectory($directoryName, $path = "/")
    {
        foreach($this->getFilesInFolder($path) as $element) {
            if($element === $directoryName) {
                return true;
            }
        }

        if(!ftp_chdir($this->getFtp(), $path)) {
            throw new \Exception("Cannot change current directory to ". $path);
        }

        if(false === ftp_mkdir($this->getFtp(), $directoryName)) {
            throw new \Exception("Cannot create directory ". $directoryName);
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function delete($pathToFile)
    {
        if(!ftp_delete($this->getFtp(), $pathToFile)) {
            throw new \Exception("Unable to delete FTP file: ". $pathToFile);
        }

        return true;
    }

    /**
     * @param $oldName
     * @param $newName
     * @return bool
     * @throws \Exception
     */
    public function rename($oldName, $newName) {
        if(!ftp_rename($this->getFtp(), $oldName, $newName)) {
            throw new \Exception(sprintf("Error when trying to rename file %s > %s", $oldName, $newName));
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function getFileModificationTime($filepath)
    {
        $fileMdtm = ftp_mdtm($this->getFtp(), $filepath);

        if($fileMdtm == -1) {
            throw new \Exception(sprintf("Error when trying to get file modification time"));
        }

        return $fileMdtm;
    }

    /**
     * @inheritdoc
     */
    public function getFileSize($filepath)
    {
        $filesize = ftp_size($this->getFtp(), $filepath);

        if($filesize == -1) {
            throw new \Exception(sprintf("Error when trying to get file size"));
        }

        return $filesize;
    }
}
