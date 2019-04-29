<?php

namespace FideloSoftware\Mailing\AutoConfig\Discovery;

use FideloSoftware\Mailing\AutoConfig\Interfaces\DiscoveryObject;
use FideloSoftware\Mailing\AutoConfig\Discovery;
use FideloSoftware\Mailing\AutoConfig\Config;

class DnsResolve implements DiscoveryObject {
	
	/**
	 * tries to find mailserver config based on domain mx records
	 * 
	 * @param string $sDomain
	 * @return \FideloSoftware\Mailing\AutoConfig\Config|null
	 */
	public function discover(string $sDomain) : ?Config {
	
		$aRecords = [];
		
		if(!dns_get_mx($sDomain, $aRecords)) return null;
		
		foreach($aRecords as $sRecord) {
			
			$aRecordData = explode('.', $sRecord);
			$sRecordLast = array_pop($aRecordData);
			$sRecordForelast = array_pop($aRecordData);
	
			// only the last second entries will be used as record domain
			$sRecordDomain = implode('.', [$sRecordForelast, $sRecordLast]);		
			// run through discovery objects to find config for record domain
			if(null !== $oConfig = $this->run([
				Discovery\ISPDB::class,
				Discovery\DomainServer::class,
				Discovery\DomainDirectory::class,
			], $sRecordDomain)) {
				return $oConfig;
			}
		}
		
		return null;
	}

	/**
	 * Run stack of auto discovery classes (stops on first match)
	 * 
	 * @param array|string $mStack
	 * @param string $sDomain
	 * @return \FideloSoftware\Mailing\AutoConfig\Config|null
	 */
	public function run($mStack, string $sDomain) {
		
		if(!is_array($mStack)) $mStack = [$mStack];
		
		foreach($mStack as $sDiscoverClass) {			
			if(null !== $oConfig = (new $sDiscoverClass)->discover($sDomain)) {
				return $oConfig;
			}			
		}
		
		return null;
	}
}
