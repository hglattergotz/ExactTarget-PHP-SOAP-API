<?php
/**
 * AbstractETDataExtensionObject
 *
 * @abstract
 * @package ExactTargetAPI
 * @author  Henning Glatter-Gotz
 */
abstract class AbstractETDataExtensionObject
{
  // Supported Data Extension data types
  const TYPE_TEXT = 1;
  const TYPE_NUMBER = 2;
  const TYPE_EMAIL = 3;
  const TYPE_PHONE = 4;
  const TYPE_DATE = 5;
  const TYPE_BOOLEAN = 6;

  /**
   * Array of field names that have been modified
   */
  protected $modifiedFiels = array();

  /**
   * The actual data of the object
   */
  protected $data;

  /**
   * The customer key for the data extension
   */
  protected $customerKey;

  /**
   * The soapClient object used for accessing the ET SOAP API
   */
  protected $soapClient;

  /**
   * The schema for the data extension as an array of all fields with some meta
   *
   * $schema = array(
   *   'fieldname' => array(
   *     'is_required' => true/false,
   *     'is_primary'  => true/false,
   *     'type'        => self::TYPE_*
   *   ),
   *   :
   *   :
   * );
   *
   * This is defined in the configure() method of the classes that extend this
   * abstract base class.
   */
  protected $schema;

  /**
   * __construct
   *
   * @access public
   * @return void
   */
  public function __construct()
  {
    $this->configure();
    $this->data = array();

    foreach ($this->schema as $key => $value)
    {
      $this->data[$key] = null;
    }

    $this->soapClient = ETCore::getClient();
  }

  /**
   * This method must be implemented by the derived class and takes care of
   * configuring the object for a specific data extension.
   */
  abstract protected function configure();

  /**
   * __call
   *
   * Magic method for get and set
   *
   * @param string $name The field name
   * @param mixed $args
   * @access public
   * @return void
   */
  public function __call($name, $args)
  {
    $prefix = substr($name, 0, 3);
    $fieldName = substr($name, 3);

    if (!array_key_exists($fieldName, $this->schema))
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
        $this->modifiedFiels[] = $fieldName;
        break;
      default:
        throw new Exception('Invalid method prefix '.$prefix);
    }
  }

  /**
   * fromArray
   *
   * Populate the object from a nassociative array
   *
   * @param array $data The array to load the objec from
   * @access public
   * @return void
   */
  public function fromArray($data)
  {
    $this->validateSchema(array_keys($data));

    foreach ($data as $k => $v)
    {
      $this->data[$k] = $v;
      $this->modifiedFiels[] = $k;
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
   * Generate a soapVar object representation of this DataExtensionObject that
   * can be used in save (upsert) operations.
   * This is primarely used for collections of DataExceptionObjects in order
   * to save multiple objects with a single soap call.
   *
   * @return type
   */
  public function toSoapVarForSave()
  {
    return $this->makeSoapVarForSave();
  }

  public function toSoapVarForDelete()
  {
    return $this->makeSoapVarForDelete();
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
          'fields'         => array_keys($this->schema),
          'primaryKeys'    => $this->getPrimaryKeys(),
          'requiredFields' => $this->getRequiredFields(),
          'customerKey'    => $this->customerKey
    );
  }

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
   * validateSchema
   *
   * Validate the keys passed to the method. $keys can be a subset of the
   * objects schema but cannot contain any values that are not part of the
   * objects schema (as defined in the configure() method in the derived class.
   *
   * @param array $keys The field names (keys) of an array to be validated
   * @access protected
   * @return void
   */
  protected function validateSchema($keys)
  {
    foreach ($keys as $key)
    {
      if (!array_key_exists($key, $this->schema))
      {
        throw new Exception($key.' is not a valid field.');
      }
    }
  }

  /**
   * isFieldPrimary
   *
   * Return true if the field is a primary key
   *
   * @param string $fieldName The field name as defined in the data extension
   * @access public
   * @return void
   */
  public function isFieldPrimary($fieldName)
  {
    $this->validateSchema(array($fieldName));

    return $this->schema[$fieldName]['is_primary'];
  }

  /**
   * isFieldRequired
   *
   * Return true if the fieldName is valid and is required
   *
   * @param string $fieldName The field name as defined in the data extension
   * @access public
   * @return void
   */
  public function isFieldRequired($fieldName)
  {
    $this->validateSchema(array($fieldName));

    return $this->schema[$fieldName]['is_required'];
  }

  /**
   * getFieldType
   *
   * Return the field type, which is one of self::TYPE_*
   *
   * @param string $fieldName The field name as defined in the data extension
   * @access public
   * @return void
   */
  public function getFieldType($fieldName)
  {
    $this->validateSchema(array($fieldName));

    return $this->schema[$fieldName]['type'];
  }

  /**
   * getPrimaryKeys
   *
   * Return an array of primary key field names
   *
   * @access public
   * @return array
   */
  public function getPrimaryKeys()
  {
    $keys = array();

    foreach ($this->schema as $key => $value)
    {
      if ($value['is_primary'])
      {
        $keys[] = $key;
      }
    }

    return $keys;
  }

  /**
   * getRequiredFields
   *
   * Return an array of required field names
   *
   * @access public
   * @return array
   */
  public function getRequiredFields()
  {
    $keys = array();

    foreach ($this->schema as $key => $value)
    {
      if ($value['is_required'])
      {
        $keys[] = $key;
      }
    }

    return $keys;
  }

  /**
   * makeSoapVarForSave
   *
   * Helper method that creates a SoapVar object for purposes of saving
   * (upsert).
   *
   * @access protected
   * @return void
   */
  protected function makeSoapVarForSave()
  {
    $nullValues = array(null, '');
    $requiredFields = $this->getRequiredFields();

    foreach ($requiredFields as $required)
    {
      if (in_array($this->data[$required], $nullValues))
      {
        throw new Exception('Required field '.$required.' not set.');
      }
    }

    $deo = new ExactTarget_DataExtensionObject();
    $deo->CustomerKey = $this->customerKey;
    $deo->Properties = array();
    $deo->Keys = array();

    $this->modifiedFiels = array_unique(array_merge($this->modifiedFiels, $this->getPrimaryKeys()));

    foreach ($this->modifiedFiels as $fieldName)
    {
      if (in_array($this->data[$fieldName], $nullValues))
      {
        $type = $this->getFieldType($fieldName);

        switch ($type)
        {
        case self::TYPE_TEXT:
          $deo->Properties[] = ETCore::newAPIProperty($fieldName, null);
          break;
        case self::TYPE_NUMBER:
        case self::TYPE_EMAIL:
        case self::TYPE_PHONE:
        case self::TYPE_DATE:
        case self::TYPE_BOOLEAN:
          // At this point cannot be set to null, just drop it.
          break;
        default:
          throw new Exception('Invalid type');
        }
      }
      else
      {
        $deo->Properties[] = ETCore::newAPIProperty($fieldName, $this->data[$fieldName]);
      }
    }

    return ETCore::toSoapVar($deo, 'DataExtensionObject');
  }

  /**
   * makeSoapVarForDelete
   *
   * Helper method that creates a SoapVar object for purposes of deletion
   *
   * @access protected
   * @return void
   */
  protected function makeSoapVarForDelete()
  {
    $nullValues = array(null, '');
    $pks = $this->getPrimaryKey();

    foreach ($pks as $pk)
    {
      if (in_array($this->data[$pk], $nullValues))
      {
        throw new Exception('Primary key '.$pk.' not set.');
      }
    }

    $deo = new ExactTarget_DataExtensionObject();
    $deo->CustomerKey = $this->customerKey;
    $deo->Keys = array();

    foreach ($pks as $pk)
    {
      $deo->Keys[] = ETCore::newAPIProperty($pk, $this->data[$pk]);
    }

    return ETCore::toSoapVar($deo, 'DataExtensionObject');
  }

  /**
   * Save the record.
   *
   * @return type
   */
  public function save()
  {
    try
    {
      if (count($this->modifiedFiels) == 0)
      {
        return false;
      }

      $deoSo = $this->makeSoapVarForSave();

      $uo = new ExactTarget_UpdateOptions();
      $uo->SaveOptions = array();

      $so = new ExactTarget_SaveOption();
      $so->PropertyName = 'DataExtensionObject';
      $so->SaveAction = ExactTarget_SaveAction::UpdateAdd;

      $uo->SaveOptions[] = $so;
      $uoSo = ETCore::toSoapVar($uo, 'UpdateOptions');

      $request = new ExactTarget_UpdateRequest();
      $request->Options = $uoSo;
      $request->Objects = array($deoSo);
      $result = $this->soapClient->Update($request);

      $this->evaluateResult($result);

      return true;
    }
    catch (Exception $e)
    {
      throw new Exception(__METHOD__ . ':' . __LINE__ . '|' . $e->getMessage());
    }
  }

  /**
   * Delete the record specified by the primary key(s)
   *
   */
  public function delete()
  {
    try
    {
      $deoSo = $this->makeSoapVarForDelete();

      $request = new ExactTarget_DeleteRequest();
      $request->Options = null;
      $request->Objects = array($deoSo);

      $result = $this->soapClient->Delete($request);

      $this->evaluateResult($result);

      return true;
    }
    catch (Exception $e)
    {
      throw new Exception(__METHOD__ . ':' . __LINE__ . '|' . $e->getMessage());
    }
  }
}
