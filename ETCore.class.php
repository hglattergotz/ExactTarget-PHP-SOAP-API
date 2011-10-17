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
    
//    uDebug::echoVar('Result', $result);
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
}

