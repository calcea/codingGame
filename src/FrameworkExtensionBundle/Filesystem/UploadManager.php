<?php

namespace FrameworkExtensionBundle\Filesystem;


use FrameworkExtensionBundle\Filesystem\PathManager;
use Symfony\Component\Filesystem\Filesystem;

class UploadManager
{

    /**
     * Document upload directory.
     *
     * @var string
     */
    protected $documentsUploadDir;

    /**
     * FileSystem.
     *
     * @var Filesystem
     */
    protected $fileSystem;

    /**
     * File manager service.
     *
     * @var PathManager
     */
    protected $fileManager;

    /**
     * UploadManager constructor.
     * @param string $documentsUploadDir
     */
    public function __construct($documentsUploadDir,$fileManager)
    {
        $this->documentsUploadDir = $documentsUploadDir;
        $this->fileManager = $fileManager;
        $this->fileSystem = new Filesystem();
    }

    /**
     * Set documentUploadDir.
     *
     * @param string $documentsUploadDir
     */
    public function setDocumentUploadDir($documentsUploadDir)
    {
        $this->documentsUploadDir = $documentsUploadDir;
    }

    /**
     * Upload document function.
     *
     * @param $object
     * @param string $getFile
     * @param string $setFile
     * @param string $setFileUrl
     * @param string $getOldFileUrl
     * @param string $namePath
     */
    public function setDocumentUrl($object, $getFile, $setFile, $setFileUrl, $getOldFileUrl, $namePath)
    {
        $file = $object->$getFile();

        if (null == $file) {
            return;
        }
        // obtinem noua locatie si noul nume
        $filePath = $this->documentsUploadDir . '/' . $namePath . '-' . uniqid('', true) . '.' . $file->guessExtension();

        // muta fisierul
        $fileDir = $this->fileManager->publicToAbsolute(dirname($filePath));
        $fileName = basename($filePath);
        $file->move($fileDir, $fileName);

        $object->$setFile(null);

        // setez url noului fisier pe entitate
        $object->$setFileUrl($filePath);

        // sterge vechiul document
        $oldFileUrl = $object->$getOldFileUrl();
        if (!empty($oldFileUrl)) {
            $this->fileSystem->remove($this->fileManager->publicToAbsolute($oldFileUrl));
        }
    }

    /**
     * Remove document with path.
     *
     * @param $object
     * @param string $getFileUrl
     */
    public function removeDocument($object,$getFileUrl)
    {
        $logo = $object->$getFileUrl();
        if (null === $logo) {
            return;
        }

        $filePath = $this->fileManager->publicToAbsolute($object->$getFileUrl());
        $this->fileSystem->remove($filePath);
    }
}