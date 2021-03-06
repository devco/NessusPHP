<?php

class AutoLoader
{
    static private $classNames = array();

    /**
     * Store the filename (sans extension) & full path of all ".php" files found
     */
    public static function registerDirectory($dirName, $namespace = '')
    {

        $di = new DirectoryIterator($dirName);
        foreach ($di as $file) {
            if ($file->isDir() && !$file->isLink() && !$file->isDot()) {
                self::registerDirectory($namespace, $file->getPathname());
            } elseif (substr($file->getFilename(), -4) === '.php') {
                $className = substr($file->getFilename(), 0, -4);
                AutoLoader::registerClass($className, $file->getPathname(), $namespace);
            }
        }
    }

    public static function registerClass($className, $fileName, $namespace = '')
    {
        $class = $namespace ? $namespace . '\\' . $className : $className;
        AutoLoader::$classNames[$class] = $fileName;
    }

    public static function loadClass($className)
    {
        if (isset(AutoLoader::$classNames[$className])) {
            require_once(AutoLoader::$classNames[$className]);
        }
    }

}

spl_autoload_register(array('AutoLoader', 'loadClass'));