# PSR-0 Class Naming Oddity

This highlights an oddity in PSR-0 which will cause errors if you instantiate classes inconsistently in your application.

## The Background

There is an oddity in the way PSR-0 will let you load classes which is relatively well 
known in the PHP-FIG but often confuses folks who were not expecting it.

Anthony Ferrera (a core PHP contributor) used this as one of the reasons he [did not want 
to see PSR-0 merged into PHP itself](http://blog.ircmaxell.com/2011/11/on-psr-0-being-included-in-phps-core.html).

It was also brought up as an issue on the PHP-FIG issues area: [Underscore can cause duplicate file inclusion](https://github.com/php-fig/fig-standards/issues/83). 

## The Issue

A class can be accessed via / or _, for example a file located in `src/Foo/Bar/Baz.php`
with the following content...:

    <?php namespace Test\Package\Foo\Bar;

	class Baz {}

... would be accessable as either of the following two calls:

	$instance = new Package\Foo\Bar\Baz();

	$instance = new Package\Foo_Bar_Baz();

You can use either (or probably some whacky combination) but if you try to use both to 
reference the same file you will get unexpected results.

## The Test

Grab the code:

	$ git clone git://github.com/philsturgeon/psr0-naming-oddity.git
	$ cd psr0-naming-oddity

I wrote two tests for this. The first file tries to instantiate 
`new Package\Foo\Bar\Baz()` then `new Package\Foo_Bar_Baz()`. 

	$ php test1.php
	object(Test\Package\Foo\Bar\Baz)#2 (0) {
	}
	PHP Fatal error:  Cannot redeclare class Test\Package\Foo\Bar\Baz in /tmp/test/vendor/test/package/src/Test/Package/Foo/Bar/Baz.php on line 3

That's a little odd perhaps but not unexpected, as they both point to the same file it tries 
to include it a second time and falls over. Fair enough. Let's try doing it the other way 
around and instantiate `new Package\Foo_Bar_Baz()` then `new Package\Foo\Bar\Baz()`.

	$  php test2.php
	PHP Fatal error:  Class 'Test\Package\Foo_Bar_Baz' not found in /tmp/test/test2.php on line 10

It seems to work fine one way around, but it's not too happy if you try doing underscores 
then namespaces.

## The Solution

Be careful when you are referencing your classes to be consistent with how you load up your classes, or you're going to have a bad time.