<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of commentsWikibar, a plugin for DotClear2.
# Copyright (c) 2006-2010 Pep and contributors.
# Licensed under the GPL version 2.0 license.
# See LICENSE file or
# http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
#
# -- END LICENSE BLOCK ------------------------------------
if (!defined('DC_RC_PATH')) return;

$core->addBehavior('publicHeadContent',  array('commentsWikibarBehaviors','publicHeadContent'));
$core->addBehavior('publicFooterContent',array('commentsWikibarBehaviors','publicFooterContent'));

class commentsWikibarBehaviors
{
	protected static function canActivate()
	{
		global $core;
		
		if ( $core->blog->settings->commentswikibar->commentswikibar_active &&
			$core->blog->settings->system->wiki_comments)
		{
			$supported_modes = new ArrayObject(array('post','pages','gal','galitem'));
			$core->callBehavior('initCommentsWikibar',$supported_modes);
			if (in_array($core->url->type,(array)$supported_modes)) {
				return true;
			}
		}
		return false;
	}
	
	public static function publicHeadContent()
	{
		global $core;
		
		if (self::canActivate()) {
			$custom_css = $core->blog->settings->commentswikibar->commentswikibar_custom_css;		
			if (!empty($custom_css)) {
				if (strpos('/',$custom_css) === 0) {
					$css = $custom_css;
				}
				else {
					$css =
						$core->blog->settings->system->themes_url."/".
						$core->blog->settings->system->theme."/".
						$custom_css;
				}
			}
			else {
				$css = html::stripHostURL($core->blog->getQmarkURL().'pf=commentsWikibar/wikibar.css');
			}
			echo '<link rel="stylesheet" type="text/css" media="screen" href="'.$css.'"/>';
		}
	}
	
	public static function publicFooterContent()
	{
		global $core;
		
		if (self::canActivate()) {
			$js = html::stripHostURL($core->blog->getQmarkURL().'pf=commentsWikibar/wikibar.js');

			echo
			'<script type="text/javascript" src="'.$js.'"></script>'."\n".
			'<script type="text/javascript">'."\n".
			"//<![CDATA[\n".
			"addListener(window,'load',function() {\n".
			"jsToolBar.prototype.base_url = '".html::escapeJS($core->blog->host)."'; \n".
			"jsToolBar.prototype.legend_msg = '".html::escapeJS(__('You can use the following shortcuts to format your text.'))."'; \n".
			"jsToolBar.prototype.elements.strong.title = '".html::escapeJS(__('Strong emphasis'))."'; \n".
			"jsToolBar.prototype.elements.em.title = '".html::escapeJS(__('Emphasis'))."'; \n".
			"jsToolBar.prototype.elements.ins.title = '".html::escapeJS(__('Inserted'))."'; \n".
			"jsToolBar.prototype.elements.del.title = '".html::escapeJS(__('Deleted'))."'; \n".
			"jsToolBar.prototype.elements.quote.title = '".html::escapeJS(__('Inline quote'))."'; \n".
			"jsToolBar.prototype.elements.code.title = '".html::escapeJS(__('Code'))."'; \n".
			"jsToolBar.prototype.elements.ul.title = '".html::escapeJS(__('Unordered list'))."'; \n".
			"jsToolBar.prototype.elements.ol.title = '".html::escapeJS(__('Ordered list'))."'; \n".
			"jsToolBar.prototype.elements.link.title = '".html::escapeJS(__('Link'))."'; \n".
			"jsToolBar.prototype.elements.link.href_prompt = '".html::escapeJS(__('URL?'))."'; \n".
			"jsToolBar.prototype.elements.link.hreflang_prompt = '".html::escapeJS(__('Language?'))."'; \n\n".
			"if (document.getElementById) { \n".
			"	if (document.getElementById('".html::escapeJS('c_content')."')) { \n".
			"		var commentTb = new jsToolBar(document.getElementById('".html::escapeJS('c_content')."')); \n".
			"		commentTb.draw(); \n".
			"	}\n".
			"}\n".
			"});\n".
			"\n//]]>\n".
			"</script>\n";
		}
	}
}
?>