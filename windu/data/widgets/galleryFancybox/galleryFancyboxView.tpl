{if $params.width==''}{$params.width = config::get(imgGalleryWidth)}{/if}
{if $params.height==''}{$params.height = config::get(imgGalleryHeight)}{/if}
{if $params.fit==''}{$params.fit = config::get(imgGalleryFit)}{/if}
{if $params.fullwidth==''}{$params.fullwidth = config::get(imgGalleryFullWidth)}{/if}
{if $params.fullheight==''}{$params.fullheight = config::get(imgGalleryFullHeight)}{/if}
{if $params.filter==''}{$params.filter = 'original'}{/if}
{if $params.showDescription==''}{$params.showDescription = 1}{/if}
{if $params.rel==''}{$params.rel = 'lightbox_group'}{/if}

{if !empty($params.bucket)}
	{assign results $data.imagesDB->getByBucket($params.bucket)}
{else}
	{assign results $params.images}
{/if}

{foreach $results as $image}
	<a href="{$HOME}image/{$image->ekey}/{$params.fullwidth}/{$params.fullheight}/fit/{$params.filter}/#.{$image->type}" rel="{$params.rel}" title="{if $params.showDescription == 1}{$image->description|truncate:100}{/if}">
		<img src="{$HOME}image/{$image->ekey}/{$params.width}/{$params.height}/{$params.fit}/{$params.filter}/">
	</a>
{/foreach}

<script type="text/javascript">
{literal}
	$(document).ready(function() {
	    $("a[rel={/literal}{$params.rel}{literal}]").fancybox
	    (
	        {
	        	'padding'			: 0,
	        	'titleShow'			: true,
	        	'autoScale'			: true,
	        	'titlePosition'		: 'over',
	        	'transitionIn'		: 'none',
	        	'transitionOut'		: 'none',
	        	'overlayColor'		: '#000',
				'overlayOpacity'	: '0.8',
				'centerOnScroll'	: true
	        }
	    );
	});
{/literal}
</script>