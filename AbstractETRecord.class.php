<?php
abstract class AbstractETRecord
{
  protected $fields;
  protected $primaryKeys;
  protected $requiredFields;
  protected $data;
  protected $customerKey;
  protected $soapClient;
  protected $changed = false;
  
  public function __construct()
  {
    $this->configure();
    $this->data = array();
    
    foreach ($this->properties as $property)
    {
      $this->data[$property] = null;
    }
    
    $this->soapClient = ETCore::getClient();
  }

  /**
   * This method must be implemented by the derived class and takes care of
   * configuring the object for a specific data extension.
   */
  abstract protected function configure();
  
  /**
   * Process the soap result and throw an exception if something went wrong
   * 
   * @param type $result 
   */
  protected function evaluateResult($result)
  {
    ETCore::evaluateSoapResult($result);
  }

  /**
   * Validate the keys passed to the method. $keys can be a subset of the
   * objects schema but cannot contain any values that are not part of the
   * objects schema (as defined in the configure() method in the derived class.
   * 
   * @param type $keys 
   */
  protected function validateSchema($keys)
  {
    foreach ($keys as $key)
    {
      if (!in_array($key, $this->properties))
      {
        throw new Exception($key.' is not a valid field.');
      }
    }
  }

  protected function isPrimary($fieldName)
  {
    return in_array($fieldName, $this->primaryKeys);
  }
  
  public function __call($name, $args)
  {
    $prefix = substr($name, 0, 3);
    $fieldName = substr($name, 3);
    
    if (!in_array($fieldName, $this->fields))
    {
      throw new Exception('Invalid field '.$fieldName);
    }
        
    switch ($prefix)
    {
      case 'get':
        return $this->data[$fieldName];
        break;
      case 'set':
        $this->data[$fieldName] = $args[0];
        $this->changed = true;
        break;
      default:
        throw new Exception('Invalid method prefix '.$prefix);
    }
  }

  /**
   * Populate the object from a nassociative array.
   * 
   * @param type $data 
   */
  public function fromArray($data)
  {
    $this->validateSchema(array_keys($data));
    
    foreach ($data as $k => $v)
    {
      $this->data[$k] = $v;
    }
  }
  
  /**
   * Return the data representation as a nassociative array.
   * 
   * @return type 
   */
  public function toArray()
  {
    return $this->data;
  }
  
  /**
   * Generate a soapVar object representation of this DataExtensionObject.
   * This is primarely used for collections of DataExceptionObjects in order
   * to save multiple objects with a single soap call.
   * 
   * @return type 
   */
  public function toSoapVar()
  {
    return $this->makeSoapVar();
  }
  
  /**
   * Return the schema of this extension. Primarely used for constructing the
   * companion DataExtension object.
   * 
   * @return type 
   */
  public function getSchema()
  {
    return array(
          'fields'         => $this->fields,
          'primaryKeys'    => $this->primaryKeys,
          'requiredFields' => $this->requiredFields,
          'customerKey'    => $this->customerKey
    );
  }
}