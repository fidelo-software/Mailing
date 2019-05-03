<?php

namespace FideloSoftware\Mailing\AutoConfig;

use FideloSoftware\Mailing\AutoConfig\Config\IncomingServer;
use FideloSoftware\Mailing\AutoConfig\Config\OutgoingServer;

class Config {

	/**
	 * @var string 
	 */
	protected $sProvider;
	/**
	 * @var string 
	 */
	protected $bVerified = false;
	/**
	 * @var \FideloSoftware\Mailing\AutoConfig\Config\IncomingServer[] 
	 */
	protected $aIncomingServers = [];
	/**
	 * @var \FideloSoftware\Mailing\AutoConfig\Config\OutgoingServer 
	 */
	protected $oOutgoingServer;
	
	/**
	 * @param string $sProvider
	 */
	public function __construct(string $sProvider) {
		$this->sProvider = $sProvider;
	}
	
	/**
	 * Add incoming server config
	 * 
	 * @param \FideloSoftware\Mailing\AutoConfig\Config\IncomingServer $oServer
	 * @return $this
	 */
	public function addIncomingServer(IncomingServer $oServer) {
		$this->aIncomingServers[] = $oServer;
		return $this;
	}
	
	/**
	 * Get all incoming server configs
	 * 
	 * @return \FideloSoftware\Mailing\AutoConfig\Config\IncomingServer[]
	 */
	public function getIncomingServers() : array {
		return $this->aIncomingServers;
	}
	
	/**
	 * Get first incoming server config
	 * 
	 * @return \FideloSoftware\Mailing\AutoConfig\Config\IncomingServer
	 */
	public function getFirstIncomingServer() : ?IncomingServer {
		return (!empty($this->aIncomingServers)) ? $this->aIncomingServers[0] : null;
	}
	
	/**
	 * Get incoming server config with type "imap"
	 * 
	 * @return \FideloSoftware\Mailing\AutoConfig\Config\IncomingServer|null
	 */
	public function getImapIncomingServer() : ?IncomingServer {
		return $this->getIncomingServerByType(IncomingServer::IMAP);
	}
	
	/**
	 * Get incoming server config with type "pop3"
	 * 
	 * @return \FideloSoftware\Mailing\AutoConfig\Config\IncomingServer|null
	 */
	public function getPop3IncomingServer() : ?IncomingServer {
		return $this->getIncomingServerByType(IncomingServer::POP3);
	}
	
	/**
	 * Search for specific incoming server
	 * 
	 * @param string $sType
	 * @return \FideloSoftware\Mailing\AutoConfig\Config\IncomingServer|null
	 */
	protected function getIncomingServerByType(string $sType) : ?IncomingServer {
		
		$aIncomingServers = array_filter($this->getIncomingServers(), function($oIncomingServer) use ($sType) {
			return $oIncomingServer->getType() === $sType;
		});
		
		return (!empty($aIncomingServers))
			? reset($aIncomingServers)
			: null;
	}
	
	/**
	 * Set outgoing server config
	 * 
	 * @param \FideloSoftware\Mailing\AutoConfig\Config\OutgoingServer $oServer
	 * @return $this
	 */
	public function setOutgoingServer(OutgoingServer $oServer) {
		$this->oOutgoingServer = $oServer;
		return $this;
	}
	
	/**
	 * Get outgoing server config
	 * 
	 * @return \FideloSoftware\Mailing\AutoConfig\Config\OutgoingServer
	 */
	public function getOutgoingServer() {
		return $this->oOutgoingServer;
	}
	
	/**
	 * Verify mail server config (for example: not guessed)
	 * 
	 * @return $this
	 */
	public function verified() {
		$this->bVerified = true;
		return $this;
	}
	
	/**
	 * Check config verification (for example: not guessed)
	 * @return bool
	 */
	public function isVerified() : bool {
		return $this->bVerified;
	}
}

