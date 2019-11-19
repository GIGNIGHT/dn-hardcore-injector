<?php

use php\lang\System;
use php\windows\DFFI;

/**
 * Class Injector
 * 
 * @author GIGNIGHT
 * @link gignight.ru
 */
class Injector
{

    /**
     * @var DFFI
     */
    private $_injector;
    
    /**
     * init
     */
    public function __construct()
    {
        if (System::getProperty("os.arch") == "x64")
            $this->_injector = new DFFI("lib/injector64");
        else
            $this->_injector = new DFFI("lib/injector");
    }

    /**
     * Inject DLL by Process ID
     * 
     * @param int $pid
     * @param string $dllName
     * 
     * @return int
     */
    public function injectByPID($pid, $dllName)
    {
        return $this->_injector->injectByPID("int", [$pid, $dllName], ["int", "string"]);
    }
    
    /**
     * Inject DLL by Process Name
     * 
     * @param string $pName
     * @param string $dllName
     * 
     * @return int
     */
    public function inject($pName, $dllName)
    {
        return $this->_injector->inject("int", [$pName, $dllName], ["string", "string"]);
    }
    
    /**
     * Unlink DLL from PEB
     * 
     * @param string $dll
     * 
     * @return void
     */
    public function unlinkModuleFromPEB($dll)
    {
        return $this->_injector->UnlinkModuleFromPEB("void", [$dll], ["string"]);
    }
    
    /**
     * Randomize DLL name
     * 
     * @param string $dll
     * 
     * @return void
     */
    public function randomizeModuleName($dll)
    {
        return $this->_injector->RandomizeModuleName("void", [$dll], ["string"]);
    }
    
    /**
     * @return bool
     */
    public function isAdmin() : bool
    {
        return $this->_injector->IsAdmin("bool", [], []);
    }
    
}