<?php
namespace app\forms;

use Injector;
use std, gui, framework, app; 


class MainForm extends AbstractForm
{
    
    /**
     * @var Injector
     */
    private $inj;
    
    /**
     * @var FileChooserScript
     */
    private $dialog;
    

    /**
     * @event close.click-Left 
     */
    function doCloseClickLeft(UXMouseEvent $e = null)
    {    
        app()->shutdown();
    }

    /**
     * @event panel3.click-Left 
     */
    function doPanel3ClickLeft(UXMouseEvent $e = null)
    {    
        $this->iconified = true;
    }


    /**
     * @event button.click-Left 
     */
    function doButtonClickLeft(UXMouseEvent $e = null)
    {    
        $pList = app()->form('ProcessList');
        $pList->x = $this->x + 164;
        $pList->y = $this->y + 20;
        $this->openForm($pList);
    }

    /**
     * @event button5.click-Left 
     */
    function doButton5ClickLeft(UXMouseEvent $e = null)
    {    
        if ($this->dialog->execute())
        {
            foreach ($this->dialog->files as $file)
            {
                $cBox = new UXCheckbox($file->getAbsolutePath());
                $cBox->selected = true;
                $this->listFiles->items->add($cBox);
            }
        }
    }


    /**
     * @event button8.action 
     */
    function doButton8Action(UXEvent $e = null)
    {
        $pList = app()->form('About');
        $pList->x = $this->x + 164;
        $pList->y = $this->y + 100;
        $this->openForm($pList);
    }


    /**
     * @event show 
     */
    function doShow(UXWindowEvent $e = null)
    {
        $this->inj = new Injector();
        $this->dialog = new FileChooserScript();
        $this->dialog->multiple = true;
        $this->dialog->filterExtensions = '*.dll';
        
        $this->pName->observer('focused')->addListener(function ($e, $focused)
        { 
            if (!$focused)
            {
                $this->doPNameKeyDownEnter();
            }
        });
    }

    /**
     * @event button6.click-Left 
     */
    function doButton6ClickLeft(UXMouseEvent $e = null)
    {    
        $this->listFiles->items->removeByIndex($this->listFiles->selectedIndex);
    }

    /**
     * @event button7.click-Left 
     */
    function doButton7ClickLeft(UXMouseEvent $e = null)
    {    
        $list = $this->listFiles->items;
        if ($list->count())
        {
            foreach ($list->toArray() as $obj)
            {
                if ($obj->selected)
                {
                    if (is_numeric($proc = $this->pName->text))
                        $code = $this->inj->injectByPID((int)$proc, $obj->text);
                    else
                        $code = $this->inj->inject($proc, $obj->text);
                        
                    switch ($code)
                    {
                        case 0: pre("Successful injected"); break;
                        case 1: pre("No process found with this name"); break;
                        case 2: pre("No process found with this PID"); break;
                        case 3: pre("OpenProcess cannot open access to this process"); break; 
                        case 4: pre("DLL not found"); break;
                        default: pre("Unknown error"); break;
                    }
                }
            }
        }
    }

    /**
     * @event pName.keyDown-Enter 
     */
    function doPNameKeyDownEnter(UXKeyEvent $e = null)
    {    
        $prc = $this->getProcessInfo($this->pName->text);
        $this->pid->text = $prc->pid;
        $this->pTitle->text = $prc->title == null ? 'NULL' : $prc->title;
    }


}
