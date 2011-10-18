<?php
abstract class AbstractETSubscriber
{
  protected $propertyNames = array(
      'Addresses',                    //	SubscriberAddress[]	Indicates addresses belonging to a subscriber.
//      'Attributes',                   //	Attribute[]	Specifies attributes associated with an object.
      'Client',                       //	ClientID	Specifies the account ownership and context of an object.
      'CorrelationID',                //	xsd:string	Identifies correlation of objects across several requests.
      'CreatedDate',                  //	xsd:dateTime	Read-only date and time of the object's creation.
      'CustomerKey',                  //	xsd:string	User-supplied unique identifier for an object within an object type.
      'EmailAddress',                 //	xsd:string	Contains the email address for a subscriber. Indicates the data extension field contains email address data.
      'EmailTypePreference',          //	EmailType	The format in which email should be sent
      'GlobalUnsubscribeCategory',    //	GlobalUnsubscribeCategory	Indicates how the application handles a globally unsubscribed subscriber.
      'ID',                           //	xsd:int	Read-only legacy identifier for an object. Not supported on all objects.
      'Lists',                        //	SubscriberList[]	Defines lists a subscriber resides on.
      'Locale',                       //	Locale	Contains the locale information for an Account.
      'ModifiedDate',                 //	Nullable`1	Last time object information was modified.
      'ObjectID',                     //	xsd:string	System-controlled, read-only text string identifier for object.
      'ObjectState',                  //	xsd:string	Reserved for future use.
      'Owner',                        //	Owner	Describes account ownership of subscriber in an on-your-behalf account.
      'PartnerKey',                   //	xsd:string	Unique identifier provided by partner for an object, accessible only via API.
      'PartnerProperties',            //	APIProperty[]	A collection of metadata supplied by client and stored by system - only accessible via API.
      'PartnerType',                  //	xsd:string	Defines partner associated with a subscriber.
      'PrimaryEmailAddress',          //	EmailAddress	Indicates primary email address for a subscriber.
      'PrimarySMSAddress',            //	SMSAddress	Indicates primary SMS address for a subscriber.
      'PrimarySMSPublicationStatus',  //	SubscriberAddressStatus	Indicates the subscriber's modality status.
      'Status',                       //	SubscriberStatus	Defines status of object.  Status of an address.
      'SubscriberKey',                //	xsd:string	Identification of a specific subscriber.
      'SubscriberTypeDefinition',     //	SubscriberTypeDefinition	Specifies if a subscriber resides in an integration, such as Salesforce or Microsoft Dynamics CRM
      'UnsubscribedDate'      
  );
  protected $properties = array();
  protected $requiredProperties = array();
  protected $modifiedProperties = array();
  protected $attributeNames = array();
  protected $attributes = array();
  protected $requiredAttributes = array();
  protected $modifiedAttributes = array();
  protected $soapClient;

  public function __construct()
  {
    $this->configure();

    foreach ($this->propertyNames as $pName)
    {
      $this->properties[$pName] = null;
    }
    
    foreach ($this->attributeNames as $aName)
    {
      $this->attributes[$aName] = null;
    }
    
    $requiredProperties = array('EmailAddress');
    $this->requiredProperties = array_unique(array_merge($requiredProperties, $this->requiredProperties));
    
    $this->soapClient = ETCore::getClient();
  }
  
  /**
   * This method must be implemented by the derived class handles the custom
   * attribute configuration.
   */
  abstract protected function configure();

  public function fromArray($data)
  {
    foreach ($data as $k => $v)
    {
      if ($v === 'Attributes')
      {
        foreach ($v as $ak => $av)
        {
          $this->_setAttribute($ak, $av);
        }
      }
      else
      {
        $this->_setProperty($k, $v);
      }
    }
  }
  
  /**
   * Populate the subscriber object with the result returned from a SOAP result.
   * 
   * @param type $soap 
   */
  public function fromSoapResult($soap)
  {
    $res = (array)$soap;
    
    foreach ($res as $k => $v)
    {
      if ($k === 'Attributes')
      {
        if (!is_array($v))
        {
          $v = array($v);
        }
        
        foreach ($v as $attribute)
        {
          $this->_setAttribute($attribute->Name, $attribute->Value);
        }
      }
      else
      {
        $this->_setProperty($k, $v);
      }
    }
  }

  public function toArray()
  {
    $array = $this->properties;
    $array['Attributes'] = $this->attributes;
    
    return $array;
  }
  
  
  public function save()
  {
    $objects = array($this->makeSoapVar());
    $result = ETCore::upsert($objects);
    ETCore::evaluateSoapResult($result);
    
    $this->clearModified();
    
    return true;
  }
  
  public function delete()
  {
    $obj = $this->makeSoapVar(true, false);
    
    $request = new ExactTarget_DeleteRequest();
    $request->Options = null;
    $request->Objects = array($obj);

    $result = $this->soapClient->Delete($request);
  }
  
  public function setProperty($name, $value)
  {
    return $this->_setProperty($name, $value);
  }
  
  public function setAttribute($name, $value)
  {
    return $this->_setAttribute($name, $value);
  }
  
  protected function _setProperty($name, $value)
  {
    if (!array_key_exists($name, $this->properties))
    {
      throw new Exception('Invalid property '.$name.'!');
    }
    
    if ($name === 'Attributes')
    {
      foreach ($value as $n => $v)
      {
        $this->_setAttribute($n, $v);
      }
    }
    else
    {
      $this->modifiedProperties[] = $name;
    }
    
    $this->properties[$name] = $value;
    
    return true;
  }
  
  protected function _setAttribute($name, $value)
  {
    if (!array_key_exists($name, $this->attributes))
    {
      throw new Exception('Invalid attribute '.$name.'!');
    }
    
    $this->attributes[$name] = $value;
    $this->modifiedAttributes[] = $name;
    
    return true;
  }

  protected function checkRequiredProperties()
  {
    foreach ($this->requiredAttributes as $required)
    {
      if ($this->attributes[$required] === null || $this->attributes[$required] === '')
      {
        throw new Exception('Required attribute '.$required.' as not been set.');
      }
    }
    
    return true;
  }

  protected function checkRequiredAttributes()
  {
    foreach ($this->requiredProperties as $required)
    {
      if ($this->properties[$required] === null || $this->properties[$required] === '')
      {
        throw new Exception('Required property '.$required.' as not been set.');
      }
    }
    
    return true;
  }

  /**
   * Helper method that creates a SoapVar object.
   * 
   * @return SoapVar 
   */
  protected function makeSoapVar($checkProperties = true, $checkAttributes = true)
  {
    if ($checkProperties)
    {
      $this->checkRequiredProperties();
    }
    
    if ($checkAttributes)
    {
      $this->checkRequiredAttributes();
    }
    
    $subscriber = new ExactTarget_Subscriber();
    $this->modifiedProperties = array_unique(array_merge($this->modifiedProperties, $this->requiredProperties));
    
    foreach ($this->modifiedProperties as $propName)
    {
      $subscriber->$propName = $this->properties[$propName];
    }
    
    $subscriber->Attributes = array();
    $this->modifiedAttributes = array_unique(array_merge($this->modifiedAttributes, $this->requiredAttributes));
    
    foreach ($this->modifiedAttributes as $attrName)
    {
      $subscriber->Attributes[] = ETCore::newAttribute($attrName, $this->attributes[$attrName]);
    }
    
    return ETCore::toSoapVar($subscriber, 'Subscriber');
  }
  
  protected function clearModified()
  {
    $this->modifiedAttributes = array();
    $this->modifiedProperties = array();
  }
}
