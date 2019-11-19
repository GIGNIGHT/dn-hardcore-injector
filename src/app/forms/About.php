<?php
namespace app\forms;

use std, gui, framework, app;


class About extends AbstractForm
{

    /**
     * @event panelAlt.click-Left 
     */
    function doPanelAltClickLeft(UXMouseEvent $e = null)
    {
        $this->hideForm($this);
    }

    /**
     * @event button.click-Left 
     */
    function doButtonClickLeft(UXMouseEvent $e = null)
    {
        $this->hideForm($this);
    }

}
