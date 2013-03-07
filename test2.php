<?php

include "./bootstrap.php";

use Test\Package;

// First: Underscores
// Expectation: Class 'Test\Package\Foo_Bar_Baz' not found
// Actual: Instantiation
$instance = new Package\Foo_Bar_Baz();

var_dump($instance);