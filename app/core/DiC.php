<?php

class DiC
{
    protected $dependencies = [];
    protected $instances = [];

    public function set($name, $class)
    {
        $dep = new Dependency($class, $this);
        $this->dependencies[$name] = $dep;
        return $dep;
    }

    public function get($name, $new = false)
    {
        if ($new) {
            return $this->getNewInstance($name);
        } else {
            if (isset($this->instances[$name])) {
                return $this->instances[$name];
            }
            $instance = $this->getNewInstance($name);
            $this->instances[$name] = $instance;
            return $instance;
        }
    }

    private function getNewInstance($name)
    {
        if (!isset($this->dependencies[$name])) {
            throw new RuntimeException("Dependency {$name} is not registered");
        }
        $dep = $this->dependencies[$name];
        $rc = new ReflectionClass($dep->getClass());
        return $rc->newInstanceArgs($dep->getArgs());
    }

    public function __get($dependency)
    {
        return $this->get($dependency);
    }

    public function __set($name, $class)
    {
        $this->set($name, $class);
    }

}
