<?php

use framework;
use php\gui\shape\UXRectangle;

class Background 
{
    /**
     * @var double
     */
    public $opacity = 0.70;
    
    /**
     * @var string
     */
    public $color = 'Black';
    
    /**
     * @var UXRectangle
     */
    private $_shape;


    public function __construct()
    {
        $this->_shape = new UXRectangle();
        $this->_shape->opacity = $this->opacity;
        $this->_shape->fillColor = $this->color;
        $this->_shape->strokeColor = $this->color;
        $this->_shape->strokeWidth = 0;
    }
    
    /**
     * @param UXForm $form
     */
    public function show($form, $clickHide = true)
    {
        $this->_shape->size = [$form->width, $form->height];
        $form->add($this->_shape);
        
        if ($clickHide)
        {
            $this->_shape->on('click', function ()
            {
                $this->_shape->free();
            });
        }
    }
    
    public function hide()
    {
        $this->_shape->free();
    }
}