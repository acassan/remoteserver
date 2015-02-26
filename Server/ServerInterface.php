<?php

namespace RemoteServerBundle\Server;

/**
 * Interface ServerInterface
 * @package RemoteServerBundle\Server
 */
interface ServerInterface
{
    /**
     * Retreive a remote file to local file
     * @param     $localFile
     * @param     $remoteFile
     * @param int $options
     * @return bool
     */
    public function get($localFile, $remoteFile, $options);

    /**
     * Send a local file to remote server
     * @param      $remoteFile
     * @param      $localFile
     * @param null $contentType
     * @return mixed
     */
    public function send($remoteFile, $localFile, $contentType = null);

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

    /**
     * Delete a file on FTP
     * @param $pathToFile
     * @return bool
     * @throws \Exception
     */
    public function delete($pathToFile);

    /**
     * Get files list in folder
     * @param $filePath
     * @return array
     */
    public function getFilesInFolder($filePath);

    /**
     * Create a directory in path
     * @param string $directoryName
     * @param string $path
     * @return bool
     * @throws \Exception
     */
    public function createDirectory($directoryName, $path = "/");

    /**
     * Retrieve file modification time
     * @param $filepath
     * @return mixed
     */
    public function getFileModificationTime($filepath);
}
