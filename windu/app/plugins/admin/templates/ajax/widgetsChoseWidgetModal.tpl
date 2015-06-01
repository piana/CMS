<div class="pad-big">
	<div class="progress progress-striped">
		 <div class="bar" style="width: 10%;"></div>
	</div>
</div>
<div class="bottomForm">			
	<table class="table table-striped tablesort">
	  <tbody>
	  {foreach $widgetsList as $key => $widget}
		<tr>
			<td><a href="{$HOME}admin/ajax/widgets/choseOptions/{$widget}/">{include file='common/widget_icons.tpl' themename=$widget} {$widget}</a></td>
			<td>{L key="widgets.{$widget}.smallhelp"}</td>
			<td>
				<div class="buttons">
					<a href="{$HOME}admin/ajax/widgets/choseOptions/{$widget}/"><i class="fa fa-check-circle icon-blue">&nbsp;</i></a>
				</div>
			</td>
		</tr>
	  {/foreach}   
	  </tbody>
	</table>	
</div>
	