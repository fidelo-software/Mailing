<?php

namespace FideloSoftware\Mailing\Traits;

trait RunStack {

	/**
	 * Run stack of auto discovery classes (stops on first match)
	 *
	 * @param array|string $mStack
	 * @param string $sDomain
	 * @return \FideloSoftware\Mailing\AutoConfig\Config|null
	 */
	public function run($mStack, string $sDomain) {

		if(!is_array($mStack)) $mStack = [$mStack];

		foreach($mStack as $sDiscoverClass) {
			if(null !== $oConfig = (new $sDiscoverClass)->discover($sDomain)) {
				return $oConfig;
			}
		}

		return null;
	}

}