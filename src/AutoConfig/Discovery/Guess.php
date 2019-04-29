<?php

namespace FideloSoftware\Mailing\AutoConfig\Discovery;

use FideloSoftware\Mailing\AutoConfig\Interfaces\DiscoveryObject;
use FideloSoftware\Mailing\AutoConfig\Config;

class Guess implements DiscoveryObject {
	
	/**
	 * Guess mail server config
	 * 
	 * @todo define more precisely
	 * 
	 * @param string $sDomain
	 * @return Config|null
	 */
	public function discover(string $sDomain) : ?Config {
		
		$oConfig = new Config('Guessed Provider');
		
		$oIncomingServer = (new \FideloSoftware\Mailing\AutoConfig\Config\IncomingServer('mail.'.$sDomain, 995, 'pop3'))
				->setSocketType('SSL')
				->setAuthentication('password-cleartext')
				->setUserName('%EMAILADDRESS%');
		
		$oConfig->addIncomingServer($oIncomingServer);
		
		$oOutgoingServer = (new \FideloSoftware\Mailing\AutoConfig\Config\OutgoingServer('mail.'.$sDomain, 587, 'smtp'))
				->setSocketType('STARTTLS')
				->setAuthentication('password-cleartext')
				->setUserName('%EMAILADDRESS%');
		
		$oConfig->setOutgoingServer($oOutgoingServer);
				
		return $oConfig;
	}

}
