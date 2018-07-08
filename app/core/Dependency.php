<?php

class Dependency
{
    protected $class;
    protected $dic;
    protected $args = [];

    public function __construct($class, $dic)
    {
        $this->class = $class;
        $this->dic = $dic;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function addArg($argument)
    {
        if (is_string($argument)) {
            if (substr($argument, 0, 2) == '@@') {
                $dependency = substr($argument, 2);
                $argument = $this->dic->get($dependency, true);
            }
        }
        $this->args[] = $argument;
        return $this;
    }

    public function getArgs()
    {
        return $this->args;
    }

}
