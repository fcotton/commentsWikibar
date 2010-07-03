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

// Getting current parameters
$active = (boolean)$core->blog->settings->commentswikibar->commentswikibar_active;
$custom_css = (string)$core->blog->settings->commentswikibar->commentswikibar_custom_css;

// Saving new configuration
if (!empty($_POST['saveconfig'])) {
	try
	{
		$core->blog->settings->addNameSpace('commentswikibar');

		$active = (empty($_POST['active']))?false:true;
		$custom_css = (empty($_POST['custom_css']))?'':html::sanitizeURL($_POST['custom_css']);
		$core->blog->settings->commentswikibar->put('commentswikibar_active',$active,'boolean');
		$core->blog->settings->commentswikibar->put('commentswikibar_custom_css',$custom_css,'string');
		
		// Active wikibar enforces wiki syntax in blog comments
		$wiki_comments = (boolean)$core->blog->settings->system->wiki_comments;
		if ($active && !$wiki_comments) {
			$core->blog->settings->system->put('wiki_comments',true,'boolean');
		}
		$core->blog->triggerBlog();

		$msg = __('Configuration successfully updated.');
	}
	catch (Exception $e)
	{
		$core->error->add($e->getMessage());
	}
}
?>
<html>
<head>
	<title><?php echo __('Comments Wikibar'); ?></title>
</head>

<body>
<h2><?php echo html::escapeHTML($core->blog->name); ?> &rsaquo; <?php echo __('Comments Wikibar'); ?></h2>

<?php if (!empty($msg)) echo '<p class="message">'.$msg.'</p>'; ?>

<div id="sitemaps_options">
	<form method="post" action="plugin.php">
	<fieldset>
		<legend><?php echo __('Plugin activation'); ?></legend>
		<p class="field">
			<?php echo form::checkbox('active', 1, $active); ?>
			<label class=" classic" for="active">&nbsp;<?php echo __('Enable Comments Wikibar');?></label>
		</p>
		<p><em><?php echo __('Activating this plugin also enforces wiki syntax in blog comments'); ?></em></p>
	</fieldset>

	<fieldset>
		<legend><?php echo __('Options'); ?></legend>
		<p class="field">
			<label class=" classic"><?php echo __('Use custom CSS') ; ?> : </label>
			<?php echo form::field('custom_css',40,128,$custom_css); ?>
		</p>
		<p><em><?php echo __('You can use a custom CSS by providing its location.'); ?><br />
		<?php echo __('A location beginning with a / is treated as absolute, else it is treated as relative to the blog\'s current theme URL'); ?>
		</em></p>
	</fieldset>

	<p><input type="hidden" name="p" value="commentsWikibar" />
	<?php echo $core->formNonce(); ?>
	<input type="submit" name="saveconfig" value="<?php echo __('Save configuration'); ?>" />
	</p>
	</form>
</div>

</body>
</html>
