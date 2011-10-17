<?php
abstract class AbstractETDataExtensionObject extends AbstractETRecord
{
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Helper method that creates a SoapVar object.
   * 
   * @return SoapVar 
   */
  protected function makeSoapVar()
  {
    foreach ($this->requiredProperties as $required)
    {
      if ($this->data[$required] === null || $this->data[$required] === '')
      {
        throw new Exception('Required field '.$required.' as not been set.');
      }
    }

    $deo = new ExactTarget_DataExtensionObject();
    $deo->CustomerKey = $this->customerKey;
    $deo->Properties = array();
    $deo->Keys = array();

    foreach ($this->data as $k => $v)
    {
      if ($v !== null && $v !== '')
      {
        $deo->Properties[] = new ExactTarget_APIProperty($k, $v);
      }
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
      if (!$this->changed)
      {
        return false;
      }
      
      $deoSo = $this->makeSoapVar();
      
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
      
      $this->changed = false;
      
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
        $deo->Keys[] = new ExactTarget_APIProperty($pk, $this->data[$pk]);
      }
      
      $request = new ExactTarget_DeleteRequest();
      $request->Options = null;
      $request->Objects = array(ETCore::toSoapVar($deo, 'DataExtensionObject'));

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