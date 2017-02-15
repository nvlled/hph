<?php

require_once "../hph.php";

HPH::form(['action'=>''], function() {
    $this->label(['for'=>'GET-name'], 'Name: ');
    $this->input(['id'=>'GET-name', 'type'=>'text']);
    $this->input(['type'=>'submit']);
});

HPH::form(['action'=>'', 'method'=>'post'], function() {
    HPH::label(['for'=>'POST-name'], 'Name: ');
    HPH::input(['id'=>'POST-name', 'type'=>'text']);
    HPH::input(['type'=>'submit', 'value'=>'Save']);
});

HPH::form(['action'=>'', 'method'=>'post'], function() {
    $this->fieldset(function() {
        $this->legend("Title");
        $this->input(['type'=>'radio', 'id'=>'radio']);
        $this->label(['for'=>'radio'], 'Click me');
    });
});

?>

