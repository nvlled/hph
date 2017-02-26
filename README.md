# hph
reversed php

# Usage
```
HPH::tagName($attributes, $content)
HPH::tagName($content)
HPH::tagName($attributes)

//or
$hph = new HPH();
$hph->tagName($attributes, $content)

```
$attributes and $content are both optional. $attributes are simply associative arrays
in place of html tags.
```
HPH::input(["name"=>"username", "type"=>"text"]);
// equivalent to <input name="username" type="text />
```
$content can either be a null, string or a function.
```
HPH::h1("Title");
HPH::hr();
HPH::p("Text content");
```
To represent nested html tags, functions must be used:

```
HPH::form(["method"=>"POST"], function() {
  echo "message: ";
  HPH->input("name"=>"message", "value"=>"message here");
  HPH->input("type"=>"submit");
});

// results to:
// <form method="POST">
//   message:
//   <input name="message" value="message here" />
//   <input type="submit" />
// </form>
```
It should be noted that $this can be used inside the content function,
to void creating new instances of HPH. The following produces
the same output as before:
```
HPH::form(["method"=>"POST"], function() {
  echo "message: ";
  $this->input("name"=>"message", "value"=>"message here");
  $this->input("type"=>"submit");
});
```

## Why
To avoid doing things like:

```php
someCode();
moreCode();
?>
  <div id="thing">some text <?= $somevar ?></div>
<?php
otherCode();
```

where there are mostly php code and
needs to output some html stuff.
So, instead:

```php
someCode();
moreCode();
HPH::div(["id"=>"thing"], "some text $somevar");
otherCode();
```
But why not just echo an string?

```php
someCode();
moreCode();
echo "<div id='thing'>some text $somevar</div";
otherCode();
```

Because, html string aren't syntax highlighted
and becomes intractable especially when it's several
lines long. Plus, mixing php and
html messes up autoindentation on some text editors.

Another reason is that writing html could be entirely
avoided, and everything could be written in PHP.
It is left to the discretion of the reader
whether this is a good thing or not! 

See the examples directory for more examples.

## Issues
The hph code are slightly more verbose compared to the html ones.
And although errors can be caught by the php interpreter,
they are sometimes obstuse. For instance, using a = instead of =>
in associative arrays.

