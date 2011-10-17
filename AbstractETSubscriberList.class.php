<?php
abstract class AbstractETSubscriberList
{
  protected $soapClient;
  
  public function __construct()
  {
    $this->soapClient = ETCore::getClient();
  }
  
  public function findByProperty($field, $value)
  {
    $rr = new ExactTarget_RetrieveRequest();
    $rr->ObjectType = "Subscriber";
    $rr->Properties = array(
//      'Addresses',                    //	SubscriberAddress[]	Indicates addresses belonging to a subscriber.
//      'Attributes',                   //	Attribute[]	Specifies attributes associated with an object.
//      'Client',                       //	ClientID	Specifies the account ownership and context of an object.
//      'CorrelationID',                //	xsd:string	Identifies correlation of objects across several requests.
      'CreatedDate',                  //	xsd:dateTime	Read-only date and time of the object's creation.
//      'CustomerKey',                  //	xsd:string	User-supplied unique identifier for an object within an object type.
      'EmailAddress',                 //	xsd:string	Contains the email address for a subscriber. Indicates the data extension field contains email address data.
      'EmailTypePreference',          //	EmailType	The format in which email should be sent
//      'GlobalUnsubscribeCategory',    //	GlobalUnsubscribeCategory	Indicates how the application handles a globally unsubscribed subscriber.
      'ID',                           //	xsd:int	Read-only legacy identifier for an object. Not supported on all objects.
//      'Lists',                        //	SubscriberList[]	Defines lists a subscriber resides on.
//      'Locale',                       //	Locale	Contains the locale information for an Account.
//      'ModifiedDate',                 //	Nullable`1	Last time object information was modified.
//      'ObjectID',                     //	xsd:string	System-controlled, read-only text string identifier for object.
//      'ObjectState',                  //	xsd:string	Reserved for future use.
//      'Owner',                        //	Owner	Describes account ownership of subscriber in an on-your-behalf account.
      'PartnerKey',                   //	xsd:string	Unique identifier provided by partner for an object, accessible only via API.
//      'PartnerProperties',            //	APIProperty[]	A collection of metadata supplied by client and stored by system - only accessible via API.
//      'PartnerType',                  //	xsd:string	Defines partner associated with a subscriber.
//      'PrimaryEmailAddress',          //	EmailAddress	Indicates primary email address for a subscriber.
//      'PrimarySMSAddress',            //	SMSAddress	Indicates primary SMS address for a subscriber.
//      'PrimarySMSPublicationStatus',  //	SubscriberAddressStatus	Indicates the subscriber's modality status.
      'Status',                       //	SubscriberStatus	Defines status of object.  Status of an address.
      'SubscriberKey',                //	xsd:string	Identification of a specific subscriber.
//      'SubscriberTypeDefinition',     //	SubscriberTypeDefinition	Specifies if a subscriber resides in an integration, such as Salesforce or Microsoft Dynamics CRM
      'UnsubscribedDate'      
  );
    $sfp = new ExactTarget_SimpleFilterPart();
    $sfp->Value = array($value);
    $sfp->SimpleOperator = ExactTarget_SimpleOperators::equals;
    $sfp->Property = $field;

    $rr->Filter = new SoapVar($sfp, SOAP_ENC_OBJECT, 'SimpleFilterPart', "http://exacttarget.com/wsdl/partnerAPI");
    $rr->Options = NULL;
    $rrm = new ExactTarget_RetrieveRequestMsg();
    $rrm->RetrieveRequest = $rr;

    $result = $this->soapClient->Retrieve($rrm);
    
    ETCore::evaluateSoapResult($result);

    return $result;
  }

}