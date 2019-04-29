<?php

namespace FideloSoftware\Mailing\AutoConfig\Factory;

use FideloSoftware\Mailing\AutoConfig\Config;

class ConfigFactory {
	
	/**
	 * Build mail server config from xml object
	 * 
	 * see: https://wiki.mozilla.org/Thunderbird:Autoconfiguration:ConfigFileFormat
	 * 
	 * @param \SimpleXMLElement $oXml
	 * @return \FideloSoftware\Mailing\AutoConfig\Config|null
	 */
	public function buildFromXml(\SimpleXMLElement $oXml) : ?Config {

		if($oXml->emailProvider) {
			
			$oEmailProvider = $oXml->emailProvider;
			
			$sProvider = (isset($oEmailProvider->displayName)) ? (string) $oEmailProvider->displayName : 'Unknown';
			
			$oConfig = new Config($sProvider);
			
			if(isset($oEmailProvider->incomingServer)) {
				foreach($oEmailProvider->incomingServer as $oIncomingServerChild) {
					
					$oAttributes = $oIncomingServerChild->attributes();

					$oIncomingServer = new Config\IncomingServer(
						(string)$oIncomingServerChild->hostname, 
						(int)$oIncomingServerChild->port,
						(string)$oAttributes->type
					);
					
					if(isset($oIncomingServerChild->socketType)) $oIncomingServer->setSocketType((string)$oIncomingServerChild->socketType);
					if(isset($oIncomingServerChild->authentication)) $oIncomingServer->setAuthentication((string)$oIncomingServerChild->authentication);
					if(isset($oIncomingServerChild->username)) $oIncomingServer->setUserName((string)$oIncomingServerChild->username);
						
					$oConfig->addIncomingServer($oIncomingServer);
				}
			}
			
			if(isset($oEmailProvider->outgoingServer)) {
				
				$oAttributes = $oEmailProvider->outgoingServer->attributes();
				
				$oOutgoingServer = new Config\OutgoingServer(
					(string)$oEmailProvider->outgoingServer->hostname, 
					(int)$oEmailProvider->outgoingServer->port,
					(string)$oAttributes->type
				);
					
				if(isset($oEmailProvider->outgoingServer->socketType)) $oOutgoingServer->setSocketType((string)$oEmailProvider->outgoingServer->socketType);
				if(isset($oEmailProvider->outgoingServer->authentication)) $oOutgoingServer->setAuthentication((string)$oEmailProvider->outgoingServer->authentication);
				if(isset($oEmailProvider->outgoingServer->username)) $oOutgoingServer->setUserName((string)$oEmailProvider->outgoingServer->username);

				$oConfig->setOutgoingServer($oOutgoingServer);
			}
			
			$oConfig->verified();
			
			return $oConfig;
		}
		
		return null;
	}

}

