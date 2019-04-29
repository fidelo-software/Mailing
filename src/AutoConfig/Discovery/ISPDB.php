<?php

namespace FideloSoftware\Mailing\AutoConfig\Discovery;

use FideloSoftware\Mailing\AutoConfig\Interfaces\XmlDiscovery;

class ISPDB extends XmlDiscovery {

	protected function getUrl() : string {
		return 'https://autoconfig.thunderbird.net/v1.1/{domain}';
	}

}
