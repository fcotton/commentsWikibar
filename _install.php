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
if (!defined('DC_CONTEXT_ADMIN')) return;

$this_version = $core->plugins->moduleInfo('commentsWikibar','version');
$installed_version = $core->getVersion('commentsWikibar');
if (version_compare($installed_version,$this_version,'>=')) {
	return;
}

$core->blog->settings->addNamespace('commentswikibar');
$core->blog->settings->commentswikibar->put('commentswikibar_active',false,'boolean','',false,true);
$core->blog->settings->commentswikibar->put('commentswikibar_add_css',true,'boolean','',false,true);
$core->blog->settings->commentswikibar->put('commentswikibar_add_jslib',true,'boolean','',false,true);
$core->blog->settings->commentswikibar->put('commentswikibar_add_jsglue',true,'boolean','',false,true);
$core->blog->settings->commentswikibar->put('commentswikibar_custom_css','','string','',false,true);
$core->blog->settings->commentswikibar->put('commentswikibar_custom_jslib','','string','',false,true);

$core->setVersion('commentsWikibar',$this_version);
return true;
?>