<?php
Class widgetMainController
{	
	public $params;
	public function __construct($params,$request)
	{
		$this->request = $request;
		$this->params = $params;

        $widgetName = str_replace('Controller', '', get_class($this));

        if(!cache::fileIsCached('css',$widgetName.__HOME_NOGET)){
            $cssString = '';


            if (is_dir(WIDGET_PATH.$widgetName.'/css/')) {
                $fileList = baseFile::getFilesList(WIDGET_PATH.$widgetName.'/css/','css');
                if(is_array($fileList)){
                    $cssString = '';
                    foreach ($fileList as $file){
                        if (filesize($file->path)>3) {
                            $cssString .= str_replace('../',HOME.'data/widgets/'.$widgetName.'/',baseFile::readFile($file->path));
                        }
                    }
                    $cssString = generate::compressCSS($cssString);
                }
            }

            baseFile::saveFile(resourceManager::getCssWidgetsPath(),$cssString,FILE_APPEND);
            cache::fileWrite('css',$widgetName.__HOME_NOGET,'');

        }
    }
}
?>
