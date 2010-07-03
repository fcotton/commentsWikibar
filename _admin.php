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

$_menu['Plugins']->addItem(__('Comments Wikibar'),'plugin.php?p=commentsWikibar','index.php?pf=commentsWikibar/icon.png',
		preg_match('/plugin.php\?p=commentsWikibar(&.*)?$/',$_SERVER['REQUEST_URI']),
		$core->auth->check('contentadmin',$core->blog->id));
?>