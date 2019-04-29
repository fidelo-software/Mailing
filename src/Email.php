<?php

namespace FideloSoftware\Mailing;

use FideloSoftware\Mailing\Exceptions\InvalidEmailException;

class Email {
	/**
	 * @var string
	 */
	private $sEmail;
	
	/**
	 * @param string $sEmail
	 */
	public function __construct(string $sEmail) {
		self::validateOrFail($sEmail);
		$this->sEmail = $sEmail;
	}
	
	/**
	 * Get full e-mail-address
	 * @return string
	 */
	public function getFull() : string {
		return $this->sEmail;
	}
	
	/**
	 * Get domain part of the given e-mail-address
	 * 
	 * @return string
	 */
	public function getDomain() : string {
		return substr($this->sEmail, strpos($this->sEmail, '@') + 1);
	}
	
	/**
	 * Get local part of the given e-mail-address
	 * 
	 * @return string
	 */
	public function getLocalPart() : string {
		return substr($this->sEmail, 0, strpos($this->sEmail, '@') - 1);
	}
	
	/**
	 * Validate an e-mail-address
	 * 
	 * @param string $sEmail
	 * @return bool
	 */
	public static function validate(string $sEmail) : bool {
		return filter_var($sEmail, FILTER_VALIDATE_EMAIL);
	}
	
	/**
	 * Validate an e-mail-address and throw an exception if not valid
	 * 
	 * @param string $sEmail
	 * @return bool
	 * @throws \FideloSoftware\Mailing\Exceptions\InvalidEmailException
	 */
	public static function validateOrFail(string $sEmail) : bool {
		if(!self::validate($sEmail)) throw new InvalidEmailException('Invalid Email');		
		return true;
	}
	
}

