<?php /*windu.org model*/
Class searchController extends widgetMainController
{		
	public function run() {
        $form = new form('search','searchSuccess',$_POST,'POST','searchForm','');

        $form->add('HTML', '
			<div class="input-append">
				<input name="searchText" type="text"  placeholder='.lang::read('search.controller.class.enter').' >
				<input type="submit" class="btn" value='.lang::read('search.controller.class.search').'>
			</div>
        ');
             
		$form->setHandler($this);
		$form->handle();

		return array("form" => $form);
	}
	public function searchSuccess($data) {
		if ($data['searchText']!=null) {
			$pagesDB = new pagesDB();
			$pageUrlKey = $pagesDB->get($this->params['targetPage'],'urlKey');
			$searchUrl = urlencode(str_replace('/', ' ', $data['searchText']));

			$redirectUrl = HOME.$pageUrlKey.'/'.$searchUrl;
			router::redirect($redirectUrl);
		}
	}
}
?>