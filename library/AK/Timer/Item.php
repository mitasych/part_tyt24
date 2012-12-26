<?php
class AK_Timer_Item extends AK_Data_Entity
{
    protected $id;
    protected  $controller;
    protected $time;
    protected $what;
    protected $okved;
    protected $okato;

    public function getId ()
    {
        return $this->id;
    }

    public function getTime ()
    {
        return $this->time;
    }

    public function getWhat ()
    {
        return $this->what;
    }

    public function getController ()
    {
        return $this->controller;
    }

    public function setId ($value)
    {
        $this->id = $value;
        return $this;
    }

   public function setTime ($value)
    {
        $this->time = $value;
        return $this;
    }

    public function setController ($value)
    {
        $this->controller = $value;
        
        return $this;
    }

    public function setWhat ($value)
    {
        $this->what = $value;
        return $this;
    }

    public function setOkved ($value)
    {
        $this->okved = $value;
        return $this;
    }
    public function setOkato ($value)
    {
        $this->okato = $value;
        return $this;
    }

    /**
     *
     */
    public function __construct ($value = null)
    {
        parent::__construct('timer', array(
            'id' => 'id' ,
            'controller' => 'controller',
            'time' => 'time',
            'what' => 'what',
            'okved' => 'okved',
            'okato' => 'okato'
            ));
        $this->load($value);

            
    }

   
  
}
