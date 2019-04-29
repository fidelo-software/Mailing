<?php

namespace FideloSoftware\Mailing\AutoConfig\Interfaces;

use SimpleXMLElement;
use FideloSoftware\Mailing\AutoConfig\Factory\ConfigFactory;
use FideloSoftware\Mailing\AutoConfig\Config;

abstract class XmlDiscovery implements DiscoveryObject {
	
	const REQUEST_CONNECTION_TIMEOUT = 5;
	
	const REQUEST_TIMEOUT = 5;
	
	abstract protected function getUrl() : string;
	
	/**
	 * Parse XML file of given url
	 * 
	 * @param string $sDomain
	 * @return \FideloSoftware\Mailing\AutoConfig\Config|null
	 */
	public function discover(string $sDomain) : ?Config {
		
		$oXml = $this->getXml(str_replace('{domain}', $sDomain, $this->getUrl()));
		
		if($oXml instanceof SimpleXMLElement) {
			// build config object
			return (new ConfigFactory())
						->buildFromXml($oXml);
		}
		
		return null;
	}

	/**
	 * Request file 
	 * 
	 * @param string $sUrl
	 * @return \SimpleXMLElement|null
	 */
	protected function getXml(string $sUrl) : ?SimpleXMLElement {
		
		$hCurl = curl_init($sUrl);
		
		curl_setopt($hCurl, CURLOPT_HEADER, false);
		curl_setopt($hCurl, CURLOPT_RETURNTRANSFER, true);		
		curl_setopt($hCurl, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($hCurl, CURLOPT_CONNECTTIMEOUT, self::REQUEST_CONNECTION_TIMEOUT); 
		curl_setopt($hCurl, CURLOPT_TIMEOUT, self::REQUEST_TIMEOUT);

		$sResponse = curl_exec($hCurl);

		$iHttpStatusCode = (int) curl_getinfo($hCurl, CURLINFO_HTTP_CODE);
		$sResponseContentType = curl_getinfo($hCurl, CURLINFO_CONTENT_TYPE);
		
		curl_close($hCurl);

		if(
			$iHttpStatusCode === 200 && 
			in_array($sResponseContentType, ['text/xml', 'application/xml'])
		) {
			return new SimpleXMLElement($sResponse);
		}
		
		return null;
	}
	
}
