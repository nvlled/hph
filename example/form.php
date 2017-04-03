<?php

require_once "../hph.php";

HPH::form(['action'=>''], function() {
    $this->label(['for'=>'GET-name'], 'Name: ');
    $this->input(['id'=>'GET-name', 'type'=>'text']);
    $this->input(['type'=>'submit']);
});

HPH::form(['action'=>'', 'method'=>'post'], function() {
    $this->label(['for'=>'POST-name'], 'Name: ');
    $this->input(['id'=>'POST-name', 'type'=>'text']);
    $this->input(['type'=>'submit', 'value'=>'Save']);
});

HPH::form(['action'=>'', 'method'=>'post'], function() {
    $this->fieldset(function() {
        $this->legend("Title");
        $this->input(['type'=>'radio', 'id'=>'radio']);
        $this->label(['for'=>'radio'], 'Click me');
    });
});

?>
