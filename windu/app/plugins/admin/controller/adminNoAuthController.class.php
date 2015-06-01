<?php /*windu.org admin controller*/
Class adminNoAuthController extends htmlController
{	
	public function __construct(request $request, $plugins = array())
	{
		parent::__construct($request);
		
		lang::set('admin');
	}	
	public function index(){}
}
?>
