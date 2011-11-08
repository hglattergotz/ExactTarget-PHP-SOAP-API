![ExactTarget](http://memberlandingpages.com/help/wiki_images/new_wiki/ExactTargetLogo.jpg) ![project status](http://stillmaintained.com/hglattergotz/ExactTarget-PHP-SOAP-API.png)

### PHP wrapper to ExactTarget SOAP API

This is a php library for accessing a subset of ExactTarget's SOAP API. It provides *synchronous* CRUD operations on **Data Extensions** and **Subscriber Lists** by exposing a Doctrine like API (Record, Table, Collection).
The ExactTarget API documentation can be found [here](http://docs.code.exacttarget.com/).

- - -

* <a href="#requirements">Requirements</a>
* <a href="#basic">Basic usage</a>
* <a href="#license">License</a>
* <a href="#copyright">Copyright</a>

- - -

### <a name="requirements">Requirements</a>

* See [ExactTarget PHP getting started guide](http://wiki.memberlandingpages.com/030_Developer_Documentation/020_Web_Service_Guide/Getting_Started_Developers_and_the_ExactTarget_API/Connecting_to_the_API_using_PHP).
* If you are not using an auto-loader you will have to add require() statements.

- - -

### <a href="basic">Basic usage</a>

To interact with the Soap API the library provides the basic classes that represent a Record, Table and Collection.

The names are pretty self explanatory and if you are familiar with Doctrine this will be very familiar.

* The record class allows for manipulation of a single record (CRUD).
* The table class exposes queries on the entire table and returns one or more records in form of a collection.
* A collection is a container class that holds a variable number of record objects and provides various methods to iterate over them or to create, update or delete them with a single operation.

To interact with a Data Extension with the following schema you simply extend the `AbstractETDataExtensionObject` and `AbstractETDataExtension` classes.

**Schema**

~~~
id (primary key)
firstname
lastname
email
~~~

**Record**

~~~
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
~~~

**Table**

~~~
class PersonDataExtension extends AbstractETDataExtension
{}
~~~

*Important:* The two related classes must have the same name, but the Record class has `Object` appended to it.

*Fetch a record from the data extension and modify it.*

~~~
ETCore::initialize('myusername', 'mypassword');
    
$personDE = new PersonDataExtension();
$allPeople = $personDE->findAll(ETCore::HYDRATE_RECORD);
$person = $allPeople->getFirst();
$person->setfirstname('Joe');
$person->save();
~~~

*Create a new record*

~~~
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
~~~

- - -

### <a href="license">License</a>

Please refer to the LICENSE file in this repository.

- - -

### <a href="copyright">Copyright</a>

ExactTarget is a registered trademark of ExactTarget, Inc.