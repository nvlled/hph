<?php

class HPH {
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

        if ( ! is_array($attributes)) {
            $content = $attributes;
            $attributes = [];
        }

        $attrs = self::asAttributes($attributes);
        if ($content == null) {
            echo "<$name $attrs />";
        } else {
            if (is_callable($content)) {
                echo "<$name $attrs>";
                echo $content->bindTo($this)();
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
        return $str;
    }
}
?>
