<?php
// oauth2callback/index.php


require('../settings.php');

require_once('../classes/Google_OAuth2_Token.class.php');
require_once('../classes/Google_Timeline.class.php');
	
/**
 * the OAuth server should have brought us to this page with a $_GET['code']
 */
if(isset($_GET['code'])) {
    // try to get an access token
    $code = $_GET['code'];
 
	// authenticate the user
	$Google_OAuth2_Token = new Google_OAuth2_Token();
	$Google_OAuth2_Token->code = $code;
	$Google_OAuth2_Token->client_id = $settings['oauth2']['oauth2_client_id'];
	$Google_OAuth2_Token->client_secret = $settings['oauth2']['oauth2_secret'];
	$Google_OAuth2_Token->redirect_uri = $settings['oauth2']['oauth2_redirect'];
	$Google_OAuth2_Token->grant_type = "authorization_code";

	try {
		$Google_OAuth2_Token->authenticate();
	} catch (Exception $e) {
		// handle this exception
		print_r($e);
	}

	// A user just logged in.  Let's figure out where their Glass is
	if ($Google_OAuth2_Token->authenticated) {
		
		$Google_Timeline = new Google_Timeline($Google_OAuth2_Token);
		$Google_Timeline->list_items();			
		
		
	}
}

?>
<? if ($Google_Timeline->TimelineItems) { ?>
<? $numTimelineItems = count($Google_Timeline->TimelineItems); ?>
Found <?= $numTimelineItems; ?> Timeline Item<? if ($numTimelineItems !== 1) { ?>s<? } ?>:
<? foreach ($Google_Timeline->TimelineItems as $TimelineItem) { ?>
	<h2>Timeline Item</h2>
	<dl>
		<dt>ID</dt>
		<dd><?= $TimelineItem->id; ?></dd> 
		
		<dt>Created</dt>
		<dd><?= $TimelineItem->created; ?></dd>
		
		<? if ($TimelineItem->recipients) { ?>
		<dt>Recipients</dt>
		<? $numRecipients = count($TimelineItem->recipients); ?>
		Sent to <?= $numRecipients; ?> recipient<? if ($numRecipients !== 1) { ?>s<? } ?>:
		<? foreach ($TimelineItem->recipients as $Recipient) { ?>
			<dd><?= $Recipient->displayName; ?></dd>
		<? } ?>
		<? } ?>
		
		<? if ($TimelineItem->html) { ?>
			<dd><?= $TimelineItem->html; ?></dd>
		<? } ?>
		
		<? if ($TimelineItem->text) { ?>
			<dd><?= $TimelineItem->text; ?></dd>
		<? } ?>
			
		<? if ($TimelineItem->attachments) { ?>
		<dt>Attachments</dt>
		<? $numAttachments = count($TimelineItem->attachments); ?>
		Found <?= $numAttachments; ?> attachment<? if ($numAttachments !== 1) { ?>s<? } ?>:
		<? foreach ($TimelineItem->attachments as $Attachment) { ?>	
			<dd><?= $Attachment->id; ?>: <?= $Attachment->contentType; ?></dd>
		<? } ?>
		<? } ?>
	</dl>
<? } ?>
<? } ?>
<h1>Google Timeline Item:</h1>
<dl>
<dt>ID</dt>
<dd><?= $Google_Timeline->TimelineItems[0]->id; ?></dd>
<dt>SelfLink</dt>
<dd><?= $Google_Timeline->TimelineItems[0]->selfLink; ?></dd>
<dt>Display Time</dt>
<dd><?= $Google_Timeline->TimelineItems[0]->displayTime; ?></dd>
<dt>Attachment</dt>
<dd><img alt="image" src="data:<?= $imagetype; ?>;base64,<?= $imagedata; ?>" /></dd>
</dl>
<?
/* */
?>