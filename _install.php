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
if (null === $core->blog->settings->commentswikibar->commentswikibar_active) {
	$wiki_comments = (boolean)$core->blog->settings->system->wiki_comments;
	$core->blog->settings->commentswikibar->put('commentswikibar_active',$wiki_comments,'boolean');
	$core->blog->settings->commentswikibar->put('commentswikibar_custom_css','','string');
}

$core->setVersion('commentsWikibar',$this_version);
return true;
?>