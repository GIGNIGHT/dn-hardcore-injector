<?php
namespace app\modules;

use bundle\windows\WindowsScriptHost;
use bundle\windows\Task;
use Background;
use std, gui, framework, app;


class MainModule extends AbstractModule
{
    /**
     * @var Background
     */
    private $bg;
    
    function __construct()
    {
        $this->bg = new Background();
    }
    
    function openForm(UXForm $form)
    {
        $this->bg->show($this->form('MainForm'));
        $form->show();
    }
    
    function hideForm(UXForm $form)
    {
        $this->bg->hide();
        $form->hide();
    }
    
    function setCenter(UXNode $object)
    {
        $form = app()->form('MainForm');
        $objW = $object->width;
        $objH = $object->height;
        $object->x = (($form->width / 2) - ($objW / 2));
        $object->y = (($form->height / 2) - ($objH / 2));
    }
    
    function getProcessInfo($name)
    {
        $prc = Task::find($name);
        
        if (is_object($prc))
            return $prc->toArray()[0];
    }
    
    function getIcon($img, $size = [16, 16])
    {   
         $view = new UXImageView(new UXImage($img)); 
         $view->stretch = true;
         $view->smartStretch = true;         
         $view->size = $size;
         
         return $view;
    }
    
    function extractIcon($file, $icon)
    {
        WindowsScriptHost::PowerShell(
            '[System.Reflection.Assembly]::LoadWithPartialName(\'System.Drawing\'); '.
            '[System.Drawing.Icon]::ExtractAssociatedIcon(\':file\').ToBitmap().Save(\':icon\')',  
            ['file' => realpath($file), 'icon' => $icon]
        );
        
        return fs::exists($icon);
    }

}