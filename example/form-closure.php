<?php

require_once "../hph.php";

$saveText = "Save";
$clickText = "Click me";

$env = Dict::from(compact("saveText"));
$hph = new HPH($env);

$hph->form(['action'=>''], function() {
    $this->label(attrs("for", "GET-name"), 'Name: ');
    $this->input(attrs('id', 'GET-name', 'type','text'));
    $this->input(attrs('type', 'submit'));
});

$hph->form(['action'=>'', 'method'=>'post'], function($env) {
    $this->label(attrs('for', 'POST-name'), 'Name: ');
    $this->input(attrs('id', 'POST-name', 'type','text'));
    $this->input(attrs('type', 'submit', 'value', $env->saveText));
});

$hph->form(['action'=>'', 'method'=>'post'], function() {
    $this->fieldset(function($env) {
        $this->legend("Title");
        $this->input(attrs('type', 'radio', 'id', 'radio'));
        $this->label(attrs('for', 'radio'), $env->clickText);
    });
});

?>
