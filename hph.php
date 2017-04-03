<?php

function attrs(...$args) { return new Dict(...$args); }

class Dict {
    public $data = [];
    public $default = NULL;
    public $parent = NULL;

    function __construct(...$pairs) {
        $len = count($pairs);
        if ($len%2 != 0) {
            throw new Exception("invalid dict: there must a even number of arguments");
        }
        $data = [];
        for ($i = 0; $i < $len; $i+=2) {
            $key = $pairs[$i+0];
            $val = $pairs[$i+1];
            $data[$key] = $val;
        }
        $this->data = $data;
    }

    static function from($assoc) {
        $dict = new Dict();
        $dict->data = $assoc;
        return $dict;
    }

    function __get($key) {
        if ($key == "declare") {
            return new Decl($this);
        }

        if (isset($this->data[$key]))
            return $this->data[$key];
        if ($this->parent instanceof Dict)
            return $this->parent->$key;
        return $this->default;
    }

    private function getOrigin($key) {
        if (isset($this->data[$key]))
            return $this;
        if ($this->parent == NULL)
            return NULL;
        return $this->parent->getOrigin($key);
    }

    function set($key, $val) {
        $this->data[$key] = $val;
    }

    function __set($key, $val) {
        if ($key == "declare") {
            return new Decl($this);
        }

        $origin = $this->getOrigin($key);
        if ($origin) {
            $origin->$key = $val;
        } else {
            $this->data[$key] = $val;
        }
    }

    function __invoke($key) {
        return $this->$key;
    }
}

class Decl {
    private $dict = NULL;
    function __construct($dict) {
        $this->dict = $dict;
    }

    function __set($key, $val) {
        $this->dict->set($key, $val);
    }
}

function isThingyTag($tagName) {
    switch ($tagName) {
    case "img":
    case "br":
    case "hr":
        return true;
    }
    return false;
}

class HPH {
    private $env = NULL;

    function __construct($parent=null) {
        $this->env = new Dict();
        if ($parent instanceof HPH) {
            $this->env->parent = $parent->env;
        }
    }

    function __call($tagname, $args) {
        $this->tag($tagname, @$args[0], @$args[1]);
    }

    function __get($key) {
        return $this->env->$key;
    }

    function __set($key, $val) {
        return $this->env->$key = $val;
    }

    static function __callstatic($tagname, $args) {
        (new HPH())->tag($tagname, @$args[0], @$args[1]);
    }

    function tag(
        $name, 
        $attributes=array(), 
        $content = null) {

        if ( !(is_array($attributes) || $attributes instanceof Dict)) {
            $content = $attributes;
            $attributes = [];
        }

        if ($attributes instanceof Dict) {
            $attributes = $attributes->data;
        }

        // TODO: indent nested tags
        $attrs = self::asAttributes($attributes);
        if ($content == null && isThingyTag($name)) {
            echo "<$name $attrs/>";
        } else {
            if (is_callable($content)) {
                echo "<$name $attrs>";
                $hph = new HPH($this);
                $content->bindTo($hph)($hph->env);
                echo "</$name>";
            } else {
                echo "<$name $attrs>".$content."</$name>";
            }
        }
    }

    static function asAttributes($assoc) {
        $str = "";
        foreach ($assoc as $k => $v) {
            $v = htmlspecialchars($v);
            $str .= "$k='$v' ";
        }
        return trim($str);
    }
}
?>
