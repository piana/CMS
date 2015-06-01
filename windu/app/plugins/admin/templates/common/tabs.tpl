{if $pins!=''}
	<div id="sidebar-right">
		<ul>
			{foreach $pins as $key => $pin}
				{$iconName = $key}
				<li data-toggle="tooltip" data-placement="left" data-original-title="{L key = $key}">
					<a href="{$HOME}admin/mainDo/showTab/{base64_encode(str_replace($HOME,'',$pin.0))}/{$pin@key}/">
						<i class="color-icons {$pinsIconsArray.$iconName}"></i>
					</a>
				</li>
			{/foreach}	
			<li data-toggle="tooltip" data-placement="bottom" data-original-title="{L key = "admin.templates.common.tabs.cleanpins"}">
				<a href="{$HOME}admin/do/cleanPins/">
					<i class="fa fa-times-circle "> </i>
				</a>
			</li>				
		</ul>
	</div>
{/if}