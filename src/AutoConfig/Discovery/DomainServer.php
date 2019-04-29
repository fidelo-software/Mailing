<?php

namespace FideloSoftware\Mailing\AutoConfig\Discovery;

use FideloSoftware\Mailing\AutoConfig\Interfaces\XmlDiscovery;

class DomainServer extends XmlDiscovery {

	protected function getUrl() : string {
		return 'https://autoconfig.{domain}/mail/config-v1.1.xml';
	}

}
