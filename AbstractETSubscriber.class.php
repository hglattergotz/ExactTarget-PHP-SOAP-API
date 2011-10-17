<?php
abstract class AbstractETSubscriber
{
  protected $propertyNames = array(
      'Addresses',                    //	SubscriberAddress[]	Indicates addresses belonging to a subscriber.
      'Attributes',                   //	Attribute[]	Specifies attributes associated with an object.
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
  protected $attributeNames;
  protected $attributes = array();
  protected $requiredAttributes;

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
    
    $this->soapClient = ETCore::getClient();
  }
  
  /**
   * This method must be implemented by the derived class and takes care of
   * configuring the object for a specific data extension.
   */
  abstract protected function configure();

  public function fromArray($data)
  {
    
  }
  
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
          $this->setAttribute($attribute->Name, $attribute->Value);
        }
      }
      else
      {
        $this->setProperty($k, $v);
      }
    }
  }

  public function save()
  {
    $subscriber = new ExactTarget_Subscriber();
    $subscriber->EmailAddress = "help@example.com";
    $subscriber->SubscriberKey = "help@example.com";

//        // This section is needed if you are adding a subscriber to a Lock and Publish account using an enterprise API user
//        $cl = new ExactTarget_ClientID();
//        $cl->ID = 123;
//        $subscriber->Client = $cl;
//        $subscriber->Lists = array();   
    
    $ExampleAttribute1 = new ExactTarget_Attribute();
    $ExampleAttribute1->Name = "First Name";
    $ExampleAttribute1->Value = "Ding";   

    $ExampleAttribute2 = new ExactTarget_Attribute();
    $ExampleAttribute2->Name = "Last Name";
    $ExampleAttribute2->Value = "Dong";
        
    $subscriber->Attributes=array($ExampleAttribute1,$ExampleAttribute2);      

//        $list = new ExactTarget_SubscriberList();
//        $list->ID = "12345"; // This is the ID of the subscriber list             
//        $subscriber->Lists[] = $list;

        // This is the section needed to define it as an "Upsert"
    $so = new ExactTarget_SaveOption();
    $so->PropertyName = "*";
    $so->SaveAction = ExactTarget_SaveAction::UpdateAdd;            
    $soe = new SoapVar($so, SOAP_ENC_OBJECT, 'SaveOption', "http://exacttarget.com/wsdl/partnerAPI");            
    $opts = new ExactTarget_UpdateOptions();            
    $opts->SaveOptions = array($soe);

        // Below are examples of updating the subscriber status to active or unsub
        //$subscriber->Status = ExactTarget_SubscriberStatus::Active;
        //$subscriber->Status = ExactTarget_SubscriberStatus::Unsubscribed;

    $object = new SoapVar($subscriber, SOAP_ENC_OBJECT, 'Subscriber', "http://exacttarget.com/wsdl/partnerAPI");

    $request = new ExactTarget_CreateRequest();
    $request->Options = $opts;
    $request->Objects = array($object);            

    $result = $this->soapClient->Create($request);

    ETCore::evaluateSoapResult($result);
    
    return true;
  }
  
  public function delete()
  {
    
  }
  
  protected function setProperty($name, $value)
  {
    if (!array_key_exists($name, $this->properties))
    {
      throw new Exception('Invalid property '.$name.'!');
    }
    
    $this->properties[$name] = $value;
  }
  
  protected function setAttribute($name, $value)
  {
    if (!array_key_exists($name, $this->attributes))
    {
      throw new Exception('Invalid attribute '.$name.'!');
    }
    
    $this->attributes[$name] = $value;
  }
}
