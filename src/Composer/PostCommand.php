<?php

class PostCommand {

    protected $sourcePath;

    protected $destPath;

    protected $fileList = [];

    public function __construct() {

        $this->sourcePath = dirname( __FILE__, 3 ) . "/config/";
        $this->destPath = getcwd() . "/config/";
        $this->fileList = ['blade-directives', 'menu'];
    }

    public function copyFiles() {

        foreach( $fileList as $file ) {
            $sourceFile = $this->sourcePath . $file . '.php';
            $destFile = $this->destPath . $file . '.php';
            if( ! file_exists( $destFile) ) {
                copy( $sourceFile, $destFile );
            }
        }
    }
}
