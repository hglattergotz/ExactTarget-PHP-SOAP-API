<?php
class ETCollection
{
  protected $data = array();

  public function __construct()
  {}

  /**
   * Process the soap result and throw an exception if something went wrong
   * 
   * @param type $result 
   */
  protected function evaluateResult($result)
  {
    ETCore::evaluateSoapResult($result);
  }

  public function count()
  {
    return count($this->data);
  }

  public function getFirst()
  {
    return reset($this->data);
  }

  public function getLast()
  {
    return end($this->data);
  }

  public function getData()
  {
    return $this->data;
  }

  public function toArray()
  {
    $data = array();

    foreach ($this as $record)
    {
      $data[] = $record->toArray();
    }

    return $data;
  }

  public function add($obj)
  {
    foreach ($this->data as $val)
    {
      if ($val === $obj)
      {
        return false;
      }
    }

    $this->data[] = $obj;

    return true;
  }

  public function getIterator()
  {
    $data = $this->data;

    return new ArrayIterator($data);
  }

  public function save()
  {
    $data = array();
    
    try
    {
      foreach ($this->data as $rec)
      {
        $data[] = $rec->toSoapVar();
      }
    
      $result = ETCore::upsert($data);
      ETCore::evaluateSoapResult($result);
      
      return true;
    }
    catch (Exception $e)
    {
      throw new Exception(__METHOD__ . ':' . __LINE__ . '|' . $e->getMessage());
    }
  }
  
  /**
   * Delete all records from this collection.
   */
  public function delete()
  {
    $data = array();
    
    try
    {
      foreach ($this->data as $rec)
      {
        $data[] = $rec->toSoapVar();
      }
    
      $result = ETCore::delete($data);
uDebug::echoVar('raw error', $result);
      ETCore::evaluateSoapResult($result);
      
      return true;
    }
    catch (Exception $e)
    {
      throw new Exception(__METHOD__ . ':' . __LINE__ . '|' . $e->getMessage());
    }
  }
}