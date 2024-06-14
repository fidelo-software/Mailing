<?php

namespace FideloSoftware\Mailing\AutoConfig\Discovery;

use FideloSoftware\Mailing\AutoConfig\Config;

class Autodiscover extends DnsResolve {

	/**
	 * Check autodiscover.{domain} CNAME entry
	 *
	 * @param string $sDomain
	 * @return Config|null
	 */
	public function discover(string $sDomain) : ?Config {

		$aRecords = dns_get_record('autodiscover.'.$sDomain, DNS_CNAME);

		if (is_array($aRecords)) {
			return $this->runRecords(array_column($aRecords, 'target'));
		}

		return null;
	}

}
