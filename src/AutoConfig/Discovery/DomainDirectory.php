<?php

namespace FideloSoftware\Mailing\AutoConfig\Discovery;

use FideloSoftware\Mailing\AutoConfig\Interfaces\XmlDiscovery;

class DomainDirectory extends XmlDiscovery {

	protected function getUrl() : string {
		return 'https://{domain}/.well-known/autoconfig/mail/config-v1.1.xml';
	}

}
