<?php /*windu.org update*/
/** 
 * @author Krzysztof Ruszczyński <http://www.ruszczak.eu>
 */
class downloadCurl extends downloadAbstract
{
    protected $_curlObject;
    
    
    public function __construct()
    {
        $this->_curlObject = curl_init();
    }

    public function __destruct() 
    {
        curl_close( $this->_curlObject );
    }
    public function setUrl( $url ) 
    {
        curl_setopt($this->_curlObject, CURLOPT_URL, $url);
    }
    
    /**
     * @return mixed content on success, false (boolean) on failure
     */
    public function execute() 
    {
        curl_setopt( $this->_curlObject, CURLOPT_RETURNTRANSFER, 1);
        return curl_exec( $this->_curlObject );
    }
    
    public function setHeader( $headerArray )
    {
        curl_setopt( $this->_curlObject, CURLOPT_HTTPHEADER, $headerArray );
    }
    
    public function setPostData( $variableData )  
    {
        if( is_array($variableData) )
        {
            $variableData = self::generateInputString( $variableData );
        }
        
        curl_setopt($this->_curlObject, CURLOPT_POST, 1);//przesylamy metodą post
        curl_setopt($this->_curlObject, CURLOPT_POSTFIELDS, $variableData);
    }

    public function downloadFile( $destination ) 
    {
        $fp = fopen($destination, 'w'); 
        curl_setopt($this->_curlObject, CURLOPT_FILE, $fp);        
        curl_exec( $this->_curlObject );     
        fclose($fp);
    }
    
}
