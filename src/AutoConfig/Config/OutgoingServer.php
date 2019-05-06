<?php

namespace FideloSoftware\Mailing\AutoConfig\Config;

class OutgoingServer extends AbstractServer {
	
	const SMTP = 'smtp';
	
	/**
	 * @param string $sHostname
	 * @param int $iPort
	 * @param string $sType
	 */
	public function __construct(string $sHostname, int $iPort, string $sType) {
		$this->sType = $sType;
		$this->sHostname = $sHostname;
		$this->iPort = $iPort;
	}
	
}

