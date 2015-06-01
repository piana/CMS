<?php /*windu.org update*/
 /** 
 * @author Krzysztof Ruszczyński <http://www.ruszczak.eu>
 */
abstract class downloadAbstract
{
    static public function generateInputString( $data )
    {
        $output = '';
        foreach( $data as $key => $value )
        {
            if( !empty($output) )
            {
                $output .= "&";
            }
            
            $output .= "$key=$value";
        }
        
        return $output;
    }
    
    abstract public function setUrl( $url );
    
    abstract public function setHeader( $headerArray );
    
    abstract public function setPostData( $variableData );
    
    abstract public function execute();
    
    abstract public function downloadFile( $destination );
}
