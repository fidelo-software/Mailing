<?php

namespace FideloSoftware\Mailing\AutoConfig\Discovery;

use FideloSoftware\Mailing\AutoConfig\Interfaces\DiscoveryObject;
use FideloSoftware\Mailing\AutoConfig\Discovery;
use FideloSoftware\Mailing\AutoConfig\Config;
use FideloSoftware\Mailing\Traits\RunStack;

class DnsResolve implements DiscoveryObject {
	use RunStack;

	/**
	 * tries to find mailserver config based on domain mx records
	 * 
	 * @param string $sDomain
	 * @return \FideloSoftware\Mailing\AutoConfig\Config|null
	 */
	public function discover(string $sDomain) : ?Config {
	
		$aRecords = [];
		
		if(!dns_get_mx($sDomain, $aRecords)) return null;
		
		return $this->runRecords($aRecords);
	}

	protected function runRecords(array $aRecords) : ?Config {

		foreach($aRecords as $sRecord) {

			$sRecordDomain = $this->getRecordDomain($sRecord);

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

	protected function getRecordDomain($sRecord) {

		$aRecordData = explode('.', $sRecord);
		$sRecordLast = array_pop($aRecordData);
		$sRecordForelast = array_pop($aRecordData);

		// only the last second entries will be used as record domain
		$sRecordDomain = implode('.', [$sRecordForelast, $sRecordLast]);

		// z.B. bei Google kommt hier eine großgeschriebene Domain GOOGLE.COM raus. Das klappt dann nicht.
		return strtolower($sRecordDomain);
	}

}
