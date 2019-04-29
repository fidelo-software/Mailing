<?php

namespace FideloSoftware\Mailing\AutoConfig\Interfaces;

use FideloSoftware\Mailing\AutoConfig\Config;

interface DiscoveryObject {
	
	public function discover(string $sDomain) : ?Config;
	
}

