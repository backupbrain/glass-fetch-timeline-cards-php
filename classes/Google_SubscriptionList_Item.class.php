<?php
// classes/Google_Userinfo.class.php
require_once('HttpPost.class.php');

/**
 * Get the Google+ user account from
 * https://www.googleapis.com/oauth2/v1/userinfo
 * 
 * Requires that user has been OAuth authenticated
 */
class Google_SubscriptionList_Item {
	
	const OPERATION_UPDATE = "UPDATE";
	const OPERATION_INSERT = "INSERT";
	const OPERATION_DELETE = "DELETE";
	
	const COLLECTION_TIMELINE = "timeline";
	const COLLECTION_LOCATIONS = "locations";
		
	
	// these are the variables that will come back from the server
	public $id,
		$timestamp,
		$latitude,
		$longitude,
		$accuracy,
		$kind = "mirror#subscription",
		$collection,
		$operation = array(), // OPERATION_UPDATE, OPERATION_INSERT, OPERATION_DELETE
		$callbackUrl,
		$userToken,
		$updated;


	public function fromJSONObject($jsonObject) {
		$this->kind = $jsonObject->kind;
		$this->id = $jsonObject->id;
		$this->updated = $jsonObject->updated;
		$this->collection = $jsonObject->collection;
		$this->operation = $jsonObject->operation;
		$this->callbackUrl = $jsonObject->callbackUrl;
		$this->userToken = $jsonObject->userToken;
		
		
		$this->timestamp = $jsonObject->timestamp;
		$this->latitude = $jsonObject->latitude;
		$this->longitude = $jsonObject->longitude;
		$this->accuracy = $jsonObject->accuracy;
	}
	
	
	public function fromJSON($json) {
		$this->fromJSONObject(json_decode($json));
	}
	
}

?>