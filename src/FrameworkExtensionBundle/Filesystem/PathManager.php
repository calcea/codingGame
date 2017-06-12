<?php

namespace FrameworkExtensionBundle\Filesystem;

class PathManager
{
    /**
     * The directory where the application's public files are stored.
     *
     * @var string
     */
    protected $publicDir;

    /**
     * Manager constructor.
     * @param string $publicDir
     */
    public function __construct($publicDir)
    {
        $this->publicDir = $publicDir;
    }

    /**
     * Returns the absolute path of a public file.
     *
     * @param string $filePath
     *
     * @return string
     */
    public function publicToAbsolute($filePath)
    {
        return $this->publicDir.'/'.$filePath;
    }
}