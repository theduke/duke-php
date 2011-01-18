<?php

namespace Duke;

class Url
{
  const QUERY_TYPE_BASIC = 'basic';
  const QUERY_TYPE_ZEND = 'zend';
  
  /**
   * like zend, but here the params are seperated
   * by a pipe ( | )
   * @var string
   */
  const QUERY_TYPE_PIPED = 'piped';
  
  public static function assemble($url, array $params, $queryType=self::QUERY_TYPE_BASIC)
  {
      return $url . self::assembleParams($params, $queryType);
  }
  
  public static function assembleParams(array $params, $queryType=self::QUERY_TYPE_BASIC)
  {
      if (empty($params)) return '';
      
      $query = '';
      switch ($queryType)
      {
          case self::QUERY_TYPE_BASIC:
              $i = 0;
              foreach ($params as $key => $value)
              {
              	  ++$i;
              	
                  $delimiter = ($i === 1 ? '?' : '&');
                  
                  if (is_array($value))
                  {
                  	$query .= $delimiter . self::assembleBasicArray($key, $value);
                  } else {
                  	$query .= $delimiter . $key . '=' . rawurlencode($value);
                  }
              }

              break;
          case self::QUERY_TYPE_ZEND:
              foreach ($params as $key => $value)
              {
                if (!is_array($value)) $value = array($value);
                              	
              	foreach ($value as $subValue)
                {
              	  $query .= '/' . $key . '/' . rawurlencode($subValue);
                }
              }
              break;
          case self::QUERY_TYPE_PIPED:
              foreach ($params as $key => $value)
              {
                if (!is_array($value)) $value = array($value);
                                
                foreach ($value as $subValue)
                {
                  $query .= '|' . $key . '|' . rawurlencode($subValue);
                }
              }
              
              // replace first pipe with a slash
              $query = '/' . substr($query, 1);
          	break;
          default:
              throw new Exception('Unknown query type: ' . $queryType);
      }
      
      return $query;
  }
  
  public static function assembleBasicArray($key, $arr)
  {
  	$key = $key . '[]';
  	$query = '';
  	
  	$i = 0;
  	$lastKey = count($arr) - 1;
  	foreach ($arr as $val)
  	{
  		$query .= $key . '=' . rawurlencode($val);
  		if ($i < $lastKey) $query .= '&'; 
  		
  		$i++;
  	}
  	
  	return $query;
  }
}