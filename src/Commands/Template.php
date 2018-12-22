<?php

namespace SimpleCom\AppMaker\Commands;

class Template
{
    protected $template;
    protected $variables;
    public $string;

    public function stub($name)
    {
        $this->template = file_get_contents(__DIR__ . '/../stubs/' . $name . '.stub');
        return $this;
    }

    public function variables($variables)
    {
        $this->variables = $variables;
        return $this;
    }

    public function generate()
    {
        $this->string = str_replace(array_keys($this->variables), array_values($this->variables), $this->template);
        return $this;
    }
}
