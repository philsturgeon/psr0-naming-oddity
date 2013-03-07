<?php

include "./bootstrap.php";

use Test\Package;

// First: Namespace Approach
// Expectation: Instantiation
// Actual: Instantiation
$instance = new Package\Foo\Bar\Baz();

var_dump($instance);

// Second: Underscores
// Expectation: Class 'Test\Package\Foo_Bar_Baz' not found
// Actual: Cannot redeclare class Test\Package\Foo\Bar\Baz
$instance = new Package\Foo_Bar_Baz();

var_dump($instance);