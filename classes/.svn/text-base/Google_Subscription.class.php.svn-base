<?php
// classes/Google_Userinfo.class.php
require_once('HttpPost.class.php');
require_once('Google_SubscriptionList_Item.class.php');

/**
 * Get the Google+ user account from
 * https://www.googleapis.com/oauth2/v1/userinfo
 * 
 * Requires that user has been OAuth authenticated
 */
class Google_Subscription {
	
	const URL = 'https://www.googleapis.com/mirror/v1/subscriptions';
	public $fetched = false;
	
	const OPERATION_UPDATE = "UPDATE";
	const OPERATION_INSERT = "INSERT";
	const OPERATION_DELETE = "DELETE";
	
	
	// this is the scope required to access the userinfo
	public static $scopes = array(
		'glass.timeline' => 'https://www.googleapis.com/auth/glass.timeline',
		'glass.location' => 'https://www.googleapis.com/auth/glass.location'
	); 
	
	// we can only grab userinfo from an authenticated user
	public $Google_OAuth2_Token;
	
	// these are the variables we are sending
	public $kind = "mirror#subscription",
		$collection = "timeline",
		$userToken,
		$operation = array(), // OPERATION_UPDATE, OPERATION_INSERT, OPERATION_DELETE
		$callbackUrl;
	
	
	// these are the variables that will come back from the server
	public $id,
		$timestamp,
		$latitude,
		$longitude,
		$accuracy;
//		$kind;

	
		
	/**
	 * Use the authenticated Google_OAuth2_Token
	 */
	public function __construct($Google_OAuth2_Token) {
		$this->Google_OAuth2_Token = $Google_OAuth2_Token;
	}
	
	public function delete() {
		
	}
	
	/**
	 * Get the list of subscriptions registered to 
	 * the authenticated user
	 */
	public function list_subscriptions() {
		// we will be stending the OAuth2 access_token through the HTTP headers
		$headers = array(
			'Authorization: '.$this->Google_OAuth2_Token->token_type.' '.$this->Google_OAuth2_Token->access_token
		);
		
		$this->HttpPost = new HttpPost(self::URL);
		$this->HttpPost->setHeaders( $headers );
		
		if ($this->Google_OAuth2_Token->authenticated) {
			$this->HttpPost->send();
		    $response = json_decode($this->HttpPost->httpResponse);
		
		} else {
			throw new Exception ("Google_OAuth2_Token needs to be authenticated before you can fetch locations.");
		}
	
		
		
		// is there an error here?
		if ($response->error) {
			throw new Exception("The server reported an error: '".$response->error->errors[0]->message."'");
		} else {
			if ($response->kind == 'mirror#subscriptionsList') {
				foreach ($response->items as $subscriptionItem) {
					$Subscription = new Google_SubscriptionList_Item();
					$Subscription->fromJSONObject($subscriptionItem);
				}
				$Subscriptions[] = $Subscription;
			}
			print_r($Subscriptions);
			
			$this->fetched = true;
		}
		
	}
	/**
	 * Subscribe to a user's timeline changes
	 */
	public function subscribe() {
		$postData = array(
			'collection' => $this->collection,
			'userToken' => $this->userToken,
			'operation' => $this->operation,
			'callbackUrl' => $this->callbackUrl
		);
		$json = json_encode($postData);
		
		
		// we will be stending the OAuth2 access_token through the HTTP headers
		$headers = array(
			'Authorization: '.$this->Google_OAuth2_Token->token_type.' '.$this->Google_OAuth2_Token->access_token,
			'Content-Type: application/json',
			'Content-length: '. strlen($json)
		);
		
		$this->HttpPost = new HttpPost(self::URL);
		$this->HttpPost->setHeaders( $headers );
		$this->HttpPost->setRawPostData( $json );
		
		if ($this->Google_OAuth2_Token->authenticated) {
			$this->HttpPost->send();
		    $response = json_decode($this->HttpPost->httpResponse);
		
		} else {
			throw new Exception ("Google_OAuth2_Token needs to be authenticated before you can subscribe.");
		}

		
		
		// is there an error here?
		if ($response->error) {
			print_r($response);
			throw new Exception("The server reported an error: '".$response->error->errors[0]->message."'");
		} else {
			print_r($this);
			print_r($response);
			$this->fetched = true;
		}
	}
	
}

?>