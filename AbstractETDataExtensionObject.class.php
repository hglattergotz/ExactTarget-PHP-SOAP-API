<?php
abstract class AbstractETDataExtensionObject
{
  protected $fields;
  protected $modifiedFiels = array();
  protected $primaryKeys;
  protected $requiredFields;
  protected $data;
  protected $customerKey;
  protected $soapClient;

  public function __construct()
  {
    $this->configure();
    $this->data = array();

    foreach ($this->fields as $field)
    {
      $this->data[$field] = null;
    }

    $this->soapClient = ETCore::getClient();
  }

  /**
   * This method must be implemented by the derived class and takes care of
   * configuring the object for a specific data extension.
   */
  abstract protected function configure();

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
        $this->modifiedFiels[] = $fieldName;
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
          'fields'         => $this->fields,
          'primaryKeys'    => $this->primaryKeys,
          'requiredFields' => $this->requiredFields,
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
      if (!in_array($key, $this->fields))
      {
        throw new Exception($key.' is not a valid field.');
      }
    }
  }

  protected function isPrimary($fieldName)
  {
    return in_array($fieldName, $this->primaryKeys);
  }

  /**
   * Helper method that creates a SoapVar object for purposes of saving (upsert).
   *
   * @return SoapVar
   */
  protected function makeSoapVarForSave()
  {
    foreach ($this->requiredFields as $required)
    {
      if ($this->data[$required] === null || $this->data[$required] === '')
      {
        throw new Exception('Required field '.$required.' has not been set.');
      }
    }

    $deo = new ExactTarget_DataExtensionObject();
    $deo->CustomerKey = $this->customerKey;
    $deo->Properties = array();
    $deo->Keys = array();

    $this->modifiedFiels = array_unique(array_merge($this->modifiedFiels, $this->primaryKeys));

    foreach ($this->modifiedFiels as $fieldName)
    {
      $deo->Properties[] = ETCore::newAPIProperty($fieldName, $this->data[$fieldName]);
    }

    return ETCore::toSoapVar($deo, 'DataExtensionObject');
  }

  /**
   * Helper method that creates a SoapVar object for purposes of deletion
   *
   * @return type
   */
  protected function makeSoapVarForDelete()
  {
    foreach ($this->primaryKeys as $pk)
    {
      if ($this->data[$pk] === null || $this->data[$pk] === '')
      {
        throw new Exception('Primary key '.$pk.' not set.');
      }
    }

    $deo = new ExactTarget_DataExtensionObject();
    $deo->CustomerKey = $this->customerKey;
    $deo->Keys = array();

    foreach ($this->primaryKeys as $pk)
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
