<?php
class ETCollection
{
  protected $data = array();
  protected $soapClient;

  public function __construct()
  {
    $this->soapClient = ETCore::getClient();
  }

  abstract public function save();

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
      if ($val === $record)
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
    
      $uo = new ExactTarget_UpdateOptions();
      $uo->SaveOptions = array();
      
      $so = new ExactTarget_SaveOption();
      $so->PropertyName = '*';
      $so->SaveAction = ExactTarget_SaveAction::UpdateAdd;
      
      $uo->SaveOptions[] = $so;
      $uoSo = ETCore::toSoapVar($uo, 'UpdateOptions');
      
      $request = new ExactTarget_UpdateRequest();
      $request->Options = $uoSo;
      $request->Objects = $data;
      $result = $this->soapClient->Update($request);
      
      $this->evaluateResult($result);
      
      return true;
    }
    catch (Exception $e)
    {
      throw new Exception(__METHOD__ . ':' . __LINE__ . '|' . $e->getMessage());
    }
  }
}