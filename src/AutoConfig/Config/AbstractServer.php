<?php

namespace FideloSoftware\Mailing\AutoConfig\Config;

abstract class AbstractServer {
	/**
	 * @var string 
	 */
	protected $sType;
	/**
	 * @var string 
	 */
	protected $sHostname;
	/**
	 * @var int 
	 */
	protected $iPort;
	/**
	 * @var string 
	 */
	protected $sSocketType;
	/**
	 * @var string 
	 */
	protected $sAuthentication;
	/**
	 * @var string 
	 */
	protected $sUsername;
	
	public function getType() : string {
		return $this->sType;
	}
	
	public function getHostname() : string {
		return $this->sHostname;
	}
	
	public function getPort() : int {
		return $this->iPort;
	}
	
	public function getSocketType() : string {
		return $this->sSocketType;
	}
	
	public function getAuthentication() : string {
		return $this->sAuthentication;
	}
	
	public function getUserName() : string {
		return $this->sUsername;
	}
			
	public function setSocketType(string $sSocketType) {
		$this->sSocketType = $sSocketType;
		return $this;
	}
	
	public function setAuthentication(string $sAuthentication) {
		$this->sAuthentication = $sAuthentication;
		return $this;
	}
	
	public function setUserName(string $sUsername) {
		$this->sUsername = $sUsername;
		return $this;
	}

}

