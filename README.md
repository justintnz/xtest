# xtest
This is my answer for the test from Xtracta on July 7, 2020
------------------------

This script is written & tested with PHP 7.3.

to run this in command line, call: 
> $ php index.php

This script using inputs defined by SUPPLIER_FILES (array of Suppliers files) and INVOICE_FILE (input invoice file).

This script will stop immediatly when found a match, and print out the matched Id.

Data files are stored in test_file folder at the same level with index.php

I write gensup.php to generate large input file to test for performance. 

Run $ php gensup.php at command line to generate the test data file ( named with $output, default: ./test_files/data.txt)

