<?php
/**
 * Class for update authentication 
 * IMPORTANT: if you change the content of this file manually, 
 * your licence key (if stolen) could be used by someone else
 * 
 * @author Krzysztof Ruszczyński <http://www.ruszczak.eu>
 */
class updateIndexController extends controller
{
    public function index()
    {    	
        $tokenLength = 32;
        
        $inputToken = $this->request->getVariable('sid');
        $realToken = config::get(updateManagerAbstract::SESSIONTOKENCONFIGKEY,true);        
 
        $inputTokenForAuth = substr($inputToken, 0, updateManagerAbstract::SESSIONAUTHENTICATIONTOKENLENGTH);
        
        if( strlen($inputToken) <> updateManagerAbstract::SESSIONAUTHENTICATIONTOKENLENGTH )
        {
            die('0');
        }
        else if( $inputTokenForAuth == substr($realToken, 0, updateManagerAbstract::SESSIONAUTHENTICATIONTOKENLENGTH)  )
        {
            die($realToken);
        }
        else
        {   
            $firstMd5Character = 1; //not higher than $authSignsNumber
            die($inputTokenForAuth . substr(md5(substr(updateManagerAbstract::getLicenceKey(), 3, 7) . $inputTokenForAuth . $_SERVER['SERVER_SIGNATURE'] . 'afgds'), $firstMd5Character, $tokenLength - updateManagerAbstract::SESSIONAUTHENTICATIONTOKENLENGTH));
        }
    }
}

