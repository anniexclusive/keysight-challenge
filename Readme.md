This simple command line program takes the root program file path as argument and parses the program displaying the structure of the imports.

To run it using php:

    composer install (optional)
    php bin/console app:parse examples/example3/root.prog


To run it using node.js:

    node app.js examples/example3/root.prog

The program checks for the command line argument and if there is no root.prog file, it exits with an error.
And thereafter, it uses regular expression to check if there are import statements in the root program file, and using recursive loop to go through all the files, check for import statements in them as well and display the structure of the files.

After writing it using PHP, I decided to convert it to node.js as well since it was mostly JavaScript code.