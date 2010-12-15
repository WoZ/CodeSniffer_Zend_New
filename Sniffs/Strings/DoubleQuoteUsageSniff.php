<?php
/**
 * ZendNew_Sniffs_Strings_DoubleQuoteUsageSniff.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Marc McIntyre <mmcintyre@squiz.net>
 * @author    Dennis Ploeger <develop@dieploegers.de>
 * @copyright 2006 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   CVS: $Id: DoubleQuoteUsageSniff.php 301632 2010-07-28 01:57:56Z squiz $
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

/**
 * ZendNew_Sniffs_Strings_DoubleQuoteUsageSniff.
 *
 * Double Quotes should only be used, if single quotes or variables are within.
 * Variables in Double quotes should not be used in the form ${variablename} 
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Marc McIntyre <mmcintyre@squiz.net>
 * @author    Dennis Ploeger <develop@dieploegers.de>
 * @copyright 2006 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: 1.3.0RC1
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class ZendNew_Sniffs_Strings_DoubleQuoteUsageSniff implements PHP_CodeSniffer_Sniff
{


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
                T_CONSTANT_ENCAPSED_STRING,
                T_DOUBLE_QUOTED_STRING,
               );

    }//end register()


    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token
     *                                        in the stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        // We are only interested in the first token in a multi-line string.
        if ($tokens[$stackPtr]['code'] === $tokens[($stackPtr - 1)]['code']) {
            return;
        }

        $workingString = $tokens[$stackPtr]['content'];
        $i = ($stackPtr + 1);
        while ($tokens[$i]['code'] === $tokens[$stackPtr]['code']) {
            $workingString .= $tokens[$i]['content'];
            $i++;
        }

        // Check if it's a double quoted string.
        if (strpos($workingString, '"') === false) {
            return;
        }

        // Make sure it's not a part of a string started in a previous line.
        // If it is, then we have already checked it.
        if ($workingString[0] !== '"') {
            return;
        }

        $doubleQuotesValid = false;

        // Check, if this string contains a variable
        
        if ($tokens[$stackPtr]['code'] === T_DOUBLE_QUOTED_STRING) {
            $stringTokens = token_get_all('<?php '.$workingString);
            foreach ($stringTokens as $token) {
                if (is_array($token) === true && in_array($token[0], array(T_VARIABLE, T_CURLY_OPEN))) {
                        $doubleQuotesValid = true;
                } else if (is_array($token) === true && $token[0] === T_DOLLAR_OPEN_CURLY_BRACES) {

                        $error = 'Variable format %s not allowed. Use {$variable} instead.';
                        $data  = array($token[1]);
                        $phpcsFile->addError($error, $stackPtr, 'IllegalVariableFormat', $data);

                        // The format isn't valid, but using a variable in a double quoted string is.

                        $doubleQuotesValid = true;

                }
            }
        }//end if

        // Check, if single quotes are in the string
        
        if (stripos($workingString, "'")) {
   
            $doubleQuotesValid = true;

        }
        
        // Is it okay, to use double quotes

        if (!$doubleQuotesValid) {

                $error = 'String %s does not require double quotes; use single quotes instead';
                $data  = array($workingString);
                $phpcsFile->addError($error, $stackPtr, 'NotRequired', $data);

        }//end if

    }//end process()


}//end class

?>
