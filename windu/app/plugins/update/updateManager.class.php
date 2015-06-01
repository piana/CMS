<?php /*windu.org update*/
/** 
 * @author Krzysztof Ruszczyński <http://www.ruszczak.eu>
 */
class updateManager extends updateManagerAbstract
{   
    const UPDATEFILEFOLDER = 'data/update';
    
    const BASEFILEKEY = 'baseFile';
    const MODULESFILESARRAYKEY = 'modulesArray';
    const MODULESMIGRATIONSARRAYKEY = 'modulesMigrationsArray';
    const MIGRATIONFILEKEY = 'migrationFile';

    const LOCALFILEWITHDOWNLOADEDPACKAGESNAMES = 'packages';
    
    /**
     * @var String path to place where updates are downloaded 
     */
    protected $_pathTofile = '';
    
    /**
     * @var Array 
     */
    protected $_packages;
    
    public function __construct()
    {
        $this->_pathTofile = __SITE_PATH . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, self::UPDATEFILEFOLDER) . DIRECTORY_SEPARATOR;
    }
    
    /**
     * 
     * @param string $url
     * @return downloadCurl
     */
    protected function _downloadFile( $url, $destination, $forceOverwrite = false )
    {
        if( !file_exists( $destination ) || $forceOverwrite )
        {            
            $this->_createDownloadClass();
            $this->_downloadClass->setUrl( $url );
            $this->_downloadClass->downloadFile( $destination );
        }
    }
    
    protected function _extractBaseFile()
    {        
        $zipPath = $this->_pathTofile . $this->_downloadedRevisionNo . '.zip';
        $destination = __SITE_PATH . DIRECTORY_SEPARATOR;
        
        
        if( $this->_downloadUpdate  && isset( $this->_response[self::BASEFILEKEY] ) )
        {
            $this->_downloadFile( $this->_response[self::BASEFILEKEY] , $zipPath );
        }
        
        if( $this->_performUpdate && file_exists( $zipPath ) )
        {
            compress::unzip( $zipPath, $destination );
            unlink( $zipPath );
        }
    }
    
    protected function _extractFilesWithModules()
    {
        $destination = __SITE_PATH . DIRECTORY_SEPARATOR;
        
        if( isset( $this->_packages[self::MODULESFILESARRAYKEY] ) && !empty( $this->_packages[self::MODULESFILESARRAYKEY] ) )
        {
            foreach( $this->_packages[self::MODULESFILESARRAYKEY] as $packageName => $fileUrl )
            {
                $zipPath = $this->_pathTofile . $packageName . $this->_downloadedRevisionNo . '.zip';
                
                if( $this->_downloadUpdate )
                {
                    $this->_downloadFile( $fileUrl, $zipPath );
                }

                if( $this->_performUpdate )
                {
                    compress::unzip( $zipPath, $destination );
                    unlink( $zipPath );
                }
            }            
        }
    }
    
    protected function _executeModulesMigrationsQueries()
    {
        if( isset( $this->_packages[self::MODULESMIGRATIONSARRAYKEY] ) && !empty( $this->_packages[self::MODULESMIGRATIONSARRAYKEY] ) )
        {
            foreach( $this->_packages[self::MODULESMIGRATIONSARRAYKEY] as $packageName => $fileUrl )
            {
                $destination = $this->_pathTofile . $packageName . '_' . $this->_currentRevisionNo . '-' . $this->_downloadedRevisionNo . '.sql';
                
                if( $this->_downloadUpdate )
                {
                    $this->_downloadFile( $fileUrl , $destination );
                }

                if( $this->_performUpdate )
                {
                    baseDB::executeSql( file_get_contents( $destination ) );
                    unlink( $destination );
                }
                
            }
        }
    }
    
    protected function _executeMigrationQuery()
    {
        $destination = $this->_pathTofile . $this->_currentRevisionNo . '-' . $this->_downloadedRevisionNo . '.sql';
        
        if( $this->_downloadUpdate && isset($this->_response[self::MIGRATIONFILEKEY]) )
        {
            $this->_downloadFile( $this->_response[self::MIGRATIONFILEKEY] , $destination );
        }
        
        if( $this->_performUpdate && file_exists($destination) )
        {
            baseDB::executeSql( file_get_contents($destination) );
            unlink( $destination );
        }
    }
    
    protected function _handleModules()
    {
        $packagesFile = $this->_pathTofile . self::LOCALFILEWITHDOWNLOADEDPACKAGESNAMES;
        $this->_packages = array();
        
        if( $this->_downloadUpdate )
        {   // get from http response packages and saving them to file
            if( file_exists($packagesFile) )
            {
                unlink( $packagesFile );
            }   
            
            if( isset( $this->_response[self::MODULESMIGRATIONSARRAYKEY] ) && !empty( $this->_response[self::MODULESMIGRATIONSARRAYKEY] ) )
            {
                foreach( $this->_response[self::MODULESMIGRATIONSARRAYKEY] as $packageName => $fileUrl )
                {
                    $this->_packages[self::MODULESFILESARRAYKEY][$packageName]  = $this->_response[self::MODULESFILESARRAYKEY][$packageName];
                    $this->_packages[self::MODULESMIGRATIONSARRAYKEY][$packageName] = $fileUrl;
                }
                
                $packagesToCopy = $this->_packages;
                $packageCopyFunction = create_function('&$element', '$element = "";');
                //array_walk($packagesToCopy[self::MODULESFILESARRAYKEY], $packageCopyFunction);
                //array_walk($packagesToCopy[self::MODULESMIGRATIONSARRAYKEY], $packageCopyFunction);
                file_put_contents( $packagesFile, serialize($packagesToCopy) );
            }
                                 
        }
        
        if( $this->_performUpdate )
        {   // get packages from file and delete it
            if( file_exists( $packagesFile ) )
            {
                $this->_packages = unserialize( trim( file_get_contents( $packagesFile ) )  );
                unlink( $packagesFile );
            }            
        }
        
        $this->_extractFilesWithModules();
        $this->_executeModulesMigrationsQueries();
    }
    
    protected function _handleServerReply() 
    {
        $this->_extractBaseFile();        
        $this->_executeMigrationQuery();
        
        $this->_handleModules();
    }
}
