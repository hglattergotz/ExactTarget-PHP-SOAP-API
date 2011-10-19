<?php
class ETCore
{
  /**
   * Hydrate results as arrays
   */
  const HYDRATE_ARRAY  = 1;
  
  /**
   * Hydrate results as records (objects)
   */
  const HYDRATE_RECORD = 2;
  
  /**
   * @var ETCore holds an instance of ETCore (singleton)
   */
  protected static $instance = null;
  
  /**
   * @var string The username for the ExactTarget account
   */
  protected $userName;
  
  /**
   * @var string The password for the ExactTarget account
   */
  protected $password;
  
  /**
   * @var string The wsdl url
   */
  protected $wsdl = 'https://webservice.exacttarget.com/etframework.wsdl';
  
  /**
   * Create an instance of the ETCore class and store it in the static instance
   * variable.
   * Essentially this allows for setting the ExactTarget credentials once per
   * script.
   * 
   * @param string $userName
   * @param string $password 
   */
  public static function initialize($userName, $password)
  {
    $instance = new self();
    $instance->userName = $userName;
    $instance->password = $password;
    
    self::$instance = $instance;
  }
  
  /**
   * Return an instance of the fully configured ExactTarget SOAP client.
   * 
   * @return ExactTargetSoapClient 
   */
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
  
  /**
   * ExactTarget SOAP update that allows the update action to be specified.
   * 
   * @param array   $objects Array of SOAP objects to be updated
   * @param integet $saveAction A constant integer specifying the action.
   * 
   * @return ExactTarget SOAP response
   * $throws Exception
   */
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
  
  /**
   * Generic upsert operation. Updates existing records and inserts them if they
   * do not yet exist.
   * 
   * @param type $objects
   * @return type 
   */
  public static function upsert($objects)
  {
    return self::_update($objects, ExactTarget_SaveAction::UpdateAdd);
  }
  
  /**
   * Explicit update operation.
   * 
   * @param type $objects
   * @return type 
   */
  public static function update($objects)
  {
    return self::_update($objects, ExactTarget_SaveAction::UpdateOnly);
  }
  
  /**
   * Utility method for parsing the SOAP response and throwing an exception with
   * a the appropriate error message.
   * 
   * @param type $result 
   */
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

  /**
   * Encode an object as a SOAP variable.
   * 
   * @param type $object
   * @param type $name
   * @return SoapVar 
   */
  public static function toSoapVar($object, $name)
  {
    return new SoapVar($object, SOAP_ENC_OBJECT, $name, 'http://exacttarget.com/wsdl/partnerAPI');
  }
  
  /**
   * Get the version history from the ET SOAP API.
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
   * Get the ET system status.
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
   * Utility method that reduces code volume by constructing an APIProperty
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
  
  /**
   * Utility method that reduces code volume by constructing an Attribute
   * object.
   * 
   * @param string $name  The name of the attribute
   * @param string $value The value of the attribute
   * 
   * @return ExactTarget_Attribute
   */
  public static function newAttribute($name, $value)
  {
    $attr = new ExactTarget_Attribute();
    $attr->Name = $name;
    $attr->Value = $value;
    
    return $attr;
  }
}

