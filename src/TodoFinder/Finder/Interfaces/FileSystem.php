<?php

namespace NilPortugues\TodoFinder\Finder\Interfaces;

interface FileSystem
{
    /**
     * @param  string   $path
     * @return string[]
     */
    public function getFilesFromPath($path);
}
