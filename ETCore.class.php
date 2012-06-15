<?php
/**
 * ETCore
 *
 * Core the api wrapper that provides all the base functionality
 *
 * @package ExactTargetLib
 * @author  Henning Glatter-Gotz
 */
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
   * Delete objects
   *
   * @param type $objects
   */
  public static function delete($objects)
  {
    try
    {
      $soapClient = self::getClient();

      $request = new ExactTarget_DeleteRequest();
      $request->Options = null;
      $request->Objects = $objects;

      return $soapClient->Delete($request);
    }
    catch (Exception $e)
    {
      throw new Exception(__METHOD__ . ':' . __LINE__ . '|' . $e->getMessage());
    }
  }

  /**
   * Utility method for parsing the SOAP response and throwing an exception with
   * a the appropriate error message.
   *
   * @param type $result
   */
  public static function evaluateSoapResult($result)
  {
    switch ($result->OverallStatus)
    {
      case 'OK':
        break;
      case 'MoreDataAvailable':
        break;
      default:
        $msg = '';

        if (property_exists($result, 'Results'))
        {
          if (is_array($result->Results))
          {
            $errors = array();

            foreach ($result->Results as $res)
            {
              $errors[] = 'StatusCode='.$res->StatusCode.'|ErrorMessage='.$res->ErrorMessage;
            }

            $msg = print_r($errors, true);
          }
          else if ((is_object($result->Results)) && (property_exists($result->Results, 'StatusCode')))
          {
            $msg = 'StatusCode='.$result->Results->StatusCode.'|StatusMessage='.$result->Results->StatusMessage;
          }
          else
          {
            $msg = $result->OverallStatus;
          }
        }
        else
        {
          $msg = $result->OverallStatus;
        }

        throw new Exception($msg);
        break;
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
   * newDateRangeFilter
   *
   * Create a ComplexFilter part for a date range that includes the from and to
   * date in the range.
   * The result is a ComplexFilterPart packaged as a SoapVar
   *
   * @param string $fromDate The start date of the date range
   * @param string $toDate   The end date of the date range
   * @param string $property The name of the property to create the filter for
   * @static
   * @access public
   * @return SoapVar Instance of a ComplexFilterPart packaged as a SoapVar
   */
  public static function newDateRangeFilter($fromDate, $toDate, $property)
  {
    $fFromDate = new ExactTarget_SimpleFilterPart();
    $fFromDate->Property = $property;
    $fFromDate->DateValue = date(DATE_ATOM, strtotime($fromDate));
    $fFromDate->SimpleOperator = ExactTarget_SimpleOperators::greaterThanOrEqual;

    $fToDate = new ExactTarget_SimpleFilterPart();
    $fToDate->Property = $property;
    $fToDate->DateValue = date(DATE_ATOM, strtotime($toDate));
    $fToDate->SimpleOperator = ExactTarget_SimpleOperators::lessThanOrEqual;

    $cfDate = new ExactTarget_ComplexFilterPart();
    $cfDate->LeftOperand = self::toSoapVar($fFromDate, 'SimpleFilterPart');
    $cfDate->LogicalOperator = ExactTarget_LogicalOperators::_AND;
    $cfDate->RightOperand = self::toSoapVar($fToDate, 'SimpleFilterPart');

    return self::toSoapVar($cfDate, 'ComplexFilterPart');
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
   * getObjectDefinition
   *
   * Retrieve the definition of an object from the ExactTarget SOAP service.
   * This can be used to get detailed information on each property of an
   * object, such as the value of IsRetrievable.
   *
   * @param string $objectName
   * @static
   * @access public
   * @return array
   */
  public static function getObjectDefinition($objectName)
  {
    try
    {
      $client = self::getClient();
      $request = new ExactTarget_ObjectDefinitionRequest();
      $request->ObjectType= $objectName;
      $defRqstMsg = new ExactTarget_DefinitionRequestMsg();
      $defRqstMsg->DescribeRequests[] =  self::toSoapVar($request, 'ObjectDefinitionRequest');

      $status = $client->Describe($defRqstMsg);

      return $status->ObjectDefinition;
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

