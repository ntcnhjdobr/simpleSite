<?php
interface PhpResizer_Engine_Interface {
	   
    /**
     * @return void
     * @throws PhpResizer_Exception_Basic
     */
    public function checkEngine();
    
	/**
     * @return boolean
     */
    public function resize ();

}