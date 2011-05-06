<?php

namespace Duke;

class Reflection
{
	/**
	 * Get a classes constants, optionally filter out constants not containing pattern
	 * 
	 * @param string|object $class
	 * @param string $pattern
	 */
	public static function getClassConstants($class, $pattern=null)
	{
		if (is_object($class)) $class = get_class($class);
		
		$refl = new \ReflectionClass($class);
		$constants = $refl->getConstants();
		
		if ($pattern)
		{
			$final = array();
			
			foreach ($constants as $key => $value)
			{
				if (strpos($key, $pattern) !== false)
				{
					$final[$key] = $value;
				}
			}
			
			$constants = $final;
		}
		
		return $constants;
	}
}