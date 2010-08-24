# PHP Dependency #

url (TODO)

PHP-Dependency (Pd) is a dependency injection framework and container written
in PHP.  One of the main features of PHP-Dependency is that it supports
class reflection, which means you do not have to maintain ANY configuration
files.

    Class MyExample() {

        private $_database;

        /**
         * This is the constructor, the database is automatically injected
         * due to the PdInject DocBlock.
         *
         * @PdInject database
         */
        public function __construct($databse) {
            $this->_database = $database;
        }

    }

That's it.  No configuration other than that one line Doc Block.

## Setup ##

You need to make sure that the Pd library is on your include path.

    set_include_path(
        get_include_path() . PATH_SEPARATOR .
        '/path/to/php-dependency/library/'
    );

If you are using a PHP framework with an autoloader then just make sure
the library/Pd is on the include path and tell the autoloader to use 'Pd'
as the class prefix/namespace.

## The Container ##

The container holds all of your dependencies.  Adding dependencies to the
container is very simple.

    $database = new Database("mysql://user:password@server/database");

    $container = Pd_Container::get();
    $container->dependencies()->set('database', $database);

You can put anything into the container.  Objects, arrays, strings, and even
anonymous functions.

## Class ##

Class dependencies are defined by PHP Doc Blocks.  Every Pd command begins with
@PdInject and is followed by a key:value type syntax.  The most common command
will be injecting a dependency by name, which just requires the dependency name.

    Class Book {

        private $_database;

        /**
         * @PdInject database
         */
        public function setDatabase($database) {
            $this->_database = $database;
        }

    }

To see a full list of commands/syntax please visit url (TODO)

## Creating Objects ##

To create objects use the Pd_Make class.

    /* @var $book Book */
    $book = Pd_Make::name('Book');

This is the same as doing

    $book = new Book();
    $book->setDatabase($database);

Note:  Use the @var doc line above the Pd_Make command.  This will tell your
IDE that $book is an instance of the Book class, which will allow the IDE to
auto complete any calls/usages of $book in your code.

## More ##

This is just a brief intro to PHP-Dependency.  There are a lot more features
located at url (TODO)