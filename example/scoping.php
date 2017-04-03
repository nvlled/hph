<?php
require_once "../hph.php";

$hph = new HPH();
$hph->div(function() {
    // bug: 
    $this->x = 50;
    $this->y = 30;
    $this->p(function() {
        $this->declare->x = 5;
        $this->span(function() {
            $this->x *= 20;
            echo "x : {$this->x}, expected: 100<br>";
            echo "y : {$this->y}, expected: 30<br>";
            $this->y *= 10;
            $this->z = 100;
        });
        echo "x : {$this->x}, expected: 100<br>";
        echo "z : '{$this->z}', expected: ''<br>";
    });
    echo "x : {$this->x}, expected: 50<br>";
    echo "y : {$this->y}, expected: 300<br>";
});

?>
