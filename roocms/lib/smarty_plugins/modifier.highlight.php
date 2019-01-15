<?php
/**
 * Highlights a text by searching a word in it.
 */
/*function smarty_modifier_highlight($text='', $word='')
{
	if(strlen($text) > 0 && strlen($word) > 0)
	{
		return preg_replace('/\b('.preg_quote($word).')\b/', '<mark>${1}</mark>', $text);
	}
	return($text);
}*/

function smarty_modifier_highlight(&$text='', $word='') {

	if($word) {
		$word = preg_quote($word);
		$text = preg_replace('/('.$word.')/iu', '<mark>\1</mark>', $text);
	}

	return($text);
}
