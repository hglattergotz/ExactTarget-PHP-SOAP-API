<?php
abstract class AbstractETSubscriberList
{
  protected $soapClient;
  protected $subscriberClassName;

  public function __construct()
  {
    $this->soapClient = ETCore::getClient();

    $className = get_class($this);
    $this->subscriberClassName = substr($className, 0 , -4);
  }

  /**
   *
   * @param mixed $filter          An ExactTarget_SimpleFilterPart object or
   *                               an ExactTarget_ComplexFilterPart object.
   * @param integer $hydrationMode 
   */
  public function find($filter, $hydrationMode = ETCore::HYDRATE_ARRAY)
  {
    return $this->_find($filter, $hydrationMode, false);
  }
  
  /**
   * Return Subscriber records that match the search criteria.
   * 
   * @param string $property      The name of the property to match
   * @param string $value         The value of the property to match
   * @param int    $hydrationMode The hydration mode
   * 
   * @return mixed Either an array or an ETCollection object
   */
  public function findByProperty($property, $value, $hydrationMode = ETCore::HYDRATE_ARRAY)
  {
    $sfp = $this->newSimpleFilterPart($property, $value);

    return $this->_find($sfp, $hydrationMode, false, false);
  }

  public function findOneByProperty($property, $value, $hydrationMode = ETCore::HYDRATE_ARRAY)
  {
    $sfp = $this->newSimpleFilterPart($property, $value);

    return $this->_find($sfp, $hydrationMode, false, true);
  }
  
  public function _find($filter, $hydrationMode = ETCore::HYDRATE_ARRAY, $one = false)
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
      throw new Exception('First parameter must be of type ExactTarget_SimpleFilterPart or ExactTarget_ComplexFilterPart.');
    }
    
    $rr = new ExactTarget_RetrieveRequest();
    $rr->ObjectType = "Subscriber";
    $rr->Properties = $this->retrievableProperties();
    
    $rr->Filter = ETCore::toSoapVar($filter, $typeName);
    $rr->Options = null;

    $rrm = new ExactTarget_RetrieveRequestMsg();
    $rrm->RetrieveRequest = $rr;

    $result = $this->soapClient->Retrieve($rrm);

    ETCore::evaluateSoapResult($result);

    return $this->hydrate($result, $hydrationMode, $one);
  }

  /**
   * Subset of properties that are retrievable with a Retrieve() request.
   * This was determined by trial and error.
   * 
   * @return array
   */
  protected function retrievableProperties()
  {
    $properties = array(
//      'Addresses',                    //	SubscriberAddress[]	Indicates addresses belonging to a subscriber.
//      'Attributes',                   //	Attribute[]	Specifies attributes associated with an object.
//      'Client',                       //	ClientID	Specifies the account ownership and context of an object.
//      'CorrelationID',                //	xsd:string	Identifies correlation of objects across several requests.
        'CreatedDate', //	xsd:dateTime	Read-only date and time of the object's creation.
//      'CustomerKey',                  //	xsd:string	User-supplied unique identifier for an object within an object type.
        'EmailAddress', //	xsd:string	Contains the email address for a subscriber. Indicates the data extension field contains email address data.
        'EmailTypePreference', //	EmailType	The format in which email should be sent
//      'GlobalUnsubscribeCategory',    //	GlobalUnsubscribeCategory	Indicates how the application handles a globally unsubscribed subscriber.
        'ID', //	xsd:int	Read-only legacy identifier for an object. Not supported on all objects.
//      'Lists',                        //	SubscriberList[]	Defines lists a subscriber resides on.
//      'Locale',                       //	Locale	Contains the locale information for an Account.
//      'ModifiedDate',                 //	Nullable`1	Last time object information was modified.
//      'ObjectID',                     //	xsd:string	System-controlled, read-only text string identifier for object.
//      'ObjectState',                  //	xsd:string	Reserved for future use.
//      'Owner',                        //	Owner	Describes account ownership of subscriber in an on-your-behalf account.
        'PartnerKey', //	xsd:string	Unique identifier provided by partner for an object, accessible only via API.
//      'PartnerProperties',            //	APIProperty[]	A collection of metadata supplied by client and stored by system - only accessible via API.
//      'PartnerType',                  //	xsd:string	Defines partner associated with a subscriber.
//      'PrimaryEmailAddress',          //	EmailAddress	Indicates primary email address for a subscriber.
//      'PrimarySMSAddress',            //	SMSAddress	Indicates primary SMS address for a subscriber.
//      'PrimarySMSPublicationStatus',  //	SubscriberAddressStatus	Indicates the subscriber's modality status.
        'Status', //	SubscriberStatus	Defines status of object.  Status of an address.
        'SubscriberKey', //	xsd:string	Identification of a specific subscriber.
//      'SubscriberTypeDefinition',     //	SubscriberTypeDefinition	Specifies if a subscriber resides in an integration, such as Salesforce or Microsoft Dynamics CRM
        'UnsubscribedDate'
    );

    return $properties;
  }
  
  /**
   * Hydrate the result set.
   * 
   * @param mixed $soapResult    The soap result object
   * @param int   $hydrationMode The hydration mode
   * 
   * @return mixed Either an array or an ETCollection object
   */
  protected function hydrate($soapResult, $hydrationMode, $one = false)
  {
    $final = null;
    
    $result = $soapResult->Results;
    
    if (!is_array($result))
    {
      $result = array($result);
    }
    
    if ($hydrationMode === ETCore::HYDRATE_ARRAY)
    {
      $final = array();
    }
    else if ($hydrationMode === ETCore::HYDRATE_RECORD)
    {
      $final = new ETCollection();
    }
    
    foreach ($result as $soapSub)
    {
      $sub = new $this->subscriberClassName();
      $sub->fromSoapResult($soapSub);

      if ($hydrationMode === ETCore::HYDRATE_ARRAY)
      {
        $final[] = $sub->toArray();
        
        if ($one)
        {
          $final = $sub->toArray();
          break;
        }
      }
      else if ($hydrationMode === ETCore::HYDRATE_RECORD)
      {
        $final->add($sub);
        
        if ($one)
        {
          $final = $sub;
          break;
        }
      }
    }
    
    return $final;
  }
  
  protected function newSimpleFilterPart($property, $value, $operator = ExactTarget_SimpleOperators::equals)
  {
    $sfp = new ExactTarget_SimpleFilterPart();
    $sfp->Value = array($value);
    $sfp->SimpleOperator = $operator;
    $sfp->Property = $property;
    
    return $sfp;
  }
}