PHP-Huffman
===========

A fast and simple implementation of Huffman algorithm in PHP.

Install dependencies
--------------------

    composer install

Run application
---------------

Using the PHP built-in server for development purposes with the command:

    composer serve
    
    // composer.json
    ...
    "scripts": {
        "serve": "php -S 0.0.0.0:9001 index.php"
    }
    ...

Go to localhost:9001 to see Huffman samples

Enjoy!

Checking code for PSR-2
---------------

PHP_CodeSniffer can test against PSR-2 coding style guidelines, you must run the phpcs composer script command line:

    composer phpcs

If there is a note that phpcbf can fix some validations automatically, then you can run the phpcbf composer script command line:

    composr phpcbf

About the comments
------------------

This code is commented using the [PHPDoc](http://www.phpdoc.org/) comments so you can easily generate it's documentation.
