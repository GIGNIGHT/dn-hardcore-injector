<?php
namespace app\forms;

use bundle\windows\Windows;
use bundle\windows\WindowsScriptHost;
use std, gui, framework, app;

class ProcessList extends AbstractForm
{

    /**
     * @event show 
     */
    function doShow(UXWindowEvent $e = null)
    {    
        // shitcode
        $th = new Thread(function ()
        {
            foreach (WindowsScriptHost::WMIC("process list") as $prc)
            {

                if (fs::ext($name = $prc['Name']) != 'exe') continue;
                
                if (fs::exists($path = $prc['ExecutablePath']) && !fs::exists($icon = $_ENV['TEMP'].'\\'.$name.'.png'))
                    $this->extractIcon($path, $icon);
                       
                if (empty($icon)) $icon = 'res://.data/img/default16.png';
                
                uiLater(function () use ($prc, $name, $icon)
                {
                    $this->table->items->add(
                    [
                        'pid' => $prc['ProcessId'],
                        'name' => $name,
                        'icon' => $this->getIcon($icon)
                    ]);
                });
            }
        });
        
        $this->table->items->clear();
        $th->start();
    }

    /**
     * @event panel.click-Left 
     */
    function doPanelClickLeft(UXMouseEvent $e = null)
    {    
        $this->hideForm($this);
    }

    /**
     * @event button.click-Left 
     */
    function doButtonClickLeft(UXMouseEvent $e = null)
    {    
        $name = $this->table->selectedItem['name'];
        $form = app()->form('MainForm');
        $form->pName->text = $name;
        $form->doPNameKeyDownEnter();
        $this->hideForm($this);
    }

}
