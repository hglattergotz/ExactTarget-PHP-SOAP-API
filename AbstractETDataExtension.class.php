<?php
/**
 * Base class for an ExactTarget data extension. Provides methods that operate
 * on a data extension (Table).
 */
abstract class AbstractETDataExtension
{
  /**
   * @var ExactTargetSoapClient Instance of the ET SOAP client
   */
  protected $soapClient;

  /**
   * @var string The customer key for this particular data extension
   */
  protected $customerKey;

  /**
   * @var array The data extension schema (build from data that is fetched from
   *            the dataExtensionObject.
   */
  protected $schema;

  /**
   * @var AbstractETDataExtensionObject Related record class for this table.
   */
  protected $extensionObjectClassName;

  public function __construct($customerKey = null)
  {
    $extensionClassName = get_class($this);
    $this->extensionObjectClassName = $extensionClassName.'Object';

    if ($customerKey === null)
    {
      $deo = new $this->extensionObjectClassName();
    }
    else
    {
      $deo = new $this->extensionObjectClassName($customerKey);
    }

    $schema = $deo->getSchema();
    $this->customerKey = $schema['customerKey'];
    $this->schema = $schema['fields'];

    $this->soapClient = ETCore::getClient();
  }

  /**
   * Find records based on the passed filter.
   *
   * Example usage:
   *
   * $f = new ExactTarget_SimpleFilterPart();
   * $f->Property = 'id';
   * $f->Value = $id;
   * $f->SimpleOperator = ExactTarget_SimpleOperators::equals;
   *
   * $de = new MyDataExtension();
   * $records = $de->find($f, ETCore::HYDRATE_ARRAY);
   *
   * @param mixed   $filter        SimpleFilterPart or ComplexFilterPart
   * @param integer $hydrationMode See ETCore
   * @return mixed  ETCollection or array, depending on hydration mode
   * @throws Exception
   */
  public function find($filter, $hydrationMode = ETCore::HYDRATE_ARRAY)
  {
    try
    {
      $typeName = null;

      if ($filter instanceof ExactTarget_SimpleFilterPart)
      {
        $typeName = 'SimpleFilterPart';
      }
      else if ($filter instanceof ExactTarget_ComplexFilterPart)
      {
        $typeName = 'ComplexFilterPart';
      }
      else
      {
        throw new ETException('First parameter must be of type ExactTarget_SimpleFilterPart or ExactTarget_ComplexFilterPart.');
      }

      $res = null;

      $rr = new ExactTarget_RetrieveRequest();
      $rr->ObjectType = 'DataExtensionObject['.$this->customerKey.']';
      $rr->Properties = $this->schema;
      $rr->Filter = ETCore::toSoapVar($filter, $typeName);
      $rr->Options = null;

      $rrm = new ExactTarget_RetrieveRequestMsg();
      $rrm->RetrieveRequest = $rr;

      $result = $this->soapClient->Retrieve($rrm);

      $records = array();

      if (!property_exists($result, 'Results'))
      {
        $result->Results = array();
      }

      if (!is_array($result->Results))
      {
        $result->Results = array($result->Results);
      }

      foreach ($result->Results as $fields)
      {
        $record = array();

        foreach ($fields->Properties->Property as $field)
        {
          $record[$field->Name] = $field->Value;
        }

        if (count($record) > 0)
        {
          $records[] = $record;
        }
      }

      if ($hydrationMode == ETCore::HYDRATE_ARRAY)
      {
        $res = $records;
      }
      else
      {
        $coll = new ETCollection();

        foreach ($records as $record)
        {
          $eo = new $this->extensionObjectClassName();
          $eo->fromArray($record);

          $coll->add($eo);
        }

        $res = $coll;
      }

      return $res;
    }
    catch (Exception $e)
    {
      throw new ETException(__METHOD__ . ':' . __LINE__ . '|' . $e->getMessage());
    }
  }

  /**
   * Get all records from the table (data extension).
   *
   * @param integer $hydrationMode ETCore::HYDRATE_ARRAY will return an array
   *                               representation of the records in the table.
   *                               ETCore::HYDRATE_RECORD will return an
   *                               ETCollection that contains xxxObject objects.
   * @return mixed ETCollection or Array, depending on hydration mode.
   * @throws Exception
   */
  public function findAll($hydrationMode = ETCore::HYDRATE_ARRAY)
  {
    try
    {
      $res = null;

      $rr = new ExactTarget_RetrieveRequest();
      $rr->ObjectType = 'DataExtensionObject['.$this->customerKey.']';
      $rr->Properties = $this->schema;
      $rr->Options = null;

      $rrm = new ExactTarget_RetrieveRequestMsg();
      $rrm->RetrieveRequest = $rr;

      $result = $this->soapClient->Retrieve($rrm);
      ETCore::evaluateSoapResult($result);

      $records = array();

      if (!property_exists($result, 'Results'))
      {
        $result->Results = array();
      }

      if (!is_array($result->Results))
      {
        $result->Results = array($result->Results);
      }

      foreach ($result->Results as $fields)
      {
        $record = array();

        foreach ($fields->Properties->Property as $field)
        {
          $record[$field->Name] = $field->Value;
        }

        if (count($record) > 0)
        {
          $records[] = $record;
        }
      }

      if ($hydrationMode == ETCore::HYDRATE_ARRAY)
      {
        $res = $records;
      }
      else
      {
        $coll = new ETCollection();

        foreach ($records as $record)
        {
          $eo = new $this->extensionObjectClassName();
          $eo->fromArray($record);

          $coll->add($eo);
        }

        $res = $coll;
      }

      return $res;
    }
    catch (Exception $e)
    {
      throw new ETException(__METHOD__ . ':' . __LINE__ . '|' . $e->getMessage());
    }
  }
}
