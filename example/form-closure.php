<?php

require_once "../hph.php";

$hph = new HPH();
$hph->saveText = "Save";
$hph->clickText = "Save";

$hph->form(['action'=>''], function($env) {
    $this->label(attrs("for", "GET-name"), 'Name: ');
    $this->input(attrs('id', 'GET-name', 'type','text'));
    $this->input(attrs('type', 'submit', "value", $this->saveText));
});

$hph->form(['action'=>'', 'method'=>'post'], function() {
    $this->label(attrs('for', 'POST-name'), 'Name: ');
    $this->input(attrs('id', 'POST-name', 'type','text'));
    $this->input(attrs('type', 'submit', 'value', $this->saveText));
});

$hph->form(['action'=>'', 'method'=>'post'], function() {
    $this->fieldset(function() {
        $this->legend("Title");
        $this->input(attrs('type', 'radio', 'id', 'radio'));
        echo " ";
        $this->label(attrs('for', 'radio'), $this->clickText);
    });
});

?>
