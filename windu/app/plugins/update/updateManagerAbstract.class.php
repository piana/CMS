<?php /*windu.org update*/
/** 
 * @author Krzysztof Ruszczyński <http://www.ruszczak.eu>
 */
abstract class updateManagerAbstract
{
    const UPDATEURL = 'http://www.windu.org/updateServer/';
    const DOMAINACTIVATIONACTIONNAME = 'activation';
    const DOMAINACTIVATIONACTIONANDRESETNAME = 'activationAndResetPackages';
    const FREELICENCESACTIONNAME = 'freeLicences';
    const LICENCETYPEACTIONNAME = 'licenceType';
    
    const NOWINDULINKNOTIFY = 'noWinduLinkNotify';
    const GETUPDATESERVERMESSAGE = 'getUdateServerMessage';
    
    const LICENCEIDKEY = 'licence_key';
    const REVISIONNUMBERKEY = 'revision_no';
    const DOMAINNAMEKEY = 'domain_name';
    const SESSIONTOKENKEY = 'session_token';
    const ONLYSERVERREVISIONNOKEY = 'only_server_no';
    const FREELICENCEKEY = 2;
    
    const SESSIONAUTHENTICATIONTOKENLENGTH = 4;
    const SESSIONEXPIREDTOKEN = 'expired';
    
    const DOWNLOADEDUPDATEREVISIONNUMBERCONFIGKEY = 'downloadedRevision';
    const SESSIONTOKENCONFIGKEY = 'sessionToken';
    
    const MINIMALLENGTHOFSERVERREPLY = 1;
    const NEWPACKAGESUFFIX = '-0'; // removed everytime (only for first installation)
    
    protected $_response;
    
    /**
     * @var Boolean if set true, request file files with update (default: false)
     */
    protected $_downloadUpdate = false;
    
    /**
     * @var Boolean if set true, requests extract files with update (default: false)
     */
    protected $_performUpdate = false;
    
    /**
     * @var Integer number of revision downloaded from remote server  
     */
    protected $_downloadedRevisionNo;
    
    /**
     * @var Integer actual revision on local server 
     */
    protected $_currentRevisionNo;
    
    /**
     * @var downloadAbstract 
     */
    protected $_downloadClass;
    
    /**
     * 
     * @return String licence key
     */
    public static function getLicenceKey()
    {
    	return config::get(md5('licenceKey'.license::getDomainLink()),true);
    }
    
    /**
     * 
     * @param array $variableData REFERENCE array to which domain name field would be added
     * @return void
     */
    public static function attachDomainName( &$variableData )
    {
        $variableData[self::DOMAINNAMEKEY] = HOME;       
    }
    
    /**
     * 
     * @param array $variableData REFERENCE array to which session token would be added
     * @return void
     */
    public static function attachSessionToken( &$variableData )
    {
        $mktime = mktime();
        $sessionKey = md5(substr(updateManagerAbstract::getLicenceKey(), 5, 9) . $_SERVER['SERVER_SIGNATURE'] . 'mjszsc' . $mktime . rand(7, 8352) );
        config::set(self::SESSIONTOKENCONFIGKEY, $sessionKey);        
        $variableData[self::SESSIONTOKENKEY] = $sessionKey;
    }
    
    private function _setCurrentRevisionNo()
    {
        $this->_currentRevisionNo = config::get('revision',true);
    }

    protected function _prepareAuthenticationRequest( $getOnlyServerRevisionNo = FALSE )
    {
        $this->_downloadClass->setUrl( self::UPDATEURL );
        $variableData = array();
        $variableData[self::LICENCEIDKEY] = self::getLicenceKey();
        
        $variableData[self::REVISIONNUMBERKEY] = $this->_currentRevisionNo;
                
        self::attachSessionToken( $variableData );
        self::attachDomainName( $variableData );
        
        if( $getOnlyServerRevisionNo )
        {
            $variableData[self::ONLYSERVERREVISIONNOKEY] = '1';
        }
        
        $this->_downloadClass->setPostData($variableData);
    }
    
    protected function _executeAuthenticationRequest()
    {
        return $this->_downloadClass->execute();
    }
    
    protected function _createDownloadClass()
    {
        $this->_downloadClass = new downloadCurl();
    }
    
    protected function _downloadUpdateInfo( $getOnlyServerRevisionNo = FALSE )
    {
        $this->_createDownloadClass();
        $this->_prepareAuthenticationRequest( $getOnlyServerRevisionNo );
        $this->_response = $this->_executeAuthenticationRequest();
        $this->_filterResponse();
        $this->_downloadedRevisionNo = intval( $this->_response[self::REVISIONNUMBERKEY] );
    }
    
    abstract protected function _handleServerReply();
    
    protected function _filterResponse()
    {
        if( $this->_response !== FALSE )
        {   
            $this->_response = unserialize( trim( $this->_response ) );
        }
        
        if( $this->_response === FALSE || !is_array( $this->_response ) ) 
        {   // unable to retrieve curl result (or invalid) - get actual revisionNo
            $this->_response = array();
            $this->_response[self::REVISIONNUMBERKEY] = $this->_currentRevisionNo;
        }
    }
    
    /**
     * 
     * @param Boolean $downloadUpdate
     */
    public function setDownloadUpdateFlag( $downloadUpdate )
    {
        $this->_downloadUpdate = $downloadUpdate;
    }
    
    /**
     * 
     * @param Boolean $performUpdate
     */
    public function setPerformUpdateFlag( $performUpdate )
    {
        $this->_performUpdate = $performUpdate;
    }
    
    public function getServerRevisionNo()
    {
        $this->_setCurrentRevisionNo();
        $this->_downloadUpdateInfo( TRUE );
        return $this->_downloadedRevisionNo;
    }
    
    public function update()
    {
        $this->_setCurrentRevisionNo();
        
        try
        {            
            if( $this->_downloadUpdate )
            {
                $this->_downloadUpdateInfo();                                
                config::set( self::DOWNLOADEDUPDATEREVISIONNUMBERCONFIGKEY, $this->_response[self::REVISIONNUMBERKEY] );
            }
            else
            {
                @$this->_downloadedRevisionNo = intval( config::get( self::DOWNLOADEDUPDATEREVISIONNUMBERCONFIGKEY , true) );
            }

            if( ( $this->_performUpdate && isset( $this->_downloadedRevisionNo ) && !empty( $this->_downloadedRevisionNo ) ) || ( $this->_downloadUpdate && count( $this->_response ) > self::MINIMALLENGTHOFSERVERREPLY ) )
            {
                $this->_handleServerReply();
            }
            
            if( $this->_performUpdate )
            {
                config::set('revision', $this->_downloadedRevisionNo);
                config::set(self::SESSIONTOKENCONFIGKEY, self::SESSIONEXPIREDTOKEN);
                cache::flushSystemCache();
            }            
        }
        catch (Exception $e)
        {
            die('Wyjątek: ' . $e->getMessage());
        }
    }
}
