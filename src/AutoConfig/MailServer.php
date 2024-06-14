<?php

namespace FideloSoftware\Mailing\AutoConfig;

use FideloSoftware\Mailing\Email;
use FideloSoftware\Mailing\Traits\RunStack;

class MailServer {
	use RunStack;

	/**
	 * Discover mail server settings for an email object. If no external config
	 * could be found we'll try to guess settings
	 * 
	 * @param \FideloSoftware\Mailing\Email $oEmail
	 * @return \FideloSoftware\Mailing\AutoConfig\Config
	 */
	public function discover(Email $oEmail) : Config {
		// get domain part of the email
		$sDomain = $oEmail->getDomain();
		
		return $this->run([
			// external sources
			Discovery\ISPDB::class,
			Discovery\DomainServer::class,
			Discovery\DomainDirectory::class,
			// dns resolve (mx records)
			Discovery\DnsResolve::class,
			// autodiscover CNAME
			Discovery\Autodiscover::class,
			// at least we try to guess the config
			Discovery\Guess::class,
		], $sDomain);
	}
	
	/**
	 * Guess config settings of the domain
	 * 
	 * @param string $sDomain
	 * @return \FideloSoftware\Mailing\AutoConfig\Config
	 */
	public function guess(string $sDomain) : Config {
		return $this->run(Discovery\Guess::class, $sDomain);
	}
	
	/**
	 * Check ISPDB database for domain settings (Thunderbird)
	 * 
	 * Also see: https://autoconfig.thunderbird.net/v1.1/
	 * 
	 * @param string $sDomain
	 * @return \FideloSoftware\Mailing\AutoConfig\Config|null
	 */
	public function getISPDBAutoConfig(string $sDomain) : ?Config {
		return $this->run(Discovery\ISPDB::class, $sDomain);
	}
	
	/**
	 * Search config on domain autoconfig server
	 * 
	 * Url: https://autoconfig.{domain}/mail/config-v1.1.xml
	 * 
	 * @param string $sDomain
	 * @return \FideloSoftware\Mailing\AutoConfig\Config|null
	 */
	public function getDomainServerAutoConfig(string $sDomain) : ?Config {
		return $this->run(Discovery\DomainServer::class, $sDomain);
	}
	
	/**
	 * Search config in sub directory of the domain
	 * 
	 * Directory: https://{domain}/.well-known/autoconfig/mail/config-v1.1.xml
	 * 
	 * @param string $sDomain
	 * @return \FideloSoftware\Mailing\AutoConfig\Config|null
	 */
	public function getDomainDirectoryAutoConfig(string $sDomain) : ?Config {
		return $this->run(Discovery\DomainDirectory::class, $sDomain);
	}

}

