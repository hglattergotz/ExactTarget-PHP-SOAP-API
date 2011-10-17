<?php
abstract class AbstractETDataExtension
{
  protected $soapClient;
  
  protected $customerKey;
  
  protected $schema;
  
  protected $extensionObjectClassName;
  
  public function __construct()
  {
    $extensionClassName = get_class($this);
    $this->extensionObjectClassName = $extensionClassName.'Object';
    
    $deo = new $this->extensionObjectClassName();
    $schema = $deo->getSchema();
    $this->customerKey = $schema['customerKey'];
    $this->schema = $schema['fields'];

    $this->soapClient = ETCore::getClient();
  }
  
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
        $coll = new ETDataExtensionObjectCollection();
        
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
      throw new Exception(__METHOD__ . ':' . __LINE__ . '|' . $e->getMessage());
    }
  }
}