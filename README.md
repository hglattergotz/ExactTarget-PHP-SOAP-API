ExactTarget SOAP API
====================

Provides *synchronous* CRUD operations on **Data Extensions** and **Subscriber Lists** by exposing a Doctrine like API (Record, Table, Collection).

### Requirements
* See [ExactTarget PHP getting started guide](http://wiki.memberlandingpages.com/030_Developer_Documentation/020_Web_Service_Guide/Getting_Started_Developers_and_the_ExactTarget_API/Connecting_to_the_API_using_PHP).
* If you are not using an auto-loader you will have to add require() statements.

ETCore
------
This class provides two essential mechanisms that are needed for all operations as well as a number of utility methods.
Before any of the classes in this library can be used the following must be called:
`ETCore::initialize('username', 'password')`
This sets the credentials for all following library operations.
Another important method is `ETCore::getClient()`, which returns an instance of the ExactTarget Soap client.

Record, Table, Collection
-------------------------
To interact with the Soap API the library provides the basic classes that represent a Record, Table and Collection.

The names are pretty self explanatory and if you are familiar with Doctrine this will be very familiar.

* The record class allows for manipulation of a single record (CRUD).
* The table class exposes queries on the entire table and returns one or more records in form of a collection.
* A collection is a container class that holds a variable number of record objects and provides various methods to iterate over them or to create, update or delete them with a single operation.

Data Extensions
---------------
A Data Extension is essentially a custom table.

To interact with a Data Extension with the following schema you simply extend the `AbstractETDataExtensionObject` and `AbstractETDataExtension` classes.

**Schema**

    id (primary key)
    firstname
    lastname
    email

**Record**

    class PersonDataExtensionObject extends AbstractETDataExtensionObject
    {
        protected function configure()
        {
            $this->customerKey = 'my customer key for this DE';
            $this->primaryKeys = array('id');
            $this->requiredFields = array('id', 'email');
            $this->fields = array(
                'id',
                'firstname',
                'lastname',
                'email'
            );
        }
    }

**Table**

    class PersonDataExtension extends AbstractETDataExtension
    {}

*Important:* The two related classes must have the same name, but the Record class has `Object` appended to it.

**Usage example:**

*Fetch a record from the data extension and modify it.*

    ETCore::initialize('myusername', 'mypassword');
    
    $personDE = new PersonDataExtension();
    $allPeople = $personDE->findAll(ETCore::HYDRATE_RECORD);
    $person = $allPeople->getFirst();
    $person->setfirstname('Joe');
    $person->save();

*Create a new record*

    ETCore::initialize('myusername', 'mypassword');
    
    $personData = array(
        'id' => 123,
        'firstname' => 'Joe',
        'lastname' => 'Smith',
        'email' => 'joe@smith.com'
    );
    $person = new PersonDataExtensionObject();
    $person->fromArray($personData);
    $person->save();

```php
class test
{
   protected $test
}
```