<?php

function attrs(...$args) { return new Dict(...$args); }

class Dict {
    public $data = [];
    public $default = NULL;

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
        var_dump($dict);
        return $dict;
    }

    function __get($key) {
        if (isset($this->data[$key]))
            return $this->data[$key];
        return $this->default;
    }

    function __set($key, $val) {
        $this->data[$key] = $val;
    }

    function __invoke($key) {
        return $this->$key;
    }
}

class HPH {
    private $env = [];

    function __construct($env=[]) {
        $this->env = $env;
    }

    function __call($tagname, $args) {
        $this->tag($tagname, @$args[0], @$args[1]);
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
        if ($content == null) {
            echo "<$name $attrs/>";
        } else {
            if (is_callable($content)) {
                echo "<$name $attrs>";
                echo $content->bindTo($this)($this->env);
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
