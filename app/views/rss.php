<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	
	$livesite =base_url();

/** PHP 5 **/

	$dom = new DOMDocument('1.0', 'iso-8859-1');

	$rss = $dom->appendChild(new DOMElement('rss'));
	$attr = $rss->setAttributeNode(new DOMAttr('version', '0.91'));
	
	$channel = $rss->appendChild(new DOMElement('channel'));
	$title = $channel->appendchild(new DOMElement('title', "New Alumni Record"));
	$description = $channel->appendchild(new DOMElement('description', "Record of new alumni entry by questionnaire"));
	
	foreach($rows as $row) {
		$item = $channel->appendchild(new DOMElement('item'));
		$item->appendchild(new DOMElement("title", htmlentities($row->NAME)));
		$item->appendchild(new DOMElement("link", htmlentities($livesite.'adet/'.$row->AID.'.html')));
		$item->appendchild(new DOMElement("description", htmlentities($row->COMMUNITY)));
	}

	header("Content-Type: application/rss+xml");
	echo $dom->saveXML();
?>