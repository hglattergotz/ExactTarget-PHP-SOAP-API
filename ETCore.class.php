<?php
class ETCore
{
  const HYDRATE_ARRAY  = 1;
  
  const HYDRATE_RECORD = 2;
  
  protected static $instance = null;
  
  protected $userName;
  
  protected $password;
  
  protected $wsdl = 'https://webservice.exacttarget.com/etframework.wsdl';
  
  public static function initialize($userName, $password)
  {
    $instance = new self();
    $instance->userName = $userName;
    $instance->password = $password;
    
    self::$instance = $instance;
  }
  
  public static function getClient()
  {
    if (self::$instance === null)
    {
      throw new Exception('Exact Target environment is not initialized!');
    }
    
    $client = new ExactTargetSoapClient(self::$instance->wsdl, array('trace' => 0, 'soap_version' => SOAP_1_1));

    $client->username = self::$instance->userName;
    $client->password = self::$instance->password;
  
    return $client;
  }
  
  protected static function _update($objects, $saveAction)
  {
    try
    {
      $soapClient = self::getClient();
      
      $uo = new ExactTarget_UpdateOptions();
      $uo->SaveOptions = array();
      
      $so = new ExactTarget_SaveOption();
      $so->PropertyName = '*';
      $so->SaveAction = $saveAction;
      
      $uo->SaveOptions[] = $so;
      $uoSo = ETCore::toSoapVar($uo, 'UpdateOptions');
      
      $request = new ExactTarget_UpdateRequest();
      $request->Options = $uoSo;
      $request->Objects = $objects;
      
      return $soapClient->Update($request);
    }
    catch (Exception $e)
    {
      throw new Exception(__METHOD__ . ':' . __LINE__ . '|' . $e->getMessage());
    }
  }
  
  public static function upsert($objects)
  {
    return self::_update($objects, ExactTarget_SaveAction::UpdateAdd);
  }
  
  public static function update($objects)
  {
    return self::_update($objects, ExactTarget_SaveAction::UpdateOnly);
  }
  
  public static function evaluateSoapResult($result)
  {
    if ($result->OverallStatus != 'OK')
    {
      $msg = '';
      
      if (property_exists($result, 'Results') && property_exists($result->Results, 'StatusCode'))
      {
        $msg = 'StatusCode='.$result->Results->StatusCode.'|StatusMessage='.$result->Results->StatusMessage;
      }
      else
      {
        $msg = $result->OverallStatus;
      }
      
      throw new Exception($msg);
    }
  }

  public static function toSoapVar($object, $name)
  {
    return new SoapVar($object, SOAP_ENC_OBJECT, $name, 'http://exacttarget.com/wsdl/partnerAPI');
  }
  
  /**
   *
   * @return type 
   */
  public static function getVersionHistory()
  {
    try
    {
      $client = self::getClient();
      $param = new ExactTarget_VersionInfoRequestMsg();
      $param->IncludeVersionHistory = True;

      return $client->VersionInfo($param);
    }
    catch (Exception $e)
    {
      throw $e;
    }
  }

  /**
   *
   * @return type 
   */
  public static function getSystemStatus()
  {
    try
    {
      $client = self::getClient();
      $param = new ExactTarget_SystemStatusRequestMsg();

      return $client->GetSystemStatus($param);
    }
    catch (Exception $e)
    {
      throw $e;
    }
  }
  
  /**
   * Utility method that reduces code volume by constucting an APIProperty
   * object.
   * 
   * @param string $name  The name of the property
   * @param string $value The value of the property
   * 
   * @return ExactTarget_APIProperty 
   */
  public static function newAPIProperty($name, $value)
  {
    $prop = new ExactTarget_APIProperty();
    $prop->Name = $name;
    $prop->Value = $value;
    
    return $prop;
  }
  
  public static function newAttribute($name, $value)
  {
    $attr = new ExactTarget_Attribute();
    $attr->Name = $name;
    $attr->Value = $value;
    
    return $attr;
  }
}

