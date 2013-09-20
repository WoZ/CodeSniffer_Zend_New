<?php
/**
 * ZendNew_Sniffs_WhiteSpace_TrailingSpacesSniff.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Dmitry Menshikov <d.menshikov@creators.com.ua>
 * @copyright 2006-2012 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

/**
 * ZendNew_Sniffs_WhiteSpace_TrailingSpacesSniff.
 *
 * Checks that the include_once is used in conditional situations, and
 * require_once is used elsewhere. Also checks that brackets do not surround
 * the file being included.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Dmitry Menshikov <d.menshikov@creators.com.ua>
 * @copyright 2006-2012 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: 1.3.2
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class ZendNew_Sniffs_WhiteSpace_TrailingSpacesSniff implements PHP_CodeSniffer_Sniff
{

    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizers = array('PHP', 'JS', 'CSS',);


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
                T_OPEN_TAG,
                T_CLOSE_TAG,
                T_WHITESPACE,
                T_COMMENT,
                T_DOC_COMMENT,
               );

    }//end register()


    /**
     * Processes this sniff.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token in the
     *                                        stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        // Check for end of line whitespace.
        if (strpos($tokens[$stackPtr]['content'], $phpcsFile->eolChar) === false) {
            return;
        }

        $tokenContent = rtrim($tokens[$stackPtr]['content'], $phpcsFile->eolChar);
        if (empty($tokenContent) === false) {
            if (preg_match('|^.*\s+$|', $tokenContent) !== 0) {
                $phpcsFile->addError('Trailing space', $stackPtr, 'EndLine');
            }
        }

    }//end process()


}//end class

?>
