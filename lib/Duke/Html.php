<?php

namespace Duke;

class Html
{
	public static function tag($type, $attributes=null, $content=null)
	{
		if ($attributes)
		{
			$attributeHtml = '';
			foreach($attributes as $attribute => $value)
			{
				$attributeHtml .= ' ' . $attribute . '="' . $value . '"';
			}
			
		} else {
			$attributeHtml = '';
		}
		
		if ($content !== null)
		{
		  $html =<<<EOL
<{$type}{$attributeHtml}>
  $content
</{$type}>

EOL;
		} else {
			$html = "<{$type}{$attributeHtml} />";
		}

		return $html;
	}
	
	public static function tag_select($name, $attributes, $options, $selected=null, $addEmpty=false)
	{
		$attributes['name'] = $name;
		
		if ($selected === 'first') $selected = 0;
    else if ($selected === 'last') $selected = count($options) -1;
		
		$content = '';
		
		if ($addEmpty) $content .= self::tag_option('', is_string($addEmpty) ? $addEmpty : '', null);
		
		$i = 0;
		foreach ($options as $key => $value)
		{
			$attr = null;
			if ($key === $selected) $attr = array('selected' => 'selected');
			
			$content .= self::tag_option($key, $value, $attr);
			
			++$i;
		}
		
		return self::tag('select', $attributes, $content);
	}
	
	public static function tag_option($key, $value, $attributes=array())
	{
		$attributes['value'] = $key;

		$html = self::tag('option', $attributes, $value);
		return $html;
	}
	
	public static function tag_image($src, $attributes=array())
	{
		$attributes['src'] = $src;
		return self::tag('img', $attributes);
	}
	
	public static function tag_link($href, $title, $attributes=array())
	{
		$attributes['href'] = $href;
		return self::tag('a', $attributes,$title);
	}
	
	public static function tag_imagelink($href, $src, $linkAttributes=array(), $imgAttributes=array())
	{
		return self::tag_link($href, self::tag_image($src, $imgAttributes), $linkAttributes );
	}
}