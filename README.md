ExactTarget SOAP API
====================

Provides *synchronous* CRUD operations on **Data Extensions** and **Subscriber Lists** by exposing a Doctrine like API (Record, Table, Collection).

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
The record class allows for manipulation of a single record (CRUD).
The table class exposes queries on the entire table and returns one or more records in form of a collection.
A collection is a container class that holds a variable number of record objects and provides various methods to iterate over them or to create, update or delete them with a single operation.

Data Extensions
---------------
