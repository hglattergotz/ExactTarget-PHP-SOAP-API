<?php
//require('soap-wsse.php');

class ExactTargetSoapClient extends SoapClient {
  public $username = NULL;
  public $password = NULL;

  function __doRequest($request, $location, $saction, $version, $one_way = null) {
    $doc = new DOMDocument();
    $doc->loadXML($request);

    $objWSSE = new WSSESoap($doc);
    $objWSSE->addUserToken($this->username, $this->password, FALSE);
    $xml = $objWSSE->saveXML();

    $result = parent::__doRequest($xml, $location, $saction, $version, $one_way);
    return $result;
   }
}

class ExactTarget_APIFault {
  /**
   * @var int $Code
   */
  public $Code;
  /**
   * @var string $Message
   */
  public $Message;
  /**
   * @var long $LogID
   */
  public $LogID;
  /**
   * @var ExactTarget_Params $Params
   */
  public $Params;
}

class ExactTarget_Params {
  /**
   * @var string $Param
   */
  public $Param;
}

class ExactTarget_APIObject {
  /**
   * @var ExactTarget_ClientID $Client
   */
  public $Client;
  /**
   * @var string $PartnerKey
   */
  public $PartnerKey;
  /**
   * @var ExactTarget_APIProperty $PartnerProperties
   */
  public $PartnerProperties;
  /**
   * @var dateTime $CreatedDate
   */
  public $CreatedDate;
  /**
   * @var dateTime $ModifiedDate
   */
  public $ModifiedDate;
  /**
   * @var int $ID
   */
  public $ID;
  /**
   * @var string $ObjectID
   */
  public $ObjectID;
  /**
   * @var string $CustomerKey
   */
  public $CustomerKey;
  /**
   * @var ExactTarget_Owner $Owner
   */
  public $Owner;
  /**
   * @var string $CorrelationID
   */
  public $CorrelationID;
  /**
   * @var string $ObjectState
   */
  public $ObjectState;
}

class ExactTarget_ClientID {
  /**
   * @var int $ClientID
   */
  public $ClientID;
  /**
   * @var int $ID
   */
  public $ID;
  /**
   * @var string $PartnerClientKey
   */
  public $PartnerClientKey;
  /**
   * @var int $UserID
   */
  public $UserID;
  /**
   * @var string $PartnerUserKey
   */
  public $PartnerUserKey;
  /**
   * @var int $CreatedBy
   */
  public $CreatedBy;
  /**
   * @var int $ModifiedBy
   */
  public $ModifiedBy;
  /**
   * @var long $EnterpriseID
   */
  public $EnterpriseID;
  /**
   * @var string $CustomerKey
   */
  public $CustomerKey;
}

class ExactTarget_APIProperty {
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var string $Value
   */
  public $Value;
}

class ExactTarget_NullAPIProperty {
}

class ExactTarget_DataFolder {
  /**
   * @var ExactTarget_DataFolder $ParentFolder
   */
  public $ParentFolder;
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var string $Description
   */
  public $Description;
  /**
   * @var string $ContentType
   */
  public $ContentType;
  /**
   * @var boolean $IsActive
   */
  public $IsActive;
  /**
   * @var boolean $IsEditable
   */
  public $IsEditable;
  /**
   * @var boolean $AllowChildren
   */
  public $AllowChildren;
}

class ExactTarget_Owner {
  /**
   * @var ExactTarget_ClientID $Client
   */
  public $Client;
  /**
   * @var string $FromName
   */
  public $FromName;
  /**
   * @var string $FromAddress
   */
  public $FromAddress;
  /**
   * @var ExactTarget_AccountUser $User
   */
  public $User;
}

class ExactTarget_AsyncResponseType {
  const None='None';
  const email='email';
  const FTP='FTP';
  const HTTPPost='HTTPPost';
}

class ExactTarget_AsyncResponse {
  /**
   * @var ExactTarget_AsyncResponseType $ResponseType
   */
  public $ResponseType;
  /**
   * @var string $ResponseAddress
   */
  public $ResponseAddress;
  /**
   * @var ExactTarget_RespondWhen $RespondWhen
   */
  public $RespondWhen;
  /**
   * @var boolean $IncludeResults
   */
  public $IncludeResults;
  /**
   * @var boolean $IncludeObjects
   */
  public $IncludeObjects;
  /**
   * @var boolean $OnlyIncludeBase
   */
  public $OnlyIncludeBase;
}

class ExactTarget_ContainerID {
  /**
   * @var ExactTarget_APIObject $APIObject
   */
  public $APIObject;
}

class ExactTarget_Request {
}

class ExactTarget_Result {
  /**
   * @var string $StatusCode
   */
  public $StatusCode;
  /**
   * @var string $StatusMessage
   */
  public $StatusMessage;
  /**
   * @var int $OrdinalID
   */
  public $OrdinalID;
  /**
   * @var int $ErrorCode
   */
  public $ErrorCode;
  /**
   * @var string $RequestID
   */
  public $RequestID;
  /**
   * @var string $ConversationID
   */
  public $ConversationID;
  /**
   * @var string $OverallStatusCode
   */
  public $OverallStatusCode;
  /**
   * @var ExactTarget_RequestType $RequestType
   */
  public $RequestType;
  /**
   * @var string $ResultType
   */
  public $ResultType;
  /**
   * @var string $ResultDetailXML
   */
  public $ResultDetailXML;
}

class ExactTarget_ResultMessage {
  /**
   * @var string $RequestID
   */
  public $RequestID;
  /**
   * @var string $ConversationID
   */
  public $ConversationID;
  /**
   * @var string $OverallStatusCode
   */
  public $OverallStatusCode;
  /**
   * @var string $StatusCode
   */
  public $StatusCode;
  /**
   * @var string $StatusMessage
   */
  public $StatusMessage;
  /**
   * @var int $ErrorCode
   */
  public $ErrorCode;
  /**
   * @var ExactTarget_RequestType $RequestType
   */
  public $RequestType;
  /**
   * @var string $ResultType
   */
  public $ResultType;
  /**
   * @var string $ResultDetailXML
   */
  public $ResultDetailXML;
  /**
   * @var int $SequenceCode
   */
  public $SequenceCode;
  /**
   * @var int $CallsInConversation
   */
  public $CallsInConversation;
}

class ExactTarget_ResultItem {
  /**
   * @var string $RequestID
   */
  public $RequestID;
  /**
   * @var string $ConversationID
   */
  public $ConversationID;
  /**
   * @var string $StatusCode
   */
  public $StatusCode;
  /**
   * @var string $StatusMessage
   */
  public $StatusMessage;
  /**
   * @var int $OrdinalID
   */
  public $OrdinalID;
  /**
   * @var int $ErrorCode
   */
  public $ErrorCode;
  /**
   * @var ExactTarget_RequestType $RequestType
   */
  public $RequestType;
  /**
   * @var string $RequestObjectType
   */
  public $RequestObjectType;
}

class ExactTarget_Priority {
  const Low='Low';
  const Medium='Medium';
  const High='High';
}

class ExactTarget_Options {
  /**
   * @var ExactTarget_ClientID $Client
   */
  public $Client;
  /**
   * @var ExactTarget_AsyncResponse $SendResponseTo
   */
  public $SendResponseTo;
  /**
   * @var ExactTarget_SaveOptions $SaveOptions
   */
  public $SaveOptions;
  /**
   * @var byte $Priority
   */
  public $Priority;
  /**
   * @var string $ConversationID
   */
  public $ConversationID;
  /**
   * @var int $SequenceCode
   */
  public $SequenceCode;
  /**
   * @var int $CallsInConversation
   */
  public $CallsInConversation;
  /**
   * @var dateTime $ScheduledTime
   */
  public $ScheduledTime;
  /**
   * @var ExactTarget_RequestType $RequestType
   */
  public $RequestType;
  /**
   * @var ExactTarget_Priority $QueuePriority
   */
  public $QueuePriority;
}

class ExactTarget_SaveOptions {
  /**
   * @var ExactTarget_SaveOption $SaveOption
   */
  public $SaveOption;
}

class ExactTarget_TaskResult {
  /**
   * @var string $StatusCode
   */
  public $StatusCode;
  /**
   * @var string $StatusMessage
   */
  public $StatusMessage;
  /**
   * @var int $OrdinalID
   */
  public $OrdinalID;
  /**
   * @var int $ErrorCode
   */
  public $ErrorCode;
  /**
   * @var string $ID
   */
  public $ID;
  /**
   * @var string $InteractionObjectID
   */
  public $InteractionObjectID;
}

class ExactTarget_RequestType {
  const Synchronous='Synchronous';
  const Asynchronous='Asynchronous';
}

class ExactTarget_RespondWhen {
  const Never='Never';
  const OnError='OnError';
  const Always='Always';
  const OnConversationError='OnConversationError';
  const OnConversationComplete='OnConversationComplete';
  const OnCallComplete='OnCallComplete';
}

class ExactTarget_SaveOption {
  /**
   * @var string $PropertyName
   */
  public $PropertyName;
  /**
   * @var ExactTarget_SaveAction $SaveAction
   */
  public $SaveAction;
}

class ExactTarget_SaveAction {
  const AddOnly='AddOnly';
  const _Default='Default';
  const Nothing='Nothing';
  const UpdateAdd='UpdateAdd';
  const UpdateOnly='UpdateOnly';
  const Delete='Delete';
}

class ExactTarget_CreateRequest {
  /**
   * @var ExactTarget_CreateOptions $Options
   */
  public $Options;
  /**
   * @var ExactTarget_APIObject $Objects
   */
  public $Objects;
}

class ExactTarget_CreateResult {
  /**
   * @var int $NewID
   */
  public $NewID;
  /**
   * @var string $NewObjectID
   */
  public $NewObjectID;
  /**
   * @var string $PartnerKey
   */
  public $PartnerKey;
  /**
   * @var ExactTarget_APIObject $Object
   */
  public $Object;
  /**
   * @var ExactTarget_CreateResult $CreateResults
   */
  public $CreateResults;
  /**
   * @var string $ParentPropertyName
   */
  public $ParentPropertyName;
}

class ExactTarget_CreateResponse {
  /**
   * @var ExactTarget_CreateResult $Results
   */
  public $Results;
  /**
   * @var string $RequestID
   */
  public $RequestID;
  /**
   * @var string $OverallStatus
   */
  public $OverallStatus;
}

class ExactTarget_CreateOptions {
  /**
   * @var ExactTarget_ContainerID $Container
   */
  public $Container;
}

class ExactTarget_UpdateOptions {
  /**
   * @var ExactTarget_ContainerID $Container
   */
  public $Container;
  /**
   * @var string $Action
   */
  public $Action;
}

class ExactTarget_UpdateRequest {
  /**
   * @var ExactTarget_UpdateOptions $Options
   */
  public $Options;
  /**
   * @var ExactTarget_APIObject $Objects
   */
  public $Objects;
}

class ExactTarget_UpdateResult {
  /**
   * @var ExactTarget_APIObject $Object
   */
  public $Object;
  /**
   * @var ExactTarget_UpdateResult $UpdateResults
   */
  public $UpdateResults;
  /**
   * @var string $ParentPropertyName
   */
  public $ParentPropertyName;
}

class ExactTarget_UpdateResponse {
  /**
   * @var ExactTarget_UpdateResult $Results
   */
  public $Results;
  /**
   * @var string $RequestID
   */
  public $RequestID;
  /**
   * @var string $OverallStatus
   */
  public $OverallStatus;
}

class ExactTarget_DeleteOptions {
}

class ExactTarget_DeleteRequest {
  /**
   * @var ExactTarget_DeleteOptions $Options
   */
  public $Options;
  /**
   * @var ExactTarget_APIObject $Objects
   */
  public $Objects;
}

class ExactTarget_DeleteResult {
  /**
   * @var ExactTarget_APIObject $Object
   */
  public $Object;
}

class ExactTarget_DeleteResponse {
  /**
   * @var ExactTarget_DeleteResult $Results
   */
  public $Results;
  /**
   * @var string $RequestID
   */
  public $RequestID;
  /**
   * @var string $OverallStatus
   */
  public $OverallStatus;
}

class ExactTarget_RetrieveRequest {
  /**
   * @var ExactTarget_ClientID $ClientIDs
   */
  public $ClientIDs;
  /**
   * @var string $ObjectType
   */
  public $ObjectType;
  /**
   * @var string $Properties
   */
  public $Properties;
  /**
   * @var ExactTarget_FilterPart $Filter
   */
  public $Filter;
  /**
   * @var ExactTarget_AsyncResponse $RespondTo
   */
  public $RespondTo;
  /**
   * @var ExactTarget_APIProperty $PartnerProperties
   */
  public $PartnerProperties;
  /**
   * @var string $ContinueRequest
   */
  public $ContinueRequest;
  /**
   * @var boolean $QueryAllAccounts
   */
  public $QueryAllAccounts;
  /**
   * @var boolean $RetrieveAllSinceLastBatch
   */
  public $RetrieveAllSinceLastBatch;
  /**
   * @var boolean $RepeatLastResult
   */
  public $RepeatLastResult;
  /**
   * @var ExactTarget_Retrieves $Retrieves
   */
  public $Retrieves;
  /**
   * @var ExactTarget_RetrieveOptions $Options
   */
  public $Options;
}

class ExactTarget_Retrieves {
  /**
   * @var ExactTarget_Request $Request
   */
  public $Request;
}

class ExactTarget_RetrieveRequestMsg {
  /**
   * @var ExactTarget_RetrieveRequest $RetrieveRequest
   */
  public $RetrieveRequest;
}

class ExactTarget_RetrieveResponseMsg {
  /**
   * @var string $OverallStatus
   */
  public $OverallStatus;
  /**
   * @var string $RequestID
   */
  public $RequestID;
  /**
   * @var ExactTarget_APIObject $Results
   */
  public $Results;
}

class ExactTarget_RetrieveSingleRequest {
  /**
   * @var ExactTarget_APIObject $RequestedObject
   */
  public $RequestedObject;
  /**
   * @var ExactTarget_Options $RetrieveOption
   */
  public $RetrieveOption;
}



class ExactTarget_RetrieveSingleOptions {
  /**
   * @var ExactTarget_Parameters $Parameters
   */
  public $Parameters;
}

class ExactTarget_RetrieveOptions {
  /**
   * @var int $BatchSize
   */
  public $BatchSize;
  /**
   * @var boolean $IncludeObjects
   */
  public $IncludeObjects;
  /**
   * @var boolean $OnlyIncludeBase
   */
  public $OnlyIncludeBase;
}

class ExactTarget_QueryRequest {
  /**
   * @var ExactTarget_ClientID $ClientIDs
   */
  public $ClientIDs;
  /**
   * @var ExactTarget_Query $Query
   */
  public $Query;
  /**
   * @var ExactTarget_AsyncResponse $RespondTo
   */
  public $RespondTo;
  /**
   * @var ExactTarget_APIProperty $PartnerProperties
   */
  public $PartnerProperties;
  /**
   * @var string $ContinueRequest
   */
  public $ContinueRequest;
  /**
   * @var boolean $QueryAllAccounts
   */
  public $QueryAllAccounts;
  /**
   * @var boolean $RetrieveAllSinceLastBatch
   */
  public $RetrieveAllSinceLastBatch;
}

class ExactTarget_QueryRequestMsg {
  /**
   * @var ExactTarget_QueryRequest $QueryRequest
   */
  public $QueryRequest;
}

class ExactTarget_QueryResponseMsg {
  /**
   * @var string $OverallStatus
   */
  public $OverallStatus;
  /**
   * @var string $RequestID
   */
  public $RequestID;
  /**
   * @var ExactTarget_APIObject $Results
   */
  public $Results;
}

class ExactTarget_QueryObject {
  /**
   * @var string $ObjectType
   */
  public $ObjectType;
  /**
   * @var string $Properties
   */
  public $Properties;
  /**
   * @var ExactTarget_QueryObject $Objects
   */
  public $Objects;
}

class ExactTarget_Query {
  /**
   * @var ExactTarget_QueryObject $Object
   */
  public $Object;
  /**
   * @var ExactTarget_FilterPart $Filter
   */
  public $Filter;
}

class ExactTarget_FilterPart {
}

class ExactTarget_SimpleFilterPart {
  /**
   * @var string $Property
   */
  public $Property;
  /**
   * @var ExactTarget_SimpleOperators $SimpleOperator
   */
  public $SimpleOperator;
  /**
   * @var string $Value
   */
  public $Value;
  /**
   * @var dateTime $DateValue
   */
  public $DateValue;
}

class ExactTarget_TagFilterPart {
  /**
   * @var ExactTarget_Tags $Tags
   */
  public $Tags;
}

class ExactTarget_Tags {
  /**
   * @var string $Tag
   */
  public $Tag;
}

class ExactTarget_ComplexFilterPart {
  /**
   * @var ExactTarget_FilterPart $LeftOperand
   */
  public $LeftOperand;
  /**
   * @var ExactTarget_LogicalOperators $LogicalOperator
   */
  public $LogicalOperator;
  /**
   * @var ExactTarget_FilterPart $RightOperand
   */
  public $RightOperand;
  /**
   * @var ExactTarget_AdditionalOperands $AdditionalOperands
   */
  public $AdditionalOperands;
}

class ExactTarget_AdditionalOperands {
  /**
   * @var ExactTarget_FilterPart $Operand
   */
  public $Operand;
}

class ExactTarget_SimpleOperators {
  const equals='equals';
  const notEquals='notEquals';
  const greaterThan='greaterThan';
  const lessThan='lessThan';
  const isNull='isNull';
  const isNotNull='isNotNull';
  const greaterThanOrEqual='greaterThanOrEqual';
  const lessThanOrEqual='lessThanOrEqual';
  const between='between';
  const IN='IN';
  const like='like';
  const existsInString='existsInString';
  const existsInStringAsAWord='existsInStringAsAWord';
  const notExistsInString='notExistsInString';
  const beginsWith='beginsWith';
  const endsWith='endsWith';
  const contains='contains';
  const notContains='notContains';
  const isAnniversary='isAnniversary';
  const isNotAnniversary='isNotAnniversary';
  const greaterThanAnniversary='greaterThanAnniversary';
  const lessThanAnniversary='lessThanAnniversary';
}

class ExactTarget_LogicalOperators {
  const _OR='OR';
  const _AND='AND';
}

class ExactTarget_DefinitionRequestMsg {
  /**
   * @var ExactTarget_ArrayOfObjectDefinitionRequest $DescribeRequests
   */
  public $DescribeRequests;
}

class ExactTarget_ArrayOfObjectDefinitionRequest {
  /**
   * @var ExactTarget_ObjectDefinitionRequest $ObjectDefinitionRequest
   */
  public $ObjectDefinitionRequest;
}

class ExactTarget_ObjectDefinitionRequest {
  /**
   * @var ExactTarget_ClientID $Client
   */
  public $Client;
  /**
   * @var string $ObjectType
   */
  public $ObjectType;
}

class ExactTarget_DefinitionResponseMsg {
  /**
   * @var ExactTarget_ObjectDefinition $ObjectDefinition
   */
  public $ObjectDefinition;
  /**
   * @var string $RequestID
   */
  public $RequestID;
}

class ExactTarget_PropertyDefinition {
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var string $DataType
   */
  public $DataType;
  /**
   * @var ExactTarget_SoapType $ValueType
   */
  public $ValueType;
  /**
   * @var ExactTarget_PropertyType $PropertyType
   */
  public $PropertyType;
  /**
   * @var boolean $IsCreatable
   */
  public $IsCreatable;
  /**
   * @var boolean $IsUpdatable
   */
  public $IsUpdatable;
  /**
   * @var boolean $IsRetrievable
   */
  public $IsRetrievable;
  /**
   * @var boolean $IsQueryable
   */
  public $IsQueryable;
  /**
   * @var boolean $IsFilterable
   */
  public $IsFilterable;
  /**
   * @var boolean $IsPartnerProperty
   */
  public $IsPartnerProperty;
  /**
   * @var boolean $IsAccountProperty
   */
  public $IsAccountProperty;
  /**
   * @var string $PartnerMap
   */
  public $PartnerMap;
  /**
   * @var ExactTarget_AttributeMap $AttributeMaps
   */
  public $AttributeMaps;
  /**
   * @var ExactTarget_APIProperty $Markups
   */
  public $Markups;
  /**
   * @var int $Precision
   */
  public $Precision;
  /**
   * @var int $Scale
   */
  public $Scale;
  /**
   * @var string $Label
   */
  public $Label;
  /**
   * @var string $Description
   */
  public $Description;
  /**
   * @var string $DefaultValue
   */
  public $DefaultValue;
  /**
   * @var int $MinLength
   */
  public $MinLength;
  /**
   * @var int $MaxLength
   */
  public $MaxLength;
  /**
   * @var string $MinValue
   */
  public $MinValue;
  /**
   * @var string $MaxValue
   */
  public $MaxValue;
  /**
   * @var boolean $IsRequired
   */
  public $IsRequired;
  /**
   * @var boolean $IsViewable
   */
  public $IsViewable;
  /**
   * @var boolean $IsEditable
   */
  public $IsEditable;
  /**
   * @var boolean $IsNillable
   */
  public $IsNillable;
  /**
   * @var boolean $IsRestrictedPicklist
   */
  public $IsRestrictedPicklist;
  /**
   * @var ExactTarget_PicklistItems $PicklistItems
   */
  public $PicklistItems;
  /**
   * @var boolean $IsSendTime
   */
  public $IsSendTime;
  /**
   * @var int $DisplayOrder
   */
  public $DisplayOrder;
  /**
   * @var ExactTarget_References $References
   */
  public $References;
  /**
   * @var string $RelationshipName
   */
  public $RelationshipName;
  /**
   * @var string $Status
   */
  public $Status;
  /**
   * @var boolean $IsContextSpecific
   */
  public $IsContextSpecific;
}

class ExactTarget_PicklistItems {
  /**
   * @var ExactTarget_PicklistItem $PicklistItem
   */
  public $PicklistItem;
}

class ExactTarget_References {
  /**
   * @var ExactTarget_APIObject $Reference
   */
  public $Reference;
}

class ExactTarget_ObjectDefinition {
  /**
   * @var string $ObjectType
   */
  public $ObjectType;
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var boolean $IsCreatable
   */
  public $IsCreatable;
  /**
   * @var boolean $IsUpdatable
   */
  public $IsUpdatable;
  /**
   * @var boolean $IsRetrievable
   */
  public $IsRetrievable;
  /**
   * @var boolean $IsQueryable
   */
  public $IsQueryable;
  /**
   * @var boolean $IsReference
   */
  public $IsReference;
  /**
   * @var string $ReferencedType
   */
  public $ReferencedType;
  /**
   * @var string $IsPropertyCollection
   */
  public $IsPropertyCollection;
  /**
   * @var boolean $IsObjectCollection
   */
  public $IsObjectCollection;
  /**
   * @var ExactTarget_PropertyDefinition $Properties
   */
  public $Properties;
  /**
   * @var ExactTarget_ExtendedProperties $ExtendedProperties
   */
  public $ExtendedProperties;
  /**
   * @var ExactTarget_ObjectDefinition $ChildObjects
   */
  public $ChildObjects;
}

class ExactTarget_ExtendedProperties {
  /**
   * @var ExactTarget_PropertyDefinition $ExtendedProperty
   */
  public $ExtendedProperty;
}

class ExactTarget_AttributeMap {
  /**
   * @var string $EntityName
   */
  public $EntityName;
  /**
   * @var string $ColumnName
   */
  public $ColumnName;
  /**
   * @var string $ColumnNameMappedTo
   */
  public $ColumnNameMappedTo;
  /**
   * @var string $EntityNameMappedTo
   */
  public $EntityNameMappedTo;
  /**
   * @var ExactTarget_APIProperty $AdditionalData
   */
  public $AdditionalData;
}

class ExactTarget_PicklistItem {
  /**
   * @var boolean $IsDefaultValue
   */
  public $IsDefaultValue;
  /**
   * @var string $Label
   */
  public $Label;
  /**
   * @var string $Value
   */
  public $Value;
}

class ExactTarget_SoapType {
  const string='string';
  const boolean='boolean';
  const double='double';
  const dateTime='dateTime';
}

class ExactTarget_PropertyType {
  const string='string';
  const boolean='boolean';
  const double='double';
  const datetime='datetime';
}

class ExactTarget_ExecuteRequest {
  /**
   * @var ExactTarget_ClientID $Client
   */
  public $Client;
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var ExactTarget_APIProperty $Parameters
   */
  public $Parameters;
}

class ExactTarget_ExecuteResponse {
  /**
   * @var string $StatusCode
   */
  public $StatusCode;
  /**
   * @var string $StatusMessage
   */
  public $StatusMessage;
  /**
   * @var int $OrdinalID
   */
  public $OrdinalID;
  /**
   * @var ExactTarget_APIProperty $Results
   */
  public $Results;
  /**
   * @var int $ErrorCode
   */
  public $ErrorCode;
}

class ExactTarget_ExecuteRequestMsg {
  /**
   * @var ExactTarget_ExecuteRequest $Requests
   */
  public $Requests;
}

class ExactTarget_ExecuteResponseMsg {
  /**
   * @var string $OverallStatus
   */
  public $OverallStatus;
  /**
   * @var string $RequestID
   */
  public $RequestID;
  /**
   * @var ExactTarget_ExecuteResponse $Results
   */
  public $Results;
}

class ExactTarget_InteractionDefinition {
  /**
   * @var string $InteractionObjectID
   */
  public $InteractionObjectID;
}

class ExactTarget_InteractionBaseObject {
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var string $Description
   */
  public $Description;
  /**
   * @var string $Keyword
   */
  public $Keyword;
}

class ExactTarget_PerformOptions {
  /**
   * @var string $Explanation
   */
  public $Explanation;
}

class ExactTarget_CampaignPerformOptions {
  /**
   * @var string $OccurrenceIDs
   */
  public $OccurrenceIDs;
  /**
   * @var int $OccurrenceIDsIndex
   */
  public $OccurrenceIDsIndex;
}

class ExactTarget_PerformRequest {
  /**
   * @var ExactTarget_ClientID $Client
   */
  public $Client;
  /**
   * @var string $Action
   */
  public $Action;
  /**
   * @var ExactTarget_Definitions $Definitions
   */
  public $Definitions;
}

class ExactTarget_Definitions {
  /**
   * @var ExactTarget_InteractionBaseObject $Definition
   */
  public $Definition;
}

class ExactTarget_PerformResponse {
  /**
   * @var string $StatusCode
   */
  public $StatusCode;
  /**
   * @var string $StatusMessage
   */
  public $StatusMessage;
  /**
   * @var int $OrdinalID
   */
  public $OrdinalID;
  /**
   * @var ExactTarget_Results $Results
   */
  public $Results;
  /**
   * @var int $ErrorCode
   */
  public $ErrorCode;
}

class ExactTarget_Results {
  /**
   * @var ExactTarget_APIProperty $Result
   */
  public $Result;
}

class ExactTarget_PerformResult {
  /**
   * @var ExactTarget_APIObject $Object
   */
  public $Object;
  /**
   * @var ExactTarget_TaskResult $Task
   */
  public $Task;
}

class ExactTarget_PerformRequestMsg {
  /**
   * @var ExactTarget_PerformOptions $Options
   */
  public $Options;
  /**
   * @var string $Action
   */
  public $Action;
  /**
   * @var ExactTarget_Definitions $Definitions
   */
  public $Definitions;
}


class ExactTarget_PerformResponseMsg {
  /**
   * @var ExactTarget_Results $Results
   */
  public $Results;
  /**
   * @var string $OverallStatus
   */
  public $OverallStatus;
  /**
   * @var string $OverallStatusMessage
   */
  public $OverallStatusMessage;
  /**
   * @var string $RequestID
   */
  public $RequestID;
}



class ExactTarget_ValidationAction {
  /**
   * @var string $ValidationType
   */
  public $ValidationType;
  /**
   * @var ExactTarget_ValidationOptions $ValidationOptions
   */
  public $ValidationOptions;
}

class ExactTarget_ValidationOptions {
  /**
   * @var ExactTarget_APIProperty $ValidationOption
   */
  public $ValidationOption;
}

class ExactTarget_SpamAssassinValidation {
}

class ExactTarget_ContentValidation {
  /**
   * @var ExactTarget_ValidationAction $ValidationAction
   */
  public $ValidationAction;
  /**
   * @var ExactTarget_Email $Email
   */
  public $Email;
  /**
   * @var ExactTarget_Subscribers $Subscribers
   */
  public $Subscribers;
}

class ExactTarget_Subscribers {
  /**
   * @var ExactTarget_Subscriber $Subscriber
   */
  public $Subscriber;
}

class ExactTarget_ContentValidationResult {
}

class ExactTarget_ValidationResult {
  /**
   * @var ExactTarget_Subscriber $Subscriber
   */
  public $Subscriber;
  /**
   * @var dateTime $CheckTime
   */
  public $CheckTime;
  /**
   * @var dateTime $CheckTimeUTC
   */
  public $CheckTimeUTC;
  /**
   * @var boolean $IsResultValid
   */
  public $IsResultValid;
  /**
   * @var boolean $IsSpam
   */
  public $IsSpam;
  /**
   * @var double $Score
   */
  public $Score;
  /**
   * @var double $Threshold
   */
  public $Threshold;
  /**
   * @var string $Message
   */
  public $Message;
}

class ExactTarget_ContentValidationTaskResult {
  /**
   * @var ExactTarget_ValidationResults $ValidationResults
   */
  public $ValidationResults;
}

class ExactTarget_ValidationResults {
  /**
   * @var ExactTarget_ValidationResult $ValidationResult
   */
  public $ValidationResult;
}

class ExactTarget_ConfigureOptions {
}

class ExactTarget_ConfigureResult {
  /**
   * @var ExactTarget_APIObject $Object
   */
  public $Object;
}

class ExactTarget_ConfigureRequestMsg {
  /**
   * @var ExactTarget_ConfigureOptions $Options
   */
  public $Options;
  /**
   * @var string $Action
   */
  public $Action;
  /**
   * @var ExactTarget_Configurations $Configurations
   */
  public $Configurations;
}

class ExactTarget_Configurations {
  /**
   * @var ExactTarget_APIObject $Configuration
   */
  public $Configuration;
}

class ExactTarget_ConfigureResponseMsg {
  /**
   * @var ExactTarget_Results $Results
   */
  public $Results;
  /**
   * @var string $OverallStatus
   */
  public $OverallStatus;
  /**
   * @var string $OverallStatusMessage
   */
  public $OverallStatusMessage;
  /**
   * @var string $RequestID
   */
  public $RequestID;
}



class ExactTarget_ScheduleDefinition {
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var string $Description
   */
  public $Description;
  /**
   * @var ExactTarget_Recurrence $Recurrence
   */
  public $Recurrence;
  /**
   * @var ExactTarget_RecurrenceTypeEnum $RecurrenceType
   */
  public $RecurrenceType;
  /**
   * @var ExactTarget_RecurrenceRangeTypeEnum $RecurrenceRangeType
   */
  public $RecurrenceRangeType;
  /**
   * @var dateTime $StartDateTime
   */
  public $StartDateTime;
  /**
   * @var dateTime $EndDateTime
   */
  public $EndDateTime;
  /**
   * @var int $Occurrences
   */
  public $Occurrences;
  /**
   * @var string $Keyword
   */
  public $Keyword;
  /**
   * @var ExactTarget_TimeZone $TimeZone
   */
  public $TimeZone;
}

class ExactTarget_ScheduleOptions {
}

class ExactTarget_ScheduleResponse {
  /**
   * @var string $StatusCode
   */
  public $StatusCode;
  /**
   * @var string $StatusMessage
   */
  public $StatusMessage;
  /**
   * @var int $OrdinalID
   */
  public $OrdinalID;
  /**
   * @var ExactTarget_Results $Results
   */
  public $Results;
  /**
   * @var int $ErrorCode
   */
  public $ErrorCode;
}


class ExactTarget_ScheduleResult {
  /**
   * @var ExactTarget_ScheduleDefinition $Object
   */
  public $Object;
  /**
   * @var ExactTarget_TaskResult $Task
   */
  public $Task;
}

class ExactTarget_ScheduleRequestMsg {
  /**
   * @var ExactTarget_ScheduleOptions $Options
   */
  public $Options;
  /**
   * @var string $Action
   */
  public $Action;
  /**
   * @var ExactTarget_ScheduleDefinition $Schedule
   */
  public $Schedule;
  /**
   * @var ExactTarget_Interactions $Interactions
   */
  public $Interactions;
}

class ExactTarget_Interactions {
  /**
   * @var ExactTarget_APIObject $Interaction
   */
  public $Interaction;
}

class ExactTarget_ScheduleResponseMsg {
  /**
   * @var ExactTarget_Results $Results
   */
  public $Results;
  /**
   * @var string $OverallStatus
   */
  public $OverallStatus;
  /**
   * @var string $OverallStatusMessage
   */
  public $OverallStatusMessage;
  /**
   * @var string $RequestID
   */
  public $RequestID;
}


class ExactTarget_RecurrenceTypeEnum {
  const Secondly='Secondly';
  const Minutely='Minutely';
  const Hourly='Hourly';
  const Daily='Daily';
  const Weekly='Weekly';
  const Monthly='Monthly';
  const Yearly='Yearly';
}

class ExactTarget_RecurrenceRangeTypeEnum {
  const EndAfter='EndAfter';
  const EndOn='EndOn';
}

class ExactTarget_Recurrence {
}

class ExactTarget_MinutelyRecurrencePatternTypeEnum {
  const Interval='Interval';
}

class ExactTarget_HourlyRecurrencePatternTypeEnum {
  const Interval='Interval';
}

class ExactTarget_DailyRecurrencePatternTypeEnum {
  const Interval='Interval';
  const EveryWeekDay='EveryWeekDay';
}

class ExactTarget_WeeklyRecurrencePatternTypeEnum {
  const ByDay='ByDay';
}

class ExactTarget_MonthlyRecurrencePatternTypeEnum {
  const ByDay='ByDay';
  const ByWeek='ByWeek';
}

class ExactTarget_WeekOfMonthEnum {
  const first='first';
  const second='second';
  const third='third';
  const fourth='fourth';
  const last='last';
}

class ExactTarget_DayOfWeekEnum {
  const Sunday='Sunday';
  const Monday='Monday';
  const Tuesday='Tuesday';
  const Wednesday='Wednesday';
  const Thursday='Thursday';
  const Friday='Friday';
  const Saturday='Saturday';
}

class ExactTarget_YearlyRecurrencePatternTypeEnum {
  const ByDay='ByDay';
  const ByWeek='ByWeek';
  const ByMonth='ByMonth';
}

class ExactTarget_MonthOfYearEnum {
  const January='January';
  const February='February';
  const March='March';
  const April='April';
  const May='May';
  const June='June';
  const July='July';
  const August='August';
  const September='September';
  const October='October';
  const November='November';
  const December='December';
}

class ExactTarget_MinutelyRecurrence {
  /**
   * @var ExactTarget_MinutelyRecurrencePatternTypeEnum $MinutelyRecurrencePatternType
   */
  public $MinutelyRecurrencePatternType;
  /**
   * @var int $MinuteInterval
   */
  public $MinuteInterval;
}

class ExactTarget_HourlyRecurrence {
  /**
   * @var ExactTarget_HourlyRecurrencePatternTypeEnum $HourlyRecurrencePatternType
   */
  public $HourlyRecurrencePatternType;
  /**
   * @var int $HourInterval
   */
  public $HourInterval;
}

class ExactTarget_DailyRecurrence {
  /**
   * @var ExactTarget_DailyRecurrencePatternTypeEnum $DailyRecurrencePatternType
   */
  public $DailyRecurrencePatternType;
  /**
   * @var int $DayInterval
   */
  public $DayInterval;
}

class ExactTarget_WeeklyRecurrence {
  /**
   * @var ExactTarget_WeeklyRecurrencePatternTypeEnum $WeeklyRecurrencePatternType
   */
  public $WeeklyRecurrencePatternType;
  /**
   * @var int $WeekInterval
   */
  public $WeekInterval;
  /**
   * @var boolean $Sunday
   */
  public $Sunday;
  /**
   * @var boolean $Monday
   */
  public $Monday;
  /**
   * @var boolean $Tuesday
   */
  public $Tuesday;
  /**
   * @var boolean $Wednesday
   */
  public $Wednesday;
  /**
   * @var boolean $Thursday
   */
  public $Thursday;
  /**
   * @var boolean $Friday
   */
  public $Friday;
  /**
   * @var boolean $Saturday
   */
  public $Saturday;
}

class ExactTarget_MonthlyRecurrence {
  /**
   * @var ExactTarget_MonthlyRecurrencePatternTypeEnum $MonthlyRecurrencePatternType
   */
  public $MonthlyRecurrencePatternType;
  /**
   * @var int $MonthlyInterval
   */
  public $MonthlyInterval;
  /**
   * @var int $ScheduledDay
   */
  public $ScheduledDay;
  /**
   * @var ExactTarget_WeekOfMonthEnum $ScheduledWeek
   */
  public $ScheduledWeek;
  /**
   * @var ExactTarget_DayOfWeekEnum $ScheduledDayOfWeek
   */
  public $ScheduledDayOfWeek;
}

class ExactTarget_YearlyRecurrence {
  /**
   * @var ExactTarget_YearlyRecurrencePatternTypeEnum $YearlyRecurrencePatternType
   */
  public $YearlyRecurrencePatternType;
  /**
   * @var int $ScheduledDay
   */
  public $ScheduledDay;
  /**
   * @var ExactTarget_WeekOfMonthEnum $ScheduledWeek
   */
  public $ScheduledWeek;
  /**
   * @var ExactTarget_MonthOfYearEnum $ScheduledMonth
   */
  public $ScheduledMonth;
  /**
   * @var ExactTarget_DayOfWeekEnum $ScheduledDayOfWeek
   */
  public $ScheduledDayOfWeek;
}

class ExactTarget_ExtractRequest {
  /**
   * @var ExactTarget_ClientID $Client
   */
  public $Client;
  /**
   * @var string $ID
   */
  public $ID;
  /**
   * @var ExactTarget_ExtractOptions $Options
   */
  public $Options;
  /**
   * @var ExactTarget_Parameters $Parameters
   */
  public $Parameters;
  /**
   * @var ExactTarget_ExtractDescription $Description
   */
  public $Description;
  /**
   * @var ExactTarget_ExtractDefinition $Definition
   */
  public $Definition;
}



class ExactTarget_ExtractResult {
  /**
   * @var ExactTarget_ExtractRequest $Request
   */
  public $Request;
}

class ExactTarget_ExtractRequestMsg {
  /**
   * @var ExactTarget_ExtractRequest $Requests
   */
  public $Requests;
}

class ExactTarget_ExtractResponseMsg {
  /**
   * @var string $OverallStatus
   */
  public $OverallStatus;
  /**
   * @var string $RequestID
   */
  public $RequestID;
  /**
   * @var ExactTarget_ExtractResult $Results
   */
  public $Results;
}

class ExactTarget_ExtractOptions {
}

class ExactTarget_ExtractParameter {
}

class ExactTarget_ExtractTemplate {
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var string $ConfigurationPage
   */
  public $ConfigurationPage;
  /**
   * @var string $PackageKey
   */
  public $PackageKey;
}

class ExactTarget_ExtractDescription {
  /**
   * @var ExactTarget_Parameters $Parameters
   */
  public $Parameters;
}



class ExactTarget_ExtractDefinition {
  /**
   * @var ExactTarget_Parameters $Parameters
   */
  public $Parameters;
  /**
   * @var ExactTarget_Values $Values
   */
  public $Values;
}


class ExactTarget_Values {
  /**
   * @var ExactTarget_APIProperty $Value
   */
  public $Value;
}

class ExactTarget_ExtractParameterDataType {
  const datetime='datetime';
  const bool='bool';
  const string='string';
  const integer='integer';
  const dropdown='dropdown';
}

class ExactTarget_ParameterDescription {
}

class ExactTarget_ExtractParameterDescription {
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var ExactTarget_ExtractParameterDataType $DataType
   */
  public $DataType;
  /**
   * @var string $DefaultValue
   */
  public $DefaultValue;
  /**
   * @var boolean $IsOptional
   */
  public $IsOptional;
  /**
   * @var string $DropDownList
   */
  public $DropDownList;
}

class ExactTarget_VersionInfoResponse {
  /**
   * @var string $Version
   */
  public $Version;
  /**
   * @var dateTime $VersionDate
   */
  public $VersionDate;
  /**
   * @var string $Notes
   */
  public $Notes;
  /**
   * @var ExactTarget_VersionInfoResponse $VersionHistory
   */
  public $VersionHistory;
}

class ExactTarget_VersionInfoRequestMsg {
  /**
   * @var boolean $IncludeVersionHistory
   */
  public $IncludeVersionHistory;
}

class ExactTarget_VersionInfoResponseMsg {
  /**
   * @var ExactTarget_VersionInfoResponse $VersionInfo
   */
  public $VersionInfo;
  /**
   * @var string $RequestID
   */
  public $RequestID;
}

class ExactTarget_Locale {
  /**
   * @var string $LocaleCode
   */
  public $LocaleCode;
}

class ExactTarget_TimeZone {
  /**
   * @var string $Name
   */
  public $Name;
}

class ExactTarget_Account {
  /**
   * @var ExactTarget_AccountTypeEnum $AccountType
   */
  public $AccountType;
  /**
   * @var int $ParentID
   */
  public $ParentID;
  /**
   * @var int $BrandID
   */
  public $BrandID;
  /**
   * @var int $PrivateLabelID
   */
  public $PrivateLabelID;
  /**
   * @var int $ReportingParentID
   */
  public $ReportingParentID;
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var string $Email
   */
  public $Email;
  /**
   * @var string $FromName
   */
  public $FromName;
  /**
   * @var string $BusinessName
   */
  public $BusinessName;
  /**
   * @var string $Phone
   */
  public $Phone;
  /**
   * @var string $Address
   */
  public $Address;
  /**
   * @var string $Fax
   */
  public $Fax;
  /**
   * @var string $City
   */
  public $City;
  /**
   * @var string $State
   */
  public $State;
  /**
   * @var string $Zip
   */
  public $Zip;
  /**
   * @var string $Country
   */
  public $Country;
  /**
   * @var int $IsActive
   */
  public $IsActive;
  /**
   * @var boolean $IsTestAccount
   */
  public $IsTestAccount;
  /**
   * @var int $OrgID
   */
  public $OrgID;
  /**
   * @var int $DBID
   */
  public $DBID;
  /**
   * @var string $ParentName
   */
  public $ParentName;
  /**
   * @var long $CustomerID
   */
  public $CustomerID;
  /**
   * @var dateTime $DeletedDate
   */
  public $DeletedDate;
  /**
   * @var int $EditionID
   */
  public $EditionID;
  /**
   * @var ExactTarget_AccountDataItem $Children
   */
  public $Children;
  /**
   * @var ExactTarget_Subscription $Subscription
   */
  public $Subscription;
  /**
   * @var ExactTarget_PrivateLabel $PrivateLabels
   */
  public $PrivateLabels;
  /**
   * @var ExactTarget_BusinessRule $BusinessRules
   */
  public $BusinessRules;
  /**
   * @var ExactTarget_AccountUser $AccountUsers
   */
  public $AccountUsers;
  /**
   * @var boolean $InheritAddress
   */
  public $InheritAddress;
  /**
   * @var boolean $IsTrialAccount
   */
  public $IsTrialAccount;
  /**
   * @var ExactTarget_Locale $Locale
   */
  public $Locale;
  /**
   * @var ExactTarget_Account $ParentAccount
   */
  public $ParentAccount;
  /**
   * @var ExactTarget_TimeZone $TimeZone
   */
  public $TimeZone;
  /**
   * @var ExactTarget_Roles $Roles
   */
  public $Roles;
  /**
   * @var ExactTarget_Locale $LanguageLocale
   */
  public $LanguageLocale;
}

class ExactTarget_Roles {
  /**
   * @var ExactTarget_Role $Role
   */
  public $Role;
}

class ExactTarget_BusinessUnit {
  /**
   * @var string $Description
   */
  public $Description;
  /**
   * @var ExactTarget_SendClassification $DefaultSendClassification
   */
  public $DefaultSendClassification;
  /**
   * @var ExactTarget_LandingPage $DefaultHomePage
   */
  public $DefaultHomePage;
  /**
   * @var ExactTarget_FilterPart $SubscriberFilter
   */
  public $SubscriberFilter;
  /**
   * @var ExactTarget_UnsubscribeBehaviorEnum $MasterUnsubscribeBehavior
   */
  public $MasterUnsubscribeBehavior;
}

class ExactTarget_UnsubscribeBehaviorEnum {
  const ENTIRE_ENTERPRISE='ENTIRE_ENTERPRISE';
  const BUSINESS_UNIT_ONLY='BUSINESS_UNIT_ONLY';
}

class ExactTarget_LandingPage {
}

class ExactTarget_AccountTypeEnum {
  const None='None';
  const EXACTTARGET='EXACTTARGET';
  const PRO_CONNECT='PRO_CONNECT';
  const CHANNEL_CONNECT='CHANNEL_CONNECT';
  const CONNECT='CONNECT';
  const PRO_CONNECT_CLIENT='PRO_CONNECT_CLIENT';
  const LP_MEMBER='LP_MEMBER';
  const DOTO_MEMBER='DOTO_MEMBER';
  const ENTERPRISE_2='ENTERPRISE_2';
  const BUSINESS_UNIT='BUSINESS_UNIT';
}

class ExactTarget_AccountDataItem {
  /**
   * @var int $ChildAccountID
   */
  public $ChildAccountID;
  /**
   * @var int $BrandID
   */
  public $BrandID;
  /**
   * @var int $PrivateLabelID
   */
  public $PrivateLabelID;
  /**
   * @var int $AccountType
   */
  public $AccountType;
}

class ExactTarget_Subscription {
  /**
   * @var int $SubscriptionID
   */
  public $SubscriptionID;
  /**
   * @var int $EmailsPurchased
   */
  public $EmailsPurchased;
  /**
   * @var int $AccountsPurchased
   */
  public $AccountsPurchased;
  /**
   * @var int $AdvAccountsPurchased
   */
  public $AdvAccountsPurchased;
  /**
   * @var int $LPAccountsPurchased
   */
  public $LPAccountsPurchased;
  /**
   * @var int $DOTOAccountsPurchased
   */
  public $DOTOAccountsPurchased;
  /**
   * @var int $BUAccountsPurchased
   */
  public $BUAccountsPurchased;
  /**
   * @var dateTime $BeginDate
   */
  public $BeginDate;
  /**
   * @var dateTime $EndDate
   */
  public $EndDate;
  /**
   * @var string $Notes
   */
  public $Notes;
  /**
   * @var string $Period
   */
  public $Period;
  /**
   * @var string $NotificationTitle
   */
  public $NotificationTitle;
  /**
   * @var string $NotificationMessage
   */
  public $NotificationMessage;
  /**
   * @var string $NotificationFlag
   */
  public $NotificationFlag;
  /**
   * @var dateTime $NotificationExpDate
   */
  public $NotificationExpDate;
  /**
   * @var string $ForAccounting
   */
  public $ForAccounting;
  /**
   * @var boolean $HasPurchasedEmails
   */
  public $HasPurchasedEmails;
  /**
   * @var string $ContractNumber
   */
  public $ContractNumber;
  /**
   * @var string $ContractModifier
   */
  public $ContractModifier;
  /**
   * @var boolean $IsRenewal
   */
  public $IsRenewal;
  /**
   * @var long $NumberofEmails
   */
  public $NumberofEmails;
}

class ExactTarget_PrivateLabel {
  /**
   * @var int $ID
   */
  public $ID;
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var string $ColorPaletteXML
   */
  public $ColorPaletteXML;
  /**
   * @var string $LogoFile
   */
  public $LogoFile;
  /**
   * @var int $Delete
   */
  public $Delete;
  /**
   * @var boolean $SetActive
   */
  public $SetActive;
}

class ExactTarget_AccountPrivateLabel {
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var int $OwnerMemberID
   */
  public $OwnerMemberID;
  /**
   * @var string $ColorPaletteXML
   */
  public $ColorPaletteXML;
}

class ExactTarget_BusinessRule {
  /**
   * @var int $MemberBusinessRuleID
   */
  public $MemberBusinessRuleID;
  /**
   * @var int $BusinessRuleID
   */
  public $BusinessRuleID;
  /**
   * @var int $Data
   */
  public $Data;
  /**
   * @var string $Quality
   */
  public $Quality;
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var string $Type
   */
  public $Type;
  /**
   * @var string $Description
   */
  public $Description;
  /**
   * @var boolean $IsViewable
   */
  public $IsViewable;
  /**
   * @var boolean $IsInheritedFromParent
   */
  public $IsInheritedFromParent;
  /**
   * @var string $DisplayName
   */
  public $DisplayName;
  /**
   * @var string $ProductCode
   */
  public $ProductCode;
}

class ExactTarget_AccountUser {
  /**
   * @var int $AccountUserID
   */
  public $AccountUserID;
  /**
   * @var string $UserID
   */
  public $UserID;
  /**
   * @var string $Password
   */
  public $Password;
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var string $Email
   */
  public $Email;
  /**
   * @var boolean $MustChangePassword
   */
  public $MustChangePassword;
  /**
   * @var boolean $ActiveFlag
   */
  public $ActiveFlag;
  /**
   * @var string $ChallengePhrase
   */
  public $ChallengePhrase;
  /**
   * @var string $ChallengeAnswer
   */
  public $ChallengeAnswer;
  /**
   * @var ExactTarget_UserAccess $UserPermissions
   */
  public $UserPermissions;
  /**
   * @var int $Delete
   */
  public $Delete;
  /**
   * @var dateTime $LastSuccessfulLogin
   */
  public $LastSuccessfulLogin;
  /**
   * @var boolean $IsAPIUser
   */
  public $IsAPIUser;
  /**
   * @var string $NotificationEmailAddress
   */
  public $NotificationEmailAddress;
  /**
   * @var boolean $IsLocked
   */
  public $IsLocked;
  /**
   * @var boolean $Unlock
   */
  public $Unlock;
  /**
   * @var int $BusinessUnit
   */
  public $BusinessUnit;
  /**
   * @var int $DefaultBusinessUnit
   */
  public $DefaultBusinessUnit;
  /**
   * @var ExactTarget_Locale $Locale
   */
  public $Locale;
  /**
   * @var ExactTarget_TimeZone $TimeZone
   */
  public $TimeZone;
  /**
   * @var ExactTarget_BusinessUnit $DefaultBusinessUnitObject
   */
  public $DefaultBusinessUnitObject;
  /**
   * @var ExactTarget_AssociatedBusinessUnits $AssociatedBusinessUnits
   */
  public $AssociatedBusinessUnits;
  /**
   * @var ExactTarget_Roles $Roles
   */
  public $Roles;
  /**
   * @var ExactTarget_Locale $LanguageLocale
   */
  public $LanguageLocale;
}

class ExactTarget_AssociatedBusinessUnits {
  /**
   * @var ExactTarget_BusinessUnit $BusinessUnit
   */
  public $BusinessUnit;
}


class ExactTarget_UserAccess {
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var string $Value
   */
  public $Value;
  /**
   * @var string $Description
   */
  public $Description;
  /**
   * @var int $Delete
   */
  public $Delete;
}

class ExactTarget_Brand {
  /**
   * @var int $BrandID
   */
  public $BrandID;
  /**
   * @var string $Label
   */
  public $Label;
  /**
   * @var string $Comment
   */
  public $Comment;
  /**
   * @var ExactTarget_BrandTag $BrandTags
   */
  public $BrandTags;
}

class ExactTarget_BrandTag {
  /**
   * @var int $BrandID
   */
  public $BrandID;
  /**
   * @var string $Label
   */
  public $Label;
  /**
   * @var string $Data
   */
  public $Data;
}

class ExactTarget_Role {
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var string $Description
   */
  public $Description;
  /**
   * @var boolean $IsPrivate
   */
  public $IsPrivate;
  /**
   * @var boolean $IsSystemDefined
   */
  public $IsSystemDefined;
  /**
   * @var boolean $ForceInheritance
   */
  public $ForceInheritance;
  /**
   * @var ExactTarget_PermissionSets $PermissionSets
   */
  public $PermissionSets;
  /**
   * @var ExactTarget_Permissions $Permissions
   */
  public $Permissions;
}

class ExactTarget_PermissionSets {
  /**
   * @var ExactTarget_PermissionSet $PermissionSet
   */
  public $PermissionSet;
}

class ExactTarget_Permissions {
  /**
   * @var ExactTarget_Permission $Permission
   */
  public $Permission;
}

class ExactTarget_PermissionSet {
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var string $Description
   */
  public $Description;
  /**
   * @var boolean $IsAllowed
   */
  public $IsAllowed;
  /**
   * @var boolean $IsDenied
   */
  public $IsDenied;
  /**
   * @var ExactTarget_PermissionSets $PermissionSets
   */
  public $PermissionSets;
  /**
   * @var ExactTarget_Permissions $Permissions
   */
  public $Permissions;
}



class ExactTarget_Permission {
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var string $Description
   */
  public $Description;
  /**
   * @var string $ObjectType
   */
  public $ObjectType;
  /**
   * @var string $Operation
   */
  public $Operation;
  /**
   * @var boolean $IsShareable
   */
  public $IsShareable;
  /**
   * @var boolean $IsAllowed
   */
  public $IsAllowed;
  /**
   * @var boolean $IsDenied
   */
  public $IsDenied;
}

class ExactTarget_Email {
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var string $Folder
   */
  public $Folder;
  /**
   * @var int $CategoryID
   */
  public $CategoryID;
  /**
   * @var string $HTMLBody
   */
  public $HTMLBody;
  /**
   * @var string $TextBody
   */
  public $TextBody;
  /**
   * @var ExactTarget_ContentArea $ContentAreas
   */
  public $ContentAreas;
  /**
   * @var string $Subject
   */
  public $Subject;
  /**
   * @var boolean $IsActive
   */
  public $IsActive;
  /**
   * @var boolean $IsHTMLPaste
   */
  public $IsHTMLPaste;
  /**
   * @var int $ClonedFromID
   */
  public $ClonedFromID;
  /**
   * @var string $Status
   */
  public $Status;
  /**
   * @var string $EmailType
   */
  public $EmailType;
  /**
   * @var string $CharacterSet
   */
  public $CharacterSet;
  /**
   * @var boolean $HasDynamicSubjectLine
   */
  public $HasDynamicSubjectLine;
  /**
   * @var string $ContentCheckStatus
   */
  public $ContentCheckStatus;
}

class ExactTarget_ContentArea {
  /**
   * @var string $Key
   */
  public $Key;
  /**
   * @var string $Content
   */
  public $Content;
  /**
   * @var boolean $IsBlank
   */
  public $IsBlank;
  /**
   * @var int $CategoryID
   */
  public $CategoryID;
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var ExactTarget_LayoutType $Layout
   */
  public $Layout;
  /**
   * @var boolean $IsDynamicContent
   */
  public $IsDynamicContent;
  /**
   * @var boolean $IsSurvey
   */
  public $IsSurvey;
}

class ExactTarget_LayoutType {
  const HTMLWrapped='HTMLWrapped';
  const RawText='RawText';
  const SMS='SMS';
}

class ExactTarget_Message {
  /**
   * @var string $TextBody
   */
  public $TextBody;
}

class ExactTarget_TrackingEvent {
  /**
   * @var int $SendID
   */
  public $SendID;
  /**
   * @var string $SubscriberKey
   */
  public $SubscriberKey;
  /**
   * @var dateTime $EventDate
   */
  public $EventDate;
  /**
   * @var ExactTarget_EventType $EventType
   */
  public $EventType;
  /**
   * @var string $TriggeredSendDefinitionObjectID
   */
  public $TriggeredSendDefinitionObjectID;
  /**
   * @var int $BatchID
   */
  public $BatchID;
}

class ExactTarget_EventType {
  const Open='Open';
  const Click='Click';
  const HardBounce='HardBounce';
  const SoftBounce='SoftBounce';
  const OtherBounce='OtherBounce';
  const Unsubscribe='Unsubscribe';
  const Sent='Sent';
  const NotSent='NotSent';
  const Survey='Survey';
  const ForwardedEmail='ForwardedEmail';
  const ForwardedEmailOptIn='ForwardedEmailOptIn';
}

class ExactTarget_OpenEvent {
}

class ExactTarget_BounceEvent {
  /**
   * @var string $SMTPCode
   */
  public $SMTPCode;
  /**
   * @var string $BounceCategory
   */
  public $BounceCategory;
  /**
   * @var string $SMTPReason
   */
  public $SMTPReason;
  /**
   * @var string $BounceType
   */
  public $BounceType;
}

class ExactTarget_UnsubEvent {
}

class ExactTarget_ClickEvent {
  /**
   * @var int $URLID
   */
  public $URLID;
  /**
   * @var string $URL
   */
  public $URL;
}

class ExactTarget_SentEvent {
}

class ExactTarget_NotSentEvent {
}

class ExactTarget_SurveyEvent {
  /**
   * @var string $Question
   */
  public $Question;
  /**
   * @var string $Answer
   */
  public $Answer;
}

class ExactTarget_ForwardedEmailEvent {
}

class ExactTarget_ForwardedEmailOptInEvent {
  /**
   * @var string $OptInSubscriberKey
   */
  public $OptInSubscriberKey;
}

class ExactTarget_Subscriber {
  /**
   * @var string $EmailAddress
   */
  public $EmailAddress;
  /**
   * @var ExactTarget_Attribute $Attributes
   */
  public $Attributes;
  /**
   * @var string $SubscriberKey
   */
  public $SubscriberKey;
  /**
   * @var dateTime $UnsubscribedDate
   */
  public $UnsubscribedDate;
  /**
   * @var ExactTarget_SubscriberStatus $Status
   */
  public $Status;
  /**
   * @var string $PartnerType
   */
  public $PartnerType;
  /**
   * @var ExactTarget_EmailType $EmailTypePreference
   */
  public $EmailTypePreference;
  /**
   * @var ExactTarget_SubscriberList $Lists
   */
  public $Lists;
  /**
   * @var ExactTarget_GlobalUnsubscribeCategory $GlobalUnsubscribeCategory
   */
  public $GlobalUnsubscribeCategory;
  /**
   * @var ExactTarget_SubscriberTypeDefinition $SubscriberTypeDefinition
   */
  public $SubscriberTypeDefinition;
  /**
   * @var ExactTarget_Addresses $Addresses
   */
  public $Addresses;
  /**
   * @var ExactTarget_SMSAddress $PrimarySMSAddress
   */
  public $PrimarySMSAddress;
  /**
   * @var ExactTarget_SubscriberAddressStatus $PrimarySMSPublicationStatus
   */
  public $PrimarySMSPublicationStatus;
  /**
   * @var ExactTarget_EmailAddress $PrimaryEmailAddress
   */
  public $PrimaryEmailAddress;
  /**
   * @var ExactTarget_Locale $Locale
   */
  public $Locale;
}

class ExactTarget_Addresses {
  /**
   * @var ExactTarget_SubscriberAddress $Address
   */
  public $Address;
}

class ExactTarget_Attribute {
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var string $Value
   */
  public $Value;
  /**
   * @var ExactTarget_CompressionConfiguration $Compression
   */
  public $Compression;
}

class ExactTarget_CompressionConfiguration {
  /**
   * @var ExactTarget_CompressionType $Type
   */
  public $Type;
  /**
   * @var ExactTarget_CompressionEncoding $Encoding
   */
  public $Encoding;
}

class ExactTarget_CompressionType {
  const gzip='gzip';
}

class ExactTarget_CompressionEncoding {
  const base64='base64';
}

class ExactTarget_SubscriberStatus {
  const Active='Active';
  const Bounced='Bounced';
  const Held='Held';
  const Unsubscribed='Unsubscribed';
  const Deleted='Deleted';
}

class ExactTarget_SubscriberTypeDefinition {
  /**
   * @var string $SubscriberType
   */
  public $SubscriberType;
}

class ExactTarget_EmailType {
  const Text='Text';
  const HTML='HTML';
}

class ExactTarget_ListSubscriber {
  /**
   * @var ExactTarget_SubscriberStatus $Status
   */
  public $Status;
  /**
   * @var int $ListID
   */
  public $ListID;
  /**
   * @var string $SubscriberKey
   */
  public $SubscriberKey;
}

class ExactTarget_SubscriberList {
  /**
   * @var ExactTarget_SubscriberStatus $Status
   */
  public $Status;
  /**
   * @var ExactTarget_List $List
   */
  public $List;
  /**
   * @var string $Action
   */
  public $Action;
  /**
   * @var ExactTarget_Subscriber $Subscriber
   */
  public $Subscriber;
}

class ExactTarget_List {
  /**
   * @var string $ListName
   */
  public $ListName;
  /**
   * @var int $Category
   */
  public $Category;
  /**
   * @var ExactTarget_ListTypeEnum $Type
   */
  public $Type;
  /**
   * @var string $Description
   */
  public $Description;
  /**
   * @var ExactTarget_Subscriber $Subscribers
   */
  public $Subscribers;
  /**
   * @var ExactTarget_ListClassificationEnum $ListClassification
   */
  public $ListClassification;
  /**
   * @var ExactTarget_Email $AutomatedEmail
   */
  public $AutomatedEmail;
  /**
   * @var ExactTarget_SendClassification $SendClassification
   */
  public $SendClassification;
}

class ExactTarget_ListTypeEnum {
  const _Public='Public';
  const _Private='Private';
  const SalesForce='SalesForce';
  const GlobalUnsubscribe='GlobalUnsubscribe';
  const Master='Master';
}

class ExactTarget_ListClassificationEnum {
  const ExactTargetList='ExactTargetList';
  const PublicationList='PublicationList';
  const SuppressionList='SuppressionList';
}

class ExactTarget_Group {
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var int $Category
   */
  public $Category;
  /**
   * @var string $Description
   */
  public $Description;
  /**
   * @var ExactTarget_Subscriber $Subscribers
   */
  public $Subscribers;
}

class ExactTarget_OverrideType {
  const DoNotOverride='DoNotOverride';
  const Override='Override';
  const OverrideExceptWhenNull='OverrideExceptWhenNull';
}

class ExactTarget_ListAttributeFieldType {
  const Text='Text';
  const Number='Number';
  const Date='Date';
  const Boolean='Boolean';
  const Decimal='Decimal';
}

class ExactTarget_ListAttribute {
  /**
   * @var ExactTarget_List $List
   */
  public $List;
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var string $Description
   */
  public $Description;
  /**
   * @var ExactTarget_ListAttributeFieldType $FieldType
   */
  public $FieldType;
  /**
   * @var int $FieldLength
   */
  public $FieldLength;
  /**
   * @var int $Scale
   */
  public $Scale;
  /**
   * @var string $MinValue
   */
  public $MinValue;
  /**
   * @var string $MaxValue
   */
  public $MaxValue;
  /**
   * @var string $DefaultValue
   */
  public $DefaultValue;
  /**
   * @var boolean $IsNullable
   */
  public $IsNullable;
  /**
   * @var boolean $IsHidden
   */
  public $IsHidden;
  /**
   * @var boolean $IsReadOnly
   */
  public $IsReadOnly;
  /**
   * @var boolean $Inheritable
   */
  public $Inheritable;
  /**
   * @var boolean $Overridable
   */
  public $Overridable;
  /**
   * @var boolean $MustOverride
   */
  public $MustOverride;
  /**
   * @var ExactTarget_OverrideType $OverrideType
   */
  public $OverrideType;
  /**
   * @var int $Ordinal
   */
  public $Ordinal;
  /**
   * @var ExactTarget_ListAttributeRestrictedValue $RestrictedValues
   */
  public $RestrictedValues;
  /**
   * @var ExactTarget_ListAttribute $BaseAttribute
   */
  public $BaseAttribute;
}

class ExactTarget_ListAttributeRestrictedValue {
  /**
   * @var string $ValueName
   */
  public $ValueName;
  /**
   * @var boolean $IsDefault
   */
  public $IsDefault;
  /**
   * @var int $DisplayOrder
   */
  public $DisplayOrder;
  /**
   * @var string $Description
   */
  public $Description;
}

class ExactTarget_GlobalUnsubscribeCategory {
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var boolean $IgnorableByPartners
   */
  public $IgnorableByPartners;
  /**
   * @var boolean $Ignore
   */
  public $Ignore;
}

class ExactTarget_Campaign {
}

class ExactTarget_Send {
  /**
   * @var ExactTarget_Email $Email
   */
  public $Email;
  /**
   * @var ExactTarget_List $List
   */
  public $List;
  /**
   * @var dateTime $SendDate
   */
  public $SendDate;
  /**
   * @var string $FromAddress
   */
  public $FromAddress;
  /**
   * @var string $FromName
   */
  public $FromName;
  /**
   * @var int $Duplicates
   */
  public $Duplicates;
  /**
   * @var int $InvalidAddresses
   */
  public $InvalidAddresses;
  /**
   * @var int $ExistingUndeliverables
   */
  public $ExistingUndeliverables;
  /**
   * @var int $ExistingUnsubscribes
   */
  public $ExistingUnsubscribes;
  /**
   * @var int $HardBounces
   */
  public $HardBounces;
  /**
   * @var int $SoftBounces
   */
  public $SoftBounces;
  /**
   * @var int $OtherBounces
   */
  public $OtherBounces;
  /**
   * @var int $ForwardedEmails
   */
  public $ForwardedEmails;
  /**
   * @var int $UniqueClicks
   */
  public $UniqueClicks;
  /**
   * @var int $UniqueOpens
   */
  public $UniqueOpens;
  /**
   * @var int $NumberSent
   */
  public $NumberSent;
  /**
   * @var int $NumberDelivered
   */
  public $NumberDelivered;
  /**
   * @var int $Unsubscribes
   */
  public $Unsubscribes;
  /**
   * @var int $MissingAddresses
   */
  public $MissingAddresses;
  /**
   * @var string $Subject
   */
  public $Subject;
  /**
   * @var string $PreviewURL
   */
  public $PreviewURL;
  /**
   * @var ExactTarget_Link $Links
   */
  public $Links;
  /**
   * @var ExactTarget_TrackingEvent $Events
   */
  public $Events;
  /**
   * @var dateTime $SentDate
   */
  public $SentDate;
  /**
   * @var string $EmailName
   */
  public $EmailName;
  /**
   * @var string $Status
   */
  public $Status;
  /**
   * @var boolean $IsMultipart
   */
  public $IsMultipart;
  /**
   * @var int $SendLimit
   */
  public $SendLimit;
  /**
   * @var time $SendWindowOpen
   */
  public $SendWindowOpen;
  /**
   * @var time $SendWindowClose
   */
  public $SendWindowClose;
  /**
   * @var boolean $IsAlwaysOn
   */
  public $IsAlwaysOn;
  /**
   * @var ExactTarget_Sources $Sources
   */
  public $Sources;
  /**
   * @var int $NumberTargeted
   */
  public $NumberTargeted;
  /**
   * @var int $NumberErrored
   */
  public $NumberErrored;
  /**
   * @var int $NumberExcluded
   */
  public $NumberExcluded;
  /**
   * @var string $Additional
   */
  public $Additional;
  /**
   * @var string $BccEmail
   */
  public $BccEmail;
  /**
   * @var ExactTarget_EmailSendDefinition $EmailSendDefinition
   */
  public $EmailSendDefinition;
  /**
   * @var ExactTarget_SuppressionLists $SuppressionLists
   */
  public $SuppressionLists;
}

class ExactTarget_Sources {
  /**
   * @var ExactTarget_APIObject $Source
   */
  public $Source;
}

class ExactTarget_SuppressionLists {
  /**
   * @var ExactTarget_AudienceItem $SuppressionList
   */
  public $SuppressionList;
}

class ExactTarget_Link {
  /**
   * @var dateTime $LastClicked
   */
  public $LastClicked;
  /**
   * @var string $Alias
   */
  public $Alias;
  /**
   * @var int $TotalClicks
   */
  public $TotalClicks;
  /**
   * @var int $UniqueClicks
   */
  public $UniqueClicks;
  /**
   * @var string $URL
   */
  public $URL;
  /**
   * @var ExactTarget_TrackingEvent $Subscribers
   */
  public $Subscribers;
}

class ExactTarget_SendSummary {
  /**
   * @var int $AccountID
   */
  public $AccountID;
  /**
   * @var string $AccountName
   */
  public $AccountName;
  /**
   * @var string $AccountEmail
   */
  public $AccountEmail;
  /**
   * @var boolean $IsTestAccount
   */
  public $IsTestAccount;
  /**
   * @var int $SendID
   */
  public $SendID;
  /**
   * @var string $DeliveredTime
   */
  public $DeliveredTime;
  /**
   * @var int $TotalSent
   */
  public $TotalSent;
  /**
   * @var int $Transactional
   */
  public $Transactional;
  /**
   * @var int $NonTransactional
   */
  public $NonTransactional;
}

class ExactTarget_TriggeredSendDefinition {
  /**
   * @var ExactTarget_TriggeredSendTypeEnum $TriggeredSendType
   */
  public $TriggeredSendType;
  /**
   * @var ExactTarget_TriggeredSendStatusEnum $TriggeredSendStatus
   */
  public $TriggeredSendStatus;
  /**
   * @var ExactTarget_Email $Email
   */
  public $Email;
  /**
   * @var ExactTarget_List $List
   */
  public $List;
  /**
   * @var boolean $AutoAddSubscribers
   */
  public $AutoAddSubscribers;
  /**
   * @var boolean $AutoUpdateSubscribers
   */
  public $AutoUpdateSubscribers;
  /**
   * @var int $BatchInterval
   */
  public $BatchInterval;
  /**
   * @var string $BccEmail
   */
  public $BccEmail;
  /**
   * @var string $EmailSubject
   */
  public $EmailSubject;
  /**
   * @var string $DynamicEmailSubject
   */
  public $DynamicEmailSubject;
  /**
   * @var boolean $IsMultipart
   */
  public $IsMultipart;
  /**
   * @var boolean $IsWrapped
   */
  public $IsWrapped;
  /**
   * @var short $AllowedSlots
   */
  public $AllowedSlots;
  /**
   * @var int $NewSlotTrigger
   */
  public $NewSlotTrigger;
  /**
   * @var int $SendLimit
   */
  public $SendLimit;
  /**
   * @var time $SendWindowOpen
   */
  public $SendWindowOpen;
  /**
   * @var time $SendWindowClose
   */
  public $SendWindowClose;
  /**
   * @var boolean $SendWindowDelete
   */
  public $SendWindowDelete;
  /**
   * @var boolean $RefreshContent
   */
  public $RefreshContent;
  /**
   * @var string $ExclusionFilter
   */
  public $ExclusionFilter;
  /**
   * @var string $Priority
   */
  public $Priority;
  /**
   * @var string $SendSourceCustomerKey
   */
  public $SendSourceCustomerKey;
  /**
   * @var ExactTarget_TriggeredSendExclusionList $ExclusionListCollection
   */
  public $ExclusionListCollection;
  /**
   * @var string $CCEmail
   */
  public $CCEmail;
  /**
   * @var ExactTarget_DataExtension $SendSourceDataExtension
   */
  public $SendSourceDataExtension;
  /**
   * @var boolean $IsAlwaysOn
   */
  public $IsAlwaysOn;
  /**
   * @var boolean $DisableOnEmailBuildError
   */
  public $DisableOnEmailBuildError;
}

class ExactTarget_TriggeredSendExclusionList {
}

class ExactTarget_TriggeredSendTypeEnum {
  const Continuous='Continuous';
  const Batched='Batched';
  const Scheduled='Scheduled';
}

class ExactTarget_TriggeredSendStatusEnum {
  const _New='New';
  const Inactive='Inactive';
  const Active='Active';
  const Canceled='Canceled';
  const Deleted='Deleted';
  const Moved='Moved';
}

class ExactTarget_TriggeredSend {
  /**
   * @var ExactTarget_TriggeredSendDefinition $TriggeredSendDefinition
   */
  public $TriggeredSendDefinition;
  /**
   * @var ExactTarget_Subscriber $Subscribers
   */
  public $Subscribers;
  /**
   * @var ExactTarget_Attribute $Attributes
   */
  public $Attributes;
}

class ExactTarget_TriggeredSendCreateResult {
  /**
   * @var ExactTarget_SubscriberResult $SubscriberFailures
   */
  public $SubscriberFailures;
}

class ExactTarget_SubscriberResult {
  /**
   * @var ExactTarget_Subscriber $Subscriber
   */
  public $Subscriber;
  /**
   * @var string $ErrorCode
   */
  public $ErrorCode;
  /**
   * @var string $ErrorDescription
   */
  public $ErrorDescription;
  /**
   * @var int $Ordinal
   */
  public $Ordinal;
}

class ExactTarget_SubscriberSendResult {
  /**
   * @var ExactTarget_Send $Send
   */
  public $Send;
  /**
   * @var ExactTarget_Email $Email
   */
  public $Email;
  /**
   * @var ExactTarget_Subscriber $Subscriber
   */
  public $Subscriber;
  /**
   * @var dateTime $ClickDate
   */
  public $ClickDate;
  /**
   * @var dateTime $BounceDate
   */
  public $BounceDate;
  /**
   * @var dateTime $OpenDate
   */
  public $OpenDate;
  /**
   * @var dateTime $SentDate
   */
  public $SentDate;
  /**
   * @var string $LastAction
   */
  public $LastAction;
  /**
   * @var dateTime $UnsubscribeDate
   */
  public $UnsubscribeDate;
  /**
   * @var string $FromAddress
   */
  public $FromAddress;
  /**
   * @var string $FromName
   */
  public $FromName;
  /**
   * @var int $TotalClicks
   */
  public $TotalClicks;
  /**
   * @var int $UniqueClicks
   */
  public $UniqueClicks;
  /**
   * @var string $Subject
   */
  public $Subject;
  /**
   * @var string $ViewSentEmailURL
   */
  public $ViewSentEmailURL;
  /**
   * @var int $HardBounces
   */
  public $HardBounces;
  /**
   * @var int $SoftBounces
   */
  public $SoftBounces;
  /**
   * @var int $OtherBounces
   */
  public $OtherBounces;
}

class ExactTarget_TriggeredSendSummary {
  /**
   * @var ExactTarget_TriggeredSendDefinition $TriggeredSendDefinition
   */
  public $TriggeredSendDefinition;
  /**
   * @var long $Sent
   */
  public $Sent;
  /**
   * @var long $NotSentDueToOptOut
   */
  public $NotSentDueToOptOut;
  /**
   * @var long $NotSentDueToUndeliverable
   */
  public $NotSentDueToUndeliverable;
  /**
   * @var long $Bounces
   */
  public $Bounces;
  /**
   * @var long $Opens
   */
  public $Opens;
  /**
   * @var long $Clicks
   */
  public $Clicks;
  /**
   * @var long $UniqueOpens
   */
  public $UniqueOpens;
  /**
   * @var long $UniqueClicks
   */
  public $UniqueClicks;
  /**
   * @var long $OptOuts
   */
  public $OptOuts;
  /**
   * @var long $SurveyResponses
   */
  public $SurveyResponses;
  /**
   * @var long $FTAFRequests
   */
  public $FTAFRequests;
  /**
   * @var long $FTAFEmailsSent
   */
  public $FTAFEmailsSent;
  /**
   * @var long $FTAFOptIns
   */
  public $FTAFOptIns;
  /**
   * @var long $Conversions
   */
  public $Conversions;
  /**
   * @var long $UniqueConversions
   */
  public $UniqueConversions;
  /**
   * @var long $InProcess
   */
  public $InProcess;
  /**
   * @var long $NotSentDueToError
   */
  public $NotSentDueToError;
}

class ExactTarget_AsyncRequestResult {
  /**
   * @var string $Status
   */
  public $Status;
  /**
   * @var dateTime $CompleteDate
   */
  public $CompleteDate;
  /**
   * @var string $CallStatus
   */
  public $CallStatus;
  /**
   * @var string $CallMessage
   */
  public $CallMessage;
}

class ExactTarget_VoiceTriggeredSend {
  /**
   * @var ExactTarget_VoiceTriggeredSendDefinition $VoiceTriggeredSendDefinition
   */
  public $VoiceTriggeredSendDefinition;
  /**
   * @var ExactTarget_Subscriber $Subscriber
   */
  public $Subscriber;
  /**
   * @var string $Message
   */
  public $Message;
  /**
   * @var string $Number
   */
  public $Number;
  /**
   * @var string $TransferMessage
   */
  public $TransferMessage;
  /**
   * @var string $TransferNumber
   */
  public $TransferNumber;
}

class ExactTarget_VoiceTriggeredSendDefinition {
}

class ExactTarget_SMSTriggeredSend {
  /**
   * @var ExactTarget_SMSTriggeredSendDefinition $SMSTriggeredSendDefinition
   */
  public $SMSTriggeredSendDefinition;
  /**
   * @var ExactTarget_Subscriber $Subscriber
   */
  public $Subscriber;
  /**
   * @var string $Message
   */
  public $Message;
  /**
   * @var string $Number
   */
  public $Number;
  /**
   * @var string $FromAddress
   */
  public $FromAddress;
  /**
   * @var string $SmsSendId
   */
  public $SmsSendId;
}

class ExactTarget_SMSTriggeredSendDefinition {
  /**
   * @var ExactTarget_List $Publication
   */
  public $Publication;
  /**
   * @var ExactTarget_DataExtension $DataExtension
   */
  public $DataExtension;
  /**
   * @var ExactTarget_ContentArea $Content
   */
  public $Content;
  /**
   * @var boolean $SendToList
   */
  public $SendToList;
}

class ExactTarget_SendClassification {
  /**
   * @var ExactTarget_SendClassificationTypeEnum $SendClassificationType
   */
  public $SendClassificationType;
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var string $Description
   */
  public $Description;
  /**
   * @var ExactTarget_SenderProfile $SenderProfile
   */
  public $SenderProfile;
  /**
   * @var ExactTarget_DeliveryProfile $DeliveryProfile
   */
  public $DeliveryProfile;
  /**
   * @var boolean $HonorPublicationListOptOutsForTransactionalSends
   */
  public $HonorPublicationListOptOutsForTransactionalSends;
  /**
   * @var ExactTarget_SendPriorityEnum $SendPriority
   */
  public $SendPriority;
}

class ExactTarget_SendClassificationTypeEnum {
  const Operational='Operational';
  const Marketing='Marketing';
}

class ExactTarget_SendPriorityEnum {
  const Burst='Burst';
  const Normal='Normal';
  const Low='Low';
}

class ExactTarget_SenderProfile {
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var string $Description
   */
  public $Description;
  /**
   * @var string $FromName
   */
  public $FromName;
  /**
   * @var string $FromAddress
   */
  public $FromAddress;
  /**
   * @var boolean $UseDefaultRMMRules
   */
  public $UseDefaultRMMRules;
  /**
   * @var string $AutoForwardToEmailAddress
   */
  public $AutoForwardToEmailAddress;
  /**
   * @var string $AutoForwardToName
   */
  public $AutoForwardToName;
  /**
   * @var boolean $DirectForward
   */
  public $DirectForward;
  /**
   * @var ExactTarget_TriggeredSendDefinition $AutoForwardTriggeredSend
   */
  public $AutoForwardTriggeredSend;
  /**
   * @var boolean $AutoReply
   */
  public $AutoReply;
  /**
   * @var ExactTarget_TriggeredSendDefinition $AutoReplyTriggeredSend
   */
  public $AutoReplyTriggeredSend;
  /**
   * @var string $SenderHeaderEmailAddress
   */
  public $SenderHeaderEmailAddress;
  /**
   * @var string $SenderHeaderName
   */
  public $SenderHeaderName;
  /**
   * @var short $DataRetentionPeriodLength
   */
  public $DataRetentionPeriodLength;
  /**
   * @var ExactTarget_RecurrenceTypeEnum $DataRetentionPeriodUnitOfMeasure
   */
  public $DataRetentionPeriodUnitOfMeasure;
  /**
   * @var ExactTarget_APIObject $ReplyManagementRuleSet
   */
  public $ReplyManagementRuleSet;
}

class ExactTarget_DeliveryProfile {
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var string $Description
   */
  public $Description;
  /**
   * @var ExactTarget_DeliveryProfileSourceAddressTypeEnum $SourceAddressType
   */
  public $SourceAddressType;
  /**
   * @var ExactTarget_PrivateIP $PrivateIP
   */
  public $PrivateIP;
  /**
   * @var ExactTarget_DeliveryProfileDomainTypeEnum $DomainType
   */
  public $DomainType;
  /**
   * @var ExactTarget_PrivateDomain $PrivateDomain
   */
  public $PrivateDomain;
  /**
   * @var ExactTarget_SalutationSourceEnum $HeaderSalutationSource
   */
  public $HeaderSalutationSource;
  /**
   * @var ExactTarget_ContentArea $HeaderContentArea
   */
  public $HeaderContentArea;
  /**
   * @var ExactTarget_SalutationSourceEnum $FooterSalutationSource
   */
  public $FooterSalutationSource;
  /**
   * @var ExactTarget_ContentArea $FooterContentArea
   */
  public $FooterContentArea;
  /**
   * @var boolean $SubscriberLevelPrivateDomain
   */
  public $SubscriberLevelPrivateDomain;
  /**
   * @var ExactTarget_Certificate $SMIMESignatureCertificate
   */
  public $SMIMESignatureCertificate;
  /**
   * @var ExactTarget_PrivateDomainSet $PrivateDomainSet
   */
  public $PrivateDomainSet;
}

class ExactTarget_DeliveryProfileSourceAddressTypeEnum {
  const DefaultPrivateIPAddress='DefaultPrivateIPAddress';
  const CustomPrivateIPAddress='CustomPrivateIPAddress';
}

class ExactTarget_DeliveryProfileDomainTypeEnum {
  const DefaultDomain='DefaultDomain';
  const CustomDomain='CustomDomain';
}

class ExactTarget_SalutationSourceEnum {
  const _Default='Default';
  const ContentLibrary='ContentLibrary';
  const None='None';
}

class ExactTarget_PrivateDomain {
}

class ExactTarget_PrivateDomainSet {
}

class ExactTarget_PrivateIP {
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var string $Description
   */
  public $Description;
  /**
   * @var boolean $IsActive
   */
  public $IsActive;
  /**
   * @var short $OrdinalID
   */
  public $OrdinalID;
  /**
   * @var string $IPAddress
   */
  public $IPAddress;
}

class ExactTarget_SendDefinition {
  /**
   * @var int $CategoryID
   */
  public $CategoryID;
  /**
   * @var ExactTarget_SendClassification $SendClassification
   */
  public $SendClassification;
  /**
   * @var ExactTarget_SenderProfile $SenderProfile
   */
  public $SenderProfile;
  /**
   * @var string $FromName
   */
  public $FromName;
  /**
   * @var string $FromAddress
   */
  public $FromAddress;
  /**
   * @var ExactTarget_DeliveryProfile $DeliveryProfile
   */
  public $DeliveryProfile;
  /**
   * @var ExactTarget_DeliveryProfileSourceAddressTypeEnum $SourceAddressType
   */
  public $SourceAddressType;
  /**
   * @var ExactTarget_PrivateIP $PrivateIP
   */
  public $PrivateIP;
  /**
   * @var ExactTarget_DeliveryProfileDomainTypeEnum $DomainType
   */
  public $DomainType;
  /**
   * @var ExactTarget_PrivateDomain $PrivateDomain
   */
  public $PrivateDomain;
  /**
   * @var ExactTarget_SalutationSourceEnum $HeaderSalutationSource
   */
  public $HeaderSalutationSource;
  /**
   * @var ExactTarget_ContentArea $HeaderContentArea
   */
  public $HeaderContentArea;
  /**
   * @var ExactTarget_SalutationSourceEnum $FooterSalutationSource
   */
  public $FooterSalutationSource;
  /**
   * @var ExactTarget_ContentArea $FooterContentArea
   */
  public $FooterContentArea;
  /**
   * @var boolean $SuppressTracking
   */
  public $SuppressTracking;
  /**
   * @var boolean $IsSendLogging
   */
  public $IsSendLogging;
}

class ExactTarget_AudienceItem {
  /**
   * @var ExactTarget_List $List
   */
  public $List;
  /**
   * @var ExactTarget_SendDefinitionListTypeEnum $SendDefinitionListType
   */
  public $SendDefinitionListType;
  /**
   * @var string $CustomObjectID
   */
  public $CustomObjectID;
  /**
   * @var ExactTarget_DataSourceTypeEnum $DataSourceTypeID
   */
  public $DataSourceTypeID;
}

class ExactTarget_EmailSendDefinition {
  /**
   * @var ExactTarget_SendDefinitionList $SendDefinitionList
   */
  public $SendDefinitionList;
  /**
   * @var ExactTarget_Email $Email
   */
  public $Email;
  /**
   * @var string $BccEmail
   */
  public $BccEmail;
  /**
   * @var string $AutoBccEmail
   */
  public $AutoBccEmail;
  /**
   * @var string $TestEmailAddr
   */
  public $TestEmailAddr;
  /**
   * @var string $EmailSubject
   */
  public $EmailSubject;
  /**
   * @var string $DynamicEmailSubject
   */
  public $DynamicEmailSubject;
  /**
   * @var boolean $IsMultipart
   */
  public $IsMultipart;
  /**
   * @var boolean $IsWrapped
   */
  public $IsWrapped;
  /**
   * @var int $SendLimit
   */
  public $SendLimit;
  /**
   * @var time $SendWindowOpen
   */
  public $SendWindowOpen;
  /**
   * @var time $SendWindowClose
   */
  public $SendWindowClose;
  /**
   * @var boolean $SendWindowDelete
   */
  public $SendWindowDelete;
  /**
   * @var boolean $DeduplicateByEmail
   */
  public $DeduplicateByEmail;
  /**
   * @var string $ExclusionFilter
   */
  public $ExclusionFilter;
  /**
   * @var ExactTarget_TrackingUsers $TrackingUsers
   */
  public $TrackingUsers;
  /**
   * @var string $Additional
   */
  public $Additional;
  /**
   * @var string $CCEmail
   */
  public $CCEmail;
  /**
   * @var time $DeliveryScheduledTime
   */
  public $DeliveryScheduledTime;
  /**
   * @var ExactTarget_MessageDeliveryTypeEnum $MessageDeliveryType
   */
  public $MessageDeliveryType;
  /**
   * @var boolean $IsSeedListSend
   */
  public $IsSeedListSend;
}

class ExactTarget_TrackingUsers {
  /**
   * @var ExactTarget_TrackingUser $TrackingUser
   */
  public $TrackingUser;
}

class ExactTarget_SendDefinitionList {
  /**
   * @var ExactTarget_FilterDefinition $FilterDefinition
   */
  public $FilterDefinition;
  /**
   * @var boolean $IsTestObject
   */
  public $IsTestObject;
  /**
   * @var string $SalesForceObjectID
   */
  public $SalesForceObjectID;
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var ExactTarget_Parameters $Parameters
   */
  public $Parameters;
}

class ExactTarget_Parameters {
  /**
   * @var ExactTarget_APIProperty $Parameter
   */
  public $Parameter;
}

class ExactTarget_SendDefinitionStatusEnum {
  const Active='Active';
  const Archived='Archived';
  const Deleted='Deleted';
}

class ExactTarget_SendDefinitionListTypeEnum {
  const SourceList='SourceList';
  const ExclusionList='ExclusionList';
  const DomainExclusion='DomainExclusion';
  const OptOutList='OptOutList';
}

class ExactTarget_DataSourceTypeEnum {
  const _List='List';
  const CustomObject='CustomObject';
  const DomainExclusion='DomainExclusion';
  const SalesForceReport='SalesForceReport';
  const SalesForceCampaign='SalesForceCampaign';
  const FilterDefinition='FilterDefinition';
  const OptOutList='OptOutList';
}

class ExactTarget_MessageDeliveryTypeEnum {
  const Standard='Standard';
  const DelayedDeliveryByMTAQueue='DelayedDeliveryByMTAQueue';
}

class ExactTarget_TrackingUser {
  /**
   * @var boolean $IsActive
   */
  public $IsActive;
  /**
   * @var int $EmployeeID
   */
  public $EmployeeID;
}

class ExactTarget_MessagingVendorKind {
  /**
   * @var string $Vendor
   */
  public $Vendor;
  /**
   * @var string $Kind
   */
  public $Kind;
  /**
   * @var boolean $IsUsernameRequired
   */
  public $IsUsernameRequired;
  /**
   * @var boolean $IsPasswordRequired
   */
  public $IsPasswordRequired;
  /**
   * @var boolean $IsProfileRequired
   */
  public $IsProfileRequired;
}

class ExactTarget_MessagingConfiguration {
  /**
   * @var string $Code
   */
  public $Code;
  /**
   * @var ExactTarget_MessagingVendorKind $MessagingVendorKind
   */
  public $MessagingVendorKind;
  /**
   * @var boolean $IsActive
   */
  public $IsActive;
  /**
   * @var string $Url
   */
  public $Url;
  /**
   * @var string $UserName
   */
  public $UserName;
  /**
   * @var string $Password
   */
  public $Password;
  /**
   * @var string $ProfileID
   */
  public $ProfileID;
  /**
   * @var string $CallbackUrl
   */
  public $CallbackUrl;
  /**
   * @var string $MediaTypes
   */
  public $MediaTypes;
}

class ExactTarget_SMSMTEvent {
  /**
   * @var ExactTarget_SMSTriggeredSend $SMSTriggeredSend
   */
  public $SMSTriggeredSend;
  /**
   * @var ExactTarget_Subscriber $Subscriber
   */
  public $Subscriber;
  /**
   * @var string $MOCode
   */
  public $MOCode;
  /**
   * @var dateTime $EventDate
   */
  public $EventDate;
  /**
   * @var string $Carrier
   */
  public $Carrier;
}

class ExactTarget_SMSMOEvent {
  /**
   * @var ExactTarget_BaseMOKeyword $Keyword
   */
  public $Keyword;
  /**
   * @var string $MobileTelephoneNumber
   */
  public $MobileTelephoneNumber;
  /**
   * @var string $MOCode
   */
  public $MOCode;
  /**
   * @var dateTime $EventDate
   */
  public $EventDate;
  /**
   * @var string $MOMessage
   */
  public $MOMessage;
  /**
   * @var string $MTMessage
   */
  public $MTMessage;
  /**
   * @var string $Carrier
   */
  public $Carrier;
}

class ExactTarget_BaseMOKeyword {
  /**
   * @var boolean $IsDefaultKeyword
   */
  public $IsDefaultKeyword;
}

class ExactTarget_SendSMSMOKeyword {
  /**
   * @var ExactTarget_BaseMOKeyword $NextMOKeyword
   */
  public $NextMOKeyword;
  /**
   * @var string $Message
   */
  public $Message;
  /**
   * @var string $ScriptErrorMessage
   */
  public $ScriptErrorMessage;
}

class ExactTarget_UnsubscribeFromSMSPublicationMOKeyword {
  /**
   * @var ExactTarget_BaseMOKeyword $NextMOKeyword
   */
  public $NextMOKeyword;
  /**
   * @var string $AllUnsubSuccessMessage
   */
  public $AllUnsubSuccessMessage;
  /**
   * @var string $InvalidPublicationMessage
   */
  public $InvalidPublicationMessage;
  /**
   * @var string $SingleUnsubSuccessMessage
   */
  public $SingleUnsubSuccessMessage;
}

class ExactTarget_DoubleOptInMOKeyword {
  /**
   * @var ExactTarget_List $DefaultPublication
   */
  public $DefaultPublication;
  /**
   * @var string $InvalidPublicationMessage
   */
  public $InvalidPublicationMessage;
  /**
   * @var string $InvalidResponseMessage
   */
  public $InvalidResponseMessage;
  /**
   * @var string $MissingPublicationMessage
   */
  public $MissingPublicationMessage;
  /**
   * @var string $NeedPublicationMessage
   */
  public $NeedPublicationMessage;
  /**
   * @var string $PromptMessage
   */
  public $PromptMessage;
  /**
   * @var string $SuccessMessage
   */
  public $SuccessMessage;
  /**
   * @var string $UnexpectedErrorMessage
   */
  public $UnexpectedErrorMessage;
  /**
   * @var ExactTarget_ValidPublications $ValidPublications
   */
  public $ValidPublications;
  /**
   * @var ExactTarget_ValidResponses $ValidResponses
   */
  public $ValidResponses;
}

class ExactTarget_ValidPublications {
  /**
   * @var ExactTarget_List $ValidPublication
   */
  public $ValidPublication;
}

class ExactTarget_ValidResponses {
  /**
   * @var string $ValidResponse
   */
  public $ValidResponse;
}

class ExactTarget_HelpMOKeyword {
  /**
   * @var string $FriendlyName
   */
  public $FriendlyName;
  /**
   * @var string $DefaultHelpMessage
   */
  public $DefaultHelpMessage;
  /**
   * @var string $MenuText
   */
  public $MenuText;
  /**
   * @var string $MoreChoicesPrompt
   */
  public $MoreChoicesPrompt;
}

class ExactTarget_SendEmailMOKeyword {
  /**
   * @var string $SuccessMessage
   */
  public $SuccessMessage;
  /**
   * @var string $MissingEmailMessage
   */
  public $MissingEmailMessage;
  /**
   * @var string $FailureMessage
   */
  public $FailureMessage;
  /**
   * @var ExactTarget_TriggeredSendDefinition $TriggeredSend
   */
  public $TriggeredSend;
  /**
   * @var ExactTarget_BaseMOKeyword $NextMOKeyword
   */
  public $NextMOKeyword;
}

class ExactTarget_SMSSharedKeyword {
  /**
   * @var string $ShortCode
   */
  public $ShortCode;
  /**
   * @var string $SharedKeyword
   */
  public $SharedKeyword;
  /**
   * @var dateTime $RequestDate
   */
  public $RequestDate;
  /**
   * @var dateTime $EffectiveDate
   */
  public $EffectiveDate;
  /**
   * @var dateTime $ExpireDate
   */
  public $ExpireDate;
  /**
   * @var dateTime $ReturnToPoolDate
   */
  public $ReturnToPoolDate;
  /**
   * @var string $CountryCode
   */
  public $CountryCode;
}

class ExactTarget_UserMap {
  /**
   * @var ExactTarget_AccountUser $ETAccountUser
   */
  public $ETAccountUser;
  /**
   * @var ExactTarget_APIProperty $AdditionalData
   */
  public $AdditionalData;
}

class ExactTarget_Folder {
  /**
   * @var int $ID
   */
  public $ID;
  /**
   * @var int $ParentID
   */
  public $ParentID;
}

class ExactTarget_FileTransferLocation {
}

class ExactTarget_DataExtractActivity {
}

class ExactTarget_MessageSendActivity {
}

class ExactTarget_SmsSendActivity {
}

class ExactTarget_ReportActivity {
}

class ExactTarget_DataExtension {
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var string $Description
   */
  public $Description;
  /**
   * @var boolean $IsSendable
   */
  public $IsSendable;
  /**
   * @var boolean $IsTestable
   */
  public $IsTestable;
  /**
   * @var ExactTarget_DataExtensionField $SendableDataExtensionField
   */
  public $SendableDataExtensionField;
  /**
   * @var ExactTarget_Attribute $SendableSubscriberField
   */
  public $SendableSubscriberField;
  /**
   * @var ExactTarget_DataExtensionTemplate $Template
   */
  public $Template;
  /**
   * @var int $DataRetentionPeriodLength
   */
  public $DataRetentionPeriodLength;
  /**
   * @var int $DataRetentionPeriodUnitOfMeasure
   */
  public $DataRetentionPeriodUnitOfMeasure;
  /**
   * @var boolean $RowBasedRetention
   */
  public $RowBasedRetention;
  /**
   * @var boolean $ResetRetentionPeriodOnImport
   */
  public $ResetRetentionPeriodOnImport;
  /**
   * @var boolean $DeleteAtEndOfRetentionPeriod
   */
  public $DeleteAtEndOfRetentionPeriod;
  /**
   * @var string $RetainUntil
   */
  public $RetainUntil;
  /**
   * @var ExactTarget_Fields $Fields
   */
  public $Fields;
  /**
   * @var ExactTarget_DateTimeUnitOfMeasure $DataRetentionPeriod
   */
  public $DataRetentionPeriod;
  /**
   * @var long $CategoryID
   */
  public $CategoryID;
  /**
   * @var string $Status
   */
  public $Status;
}

class ExactTarget_Fields {
  /**
   * @var ExactTarget_DataExtensionField $Field
   */
  public $Field;
}

class ExactTarget_DataExtensionField {
  /**
   * @var int $Ordinal
   */
  public $Ordinal;
  /**
   * @var boolean $IsPrimaryKey
   */
  public $IsPrimaryKey;
  /**
   * @var ExactTarget_DataExtensionFieldType $FieldType
   */
  public $FieldType;
  /**
   * @var ExactTarget_DataExtension $DataExtension
   */
  public $DataExtension;
}

class ExactTarget_DataExtensionFieldType {
  const Text='Text';
  const Number='Number';
  const Date='Date';
  const Boolean='Boolean';
  const EmailAddress='EmailAddress';
  const Phone='Phone';
  const Decimal='Decimal';
  const Locale='Locale';
}

class ExactTarget_DateTimeUnitOfMeasure {
  const Days='Days';
  const Weeks='Weeks';
  const Months='Months';
  const Years='Years';
}

class ExactTarget_DataExtensionTemplate {
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var string $Description
   */
  public $Description;
}

class ExactTarget_DataExtensionObject {
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var ExactTarget_Keys $Keys
   */
  public $Keys;
}

class ExactTarget_Keys {
  /**
   * @var ExactTarget_APIProperty $Key
   */
  public $Key;
}

class ExactTarget_DataExtensionError {
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var integer $ErrorCode
   */
  public $ErrorCode;
  /**
   * @var string $ErrorMessage
   */
  public $ErrorMessage;
}

class ExactTarget_DataExtensionCreateResult {
  /**
   * @var string $ErrorMessage
   */
  public $ErrorMessage;
  /**
   * @var ExactTarget_KeyErrors $KeyErrors
   */
  public $KeyErrors;
  /**
   * @var ExactTarget_ValueErrors $ValueErrors
   */
  public $ValueErrors;
}

class ExactTarget_KeyErrors {
  /**
   * @var ExactTarget_DataExtensionError $KeyError
   */
  public $KeyError;
}

class ExactTarget_ValueErrors {
  /**
   * @var ExactTarget_DataExtensionError $ValueError
   */
  public $ValueError;
}

class ExactTarget_DataExtensionUpdateResult {
  /**
   * @var string $ErrorMessage
   */
  public $ErrorMessage;
  /**
   * @var ExactTarget_KeyErrors $KeyErrors
   */
  public $KeyErrors;
  /**
   * @var ExactTarget_ValueErrors $ValueErrors
   */
  public $ValueErrors;
}




class ExactTarget_DataExtensionDeleteResult {
  /**
   * @var string $ErrorMessage
   */
  public $ErrorMessage;
  /**
   * @var ExactTarget_KeyErrors $KeyErrors
   */
  public $KeyErrors;
}



class ExactTarget_FileType {
  const CSV='CSV';
  const TAB='TAB';
  const Other='Other';
}

class ExactTarget_ImportDefinitionSubscriberImportType {
  const Email='Email';
  const SMS='SMS';
}

class ExactTarget_ImportDefinitionUpdateType {
  const AddAndUpdate='AddAndUpdate';
  const AddAndDoNotUpdate='AddAndDoNotUpdate';
  const UpdateButDoNotAdd='UpdateButDoNotAdd';
  const Merge='Merge';
  const Overwrite='Overwrite';
  const ColumnBased='ColumnBased';
}

class ExactTarget_ImportDefinitionColumnBasedAction {
  /**
   * @var string $Value
   */
  public $Value;
  /**
   * @var ExactTarget_ImportDefinitionColumnBasedActionType $Action
   */
  public $Action;
}

class ExactTarget_ImportDefinitionColumnBasedActionType {
  const AddAndUpdate='AddAndUpdate';
  const AddButDoNotUpdate='AddButDoNotUpdate';
  const Delete='Delete';
  const Skip='Skip';
  const UpdateButDoNotAdd='UpdateButDoNotAdd';
}

class ExactTarget_ImportDefinitionFieldMappingType {
  const InferFromColumnHeadings='InferFromColumnHeadings';
  const MapByOrdinal='MapByOrdinal';
  const ManualMap='ManualMap';
}

class ExactTarget_FieldMap {
  /**
   * @var string $SourceName
   */
  public $SourceName;
  /**
   * @var int $SourceOrdinal
   */
  public $SourceOrdinal;
  /**
   * @var string $DestinationName
   */
  public $DestinationName;
}

class ExactTarget_ImportDefinitionAutoGenerateDestination {
  /**
   * @var ExactTarget_DataExtension $DataExtensionTarget
   */
  public $DataExtensionTarget;
  /**
   * @var boolean $ErrorIfExists
   */
  public $ErrorIfExists;
}

class ExactTarget_ImportDefinition {
  /**
   * @var boolean $AllowErrors
   */
  public $AllowErrors;
  /**
   * @var ExactTarget_APIObject $DestinationObject
   */
  public $DestinationObject;
  /**
   * @var ExactTarget_ImportDefinitionFieldMappingType $FieldMappingType
   */
  public $FieldMappingType;
  /**
   * @var ExactTarget_FieldMaps $FieldMaps
   */
  public $FieldMaps;
  /**
   * @var string $FileSpec
   */
  public $FileSpec;
  /**
   * @var ExactTarget_FileType $FileType
   */
  public $FileType;
  /**
   * @var ExactTarget_AsyncResponse $Notification
   */
  public $Notification;
  /**
   * @var ExactTarget_FileTransferLocation $RetrieveFileTransferLocation
   */
  public $RetrieveFileTransferLocation;
  /**
   * @var ExactTarget_ImportDefinitionSubscriberImportType $SubscriberImportType
   */
  public $SubscriberImportType;
  /**
   * @var ExactTarget_ImportDefinitionUpdateType $UpdateType
   */
  public $UpdateType;
  /**
   * @var int $MaxFileAge
   */
  public $MaxFileAge;
  /**
   * @var int $MaxFileAgeScheduleOffset
   */
  public $MaxFileAgeScheduleOffset;
  /**
   * @var int $MaxImportFrequency
   */
  public $MaxImportFrequency;
  /**
   * @var string $Delimiter
   */
  public $Delimiter;
  /**
   * @var int $HeaderLines
   */
  public $HeaderLines;
  /**
   * @var ExactTarget_ImportDefinitionAutoGenerateDestination $AutoGenerateDestination
   */
  public $AutoGenerateDestination;
  /**
   * @var string $ControlColumn
   */
  public $ControlColumn;
  /**
   * @var ExactTarget_ImportDefinitionColumnBasedActionType $ControlColumnDefaultAction
   */
  public $ControlColumnDefaultAction;
  /**
   * @var ExactTarget_ControlColumnActions $ControlColumnActions
   */
  public $ControlColumnActions;
  /**
   * @var string $EndOfLineRepresentation
   */
  public $EndOfLineRepresentation;
  /**
   * @var string $NullRepresentation
   */
  public $NullRepresentation;
  /**
   * @var boolean $StandardQuotedStrings
   */
  public $StandardQuotedStrings;
  /**
   * @var string $Filter
   */
  public $Filter;
  /**
   * @var ExactTarget_Locale $DateFormattingLocale
   */
  public $DateFormattingLocale;
}

class ExactTarget_FieldMaps {
  /**
   * @var ExactTarget_FieldMap $FieldMap
   */
  public $FieldMap;
}

class ExactTarget_ControlColumnActions {
  /**
   * @var ExactTarget_ImportDefinitionColumnBasedAction $ControlColumnAction
   */
  public $ControlColumnAction;
}

class ExactTarget_ImportDefinitionFieldMap {
  /**
   * @var string $SourceName
   */
  public $SourceName;
  /**
   * @var int $SourceOrdinal
   */
  public $SourceOrdinal;
  /**
   * @var string $DestinationName
   */
  public $DestinationName;
}

class ExactTarget_ImportResultsSummary {
  /**
   * @var string $ImportDefinitionCustomerKey
   */
  public $ImportDefinitionCustomerKey;
  /**
   * @var string $StartDate
   */
  public $StartDate;
  /**
   * @var string $EndDate
   */
  public $EndDate;
  /**
   * @var string $DestinationID
   */
  public $DestinationID;
  /**
   * @var int $NumberSuccessful
   */
  public $NumberSuccessful;
  /**
   * @var int $NumberDuplicated
   */
  public $NumberDuplicated;
  /**
   * @var int $NumberErrors
   */
  public $NumberErrors;
  /**
   * @var int $TotalRows
   */
  public $TotalRows;
  /**
   * @var string $ImportType
   */
  public $ImportType;
  /**
   * @var string $ImportStatus
   */
  public $ImportStatus;
  /**
   * @var int $TaskResultID
   */
  public $TaskResultID;
}

class ExactTarget_FilterDefinition {
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var string $Description
   */
  public $Description;
  /**
   * @var ExactTarget_APIObject $DataSource
   */
  public $DataSource;
  /**
   * @var ExactTarget_FilterPart $DataFilter
   */
  public $DataFilter;
}

class ExactTarget_GroupDefinition {
}

class ExactTarget_FileTransferActivity {
}

class ExactTarget_ListSend {
  /**
   * @var int $SendID
   */
  public $SendID;
  /**
   * @var ExactTarget_List $List
   */
  public $List;
  /**
   * @var int $Duplicates
   */
  public $Duplicates;
  /**
   * @var int $InvalidAddresses
   */
  public $InvalidAddresses;
  /**
   * @var int $ExistingUndeliverables
   */
  public $ExistingUndeliverables;
  /**
   * @var int $ExistingUnsubscribes
   */
  public $ExistingUnsubscribes;
  /**
   * @var int $HardBounces
   */
  public $HardBounces;
  /**
   * @var int $SoftBounces
   */
  public $SoftBounces;
  /**
   * @var int $OtherBounces
   */
  public $OtherBounces;
  /**
   * @var int $ForwardedEmails
   */
  public $ForwardedEmails;
  /**
   * @var int $UniqueClicks
   */
  public $UniqueClicks;
  /**
   * @var int $UniqueOpens
   */
  public $UniqueOpens;
  /**
   * @var int $NumberSent
   */
  public $NumberSent;
  /**
   * @var int $NumberDelivered
   */
  public $NumberDelivered;
  /**
   * @var int $Unsubscribes
   */
  public $Unsubscribes;
  /**
   * @var int $MissingAddresses
   */
  public $MissingAddresses;
  /**
   * @var string $PreviewURL
   */
  public $PreviewURL;
  /**
   * @var ExactTarget_Link $Links
   */
  public $Links;
  /**
   * @var ExactTarget_TrackingEvent $Events
   */
  public $Events;
}

class ExactTarget_LinkSend {
  /**
   * @var int $SendID
   */
  public $SendID;
  /**
   * @var ExactTarget_Link $Link
   */
  public $Link;
}

class ExactTarget_ObjectExtension {
  /**
   * @var string $Type
   */
  public $Type;
  /**
   * @var ExactTarget_Properties $Properties
   */
  public $Properties;
}

class ExactTarget_Properties {
  /**
   * @var ExactTarget_APIProperty $Property
   */
  public $Property;
}

class ExactTarget_PublicKeyManagement {
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var base64Binary $Key
   */
  public $Key;
}

class ExactTarget_SecurityObject {
}

class ExactTarget_Certificate {
}

class ExactTarget_SystemStatusOptions {
}

class ExactTarget_SystemStatusRequestMsg {
  /**
   * @var ExactTarget_SystemStatusOptions $Options
   */
  public $Options;
}

class ExactTarget_SystemStatusResult {
  /**
   * @var ExactTarget_SystemStatusType $SystemStatus
   */
  public $SystemStatus;
  /**
   * @var ExactTarget_Outages $Outages
   */
  public $Outages;
}

class ExactTarget_Outages {
  /**
   * @var ExactTarget_SystemOutage $Outage
   */
  public $Outage;
}

class ExactTarget_SystemStatusResponseMsg {
  /**
   * @var ExactTarget_Results $Results
   */
  public $Results;
  /**
   * @var string $OverallStatus
   */
  public $OverallStatus;
  /**
   * @var string $OverallStatusMessage
   */
  public $OverallStatusMessage;
  /**
   * @var string $RequestID
   */
  public $RequestID;
}



class ExactTarget_SystemStatusType {
  const OK='OK';
  const UnplannedOutage='UnplannedOutage';
  const InMaintenance='InMaintenance';
}

class ExactTarget_SystemOutage {
}

class ExactTarget_Authentication {
}

class ExactTarget_UsernameAuthentication {
  /**
   * @var string $UserName
   */
  public $UserName;
  /**
   * @var string $PassWord
   */
  public $PassWord;
}

class ExactTarget_ResourceSpecification {
  /**
   * @var string $URN
   */
  public $URN;
  /**
   * @var ExactTarget_Authentication $Authentication
   */
  public $Authentication;
}

class ExactTarget_Portfolio {
  /**
   * @var ExactTarget_ResourceSpecification $Source
   */
  public $Source;
  /**
   * @var int $CategoryID
   */
  public $CategoryID;
  /**
   * @var string $FileName
   */
  public $FileName;
  /**
   * @var string $DisplayName
   */
  public $DisplayName;
  /**
   * @var string $Description
   */
  public $Description;
  /**
   * @var string $TypeDescription
   */
  public $TypeDescription;
  /**
   * @var boolean $IsUploaded
   */
  public $IsUploaded;
  /**
   * @var boolean $IsActive
   */
  public $IsActive;
  /**
   * @var int $FileSizeKB
   */
  public $FileSizeKB;
  /**
   * @var int $ThumbSizeKB
   */
  public $ThumbSizeKB;
  /**
   * @var int $FileWidthPX
   */
  public $FileWidthPX;
  /**
   * @var int $FileHeightPX
   */
  public $FileHeightPX;
  /**
   * @var string $FileURL
   */
  public $FileURL;
  /**
   * @var string $ThumbURL
   */
  public $ThumbURL;
  /**
   * @var dateTime $CacheClearTime
   */
  public $CacheClearTime;
  /**
   * @var string $CategoryType
   */
  public $CategoryType;
}

class ExactTarget_Layout {
  /**
   * @var string $LayoutName
   */
  public $LayoutName;
}

class ExactTarget_QueryDefinition {
  /**
   * @var string $QueryText
   */
  public $QueryText;
  /**
   * @var string $TargetType
   */
  public $TargetType;
  /**
   * @var ExactTarget_InteractionBaseObject $DataExtensionTarget
   */
  public $DataExtensionTarget;
  /**
   * @var string $TargetUpdateType
   */
  public $TargetUpdateType;
  /**
   * @var string $FileSpec
   */
  public $FileSpec;
  /**
   * @var string $FileType
   */
  public $FileType;
  /**
   * @var string $Status
   */
  public $Status;
  /**
   * @var int $CategoryID
   */
  public $CategoryID;
}

class ExactTarget_IntegrationProfile {
  /**
   * @var string $ProfileID
   */
  public $ProfileID;
  /**
   * @var string $SubscriberKey
   */
  public $SubscriberKey;
  /**
   * @var string $ExternalID
   */
  public $ExternalID;
  /**
   * @var string $ExternalType
   */
  public $ExternalType;
}

class ExactTarget_IntegrationProfileDefinition {
  /**
   * @var string $ProfileID
   */
  public $ProfileID;
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var string $Description
   */
  public $Description;
  /**
   * @var int $ExternalSystemType
   */
  public $ExternalSystemType;
}

class ExactTarget_ReplyMailManagementConfiguration {
  /**
   * @var string $EmailDisplayName
   */
  public $EmailDisplayName;
  /**
   * @var string $ReplySubdomain
   */
  public $ReplySubdomain;
  /**
   * @var string $EmailReplyAddress
   */
  public $EmailReplyAddress;
  /**
   * @var boolean $DNSRedirectComplete
   */
  public $DNSRedirectComplete;
  /**
   * @var boolean $DeleteAutoReplies
   */
  public $DeleteAutoReplies;
  /**
   * @var boolean $SupportUnsubscribes
   */
  public $SupportUnsubscribes;
  /**
   * @var boolean $SupportUnsubKeyword
   */
  public $SupportUnsubKeyword;
  /**
   * @var boolean $SupportUnsubscribeKeyword
   */
  public $SupportUnsubscribeKeyword;
  /**
   * @var boolean $SupportRemoveKeyword
   */
  public $SupportRemoveKeyword;
  /**
   * @var boolean $SupportOptOutKeyword
   */
  public $SupportOptOutKeyword;
  /**
   * @var boolean $SupportLeaveKeyword
   */
  public $SupportLeaveKeyword;
  /**
   * @var boolean $SupportMisspelledKeywords
   */
  public $SupportMisspelledKeywords;
  /**
   * @var boolean $SendAutoReplies
   */
  public $SendAutoReplies;
  /**
   * @var string $AutoReplySubject
   */
  public $AutoReplySubject;
  /**
   * @var string $AutoReplyBody
   */
  public $AutoReplyBody;
  /**
   * @var string $ForwardingAddress
   */
  public $ForwardingAddress;
}

class ExactTarget_FileTrigger {
  /**
   * @var string $ExternalReference
   */
  public $ExternalReference;
  /**
   * @var string $Type
   */
  public $Type;
  /**
   * @var string $Status
   */
  public $Status;
  /**
   * @var string $StatusMessage
   */
  public $StatusMessage;
  /**
   * @var string $RequestParameterDetail
   */
  public $RequestParameterDetail;
  /**
   * @var string $ResponseControlManifest
   */
  public $ResponseControlManifest;
  /**
   * @var string $FileName
   */
  public $FileName;
  /**
   * @var string $Description
   */
  public $Description;
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var dateTime $LastPullDate
   */
  public $LastPullDate;
  /**
   * @var dateTime $ScheduledDate
   */
  public $ScheduledDate;
  /**
   * @var boolean $IsActive
   */
  public $IsActive;
  /**
   * @var string $FileTriggerProgramID
   */
  public $FileTriggerProgramID;
}

class ExactTarget_FileTriggerTypeLastPull {
  /**
   * @var string $ExternalReference
   */
  public $ExternalReference;
  /**
   * @var string $Type
   */
  public $Type;
  /**
   * @var dateTime $LastPullDate
   */
  public $LastPullDate;
}

class ExactTarget_ProgramManifestTemplate {
  /**
   * @var string $Type
   */
  public $Type;
  /**
   * @var string $OperationType
   */
  public $OperationType;
  /**
   * @var string $Content
   */
  public $Content;
}

class ExactTarget_SubscriberAddress {
  /**
   * @var string $AddressType
   */
  public $AddressType;
  /**
   * @var string $Address
   */
  public $Address;
  /**
   * @var ExactTarget_Statuses $Statuses
   */
  public $Statuses;
}

class ExactTarget_Statuses {
  /**
   * @var ExactTarget_AddressStatus $Status
   */
  public $Status;
}

class ExactTarget_SMSAddress {
  /**
   * @var string $Carrier
   */
  public $Carrier;
}

class ExactTarget_EmailAddress {
  /**
   * @var ExactTarget_EmailType $Type
   */
  public $Type;
}

class ExactTarget_AddressStatus {
  /**
   * @var ExactTarget_SubscriberAddressStatus $Status
   */
  public $Status;
}

class ExactTarget_SubscriberAddressStatus {
  const OptedIn='OptedIn';
  const OptedOut='OptedOut';
  const InActive='InActive';
}

class ExactTarget_Publication {
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var boolean $IsActive
   */
  public $IsActive;
  /**
   * @var ExactTarget_SendClassification $SendClassification
   */
  public $SendClassification;
  /**
   * @var ExactTarget_Subscribers $Subscribers
   */
  public $Subscribers;
  /**
   * @var int $Category
   */
  public $Category;
}


class ExactTarget_PublicationSubscriber {
  /**
   * @var ExactTarget_Publication $Publication
   */
  public $Publication;
  /**
   * @var ExactTarget_Subscriber $Subscriber
   */
  public $Subscriber;
}

class ExactTarget_PlatformApplication {
  /**
   * @var ExactTarget_PlatformApplicationPackage $Package
   */
  public $Package;
  /**
   * @var ExactTarget_PlatformApplicationPackage $Packages
   */
  public $Packages;
  /**
   * @var ExactTarget_ResourceSpecification $ResourceSpecification
   */
  public $ResourceSpecification;
  /**
   * @var string $DeveloperVersion
   */
  public $DeveloperVersion;
}

class ExactTarget_PlatformApplicationPackage {
  /**
   * @var ExactTarget_ResourceSpecification $ResourceSpecification
   */
  public $ResourceSpecification;
  /**
   * @var ExactTarget_PublicKeyManagement $SigningKey
   */
  public $SigningKey;
  /**
   * @var boolean $IsUpgrade
   */
  public $IsUpgrade;
  /**
   * @var string $DeveloperVersion
   */
  public $DeveloperVersion;
}

class ExactTarget_SuppressionListDefinition {
  /**
   * @var string $Name
   */
  public $Name;
  /**
   * @var long $Category
   */
  public $Category;
  /**
   * @var string $Description
   */
  public $Description;
  /**
   * @var ExactTarget_Contexts $Contexts
   */
  public $Contexts;
  /**
   * @var ExactTarget_Fields $Fields
   */
  public $Fields;
}

class ExactTarget_Contexts {
  /**
   * @var ExactTarget_SuppressionListContext $Context
   */
  public $Context;
}



class ExactTarget_SuppressionListContext {
  /**
   * @var ExactTarget_SuppressionListContextEnum $Context
   */
  public $Context;
  /**
   * @var ExactTarget_SendClassificationTypeEnum $SendClassificationType
   */
  public $SendClassificationType;
  /**
   * @var ExactTarget_SendClassification $SendClassification
   */
  public $SendClassification;
  /**
   * @var ExactTarget_Send $Send
   */
  public $Send;
  /**
   * @var ExactTarget_SuppressionListDefinition $Definition
   */
  public $Definition;
}

class ExactTarget_SuppressionListContextEnum {
  const Enterprise='Enterprise';
  const BusinessUnit='BusinessUnit';
  const SendClassification='SendClassification';
  const Send='Send';
  const _Global='Global';
}

class ExactTarget_SuppressionListData {
  /**
   * @var ExactTarget_Properties $Properties
   */
  public $Properties;
}
