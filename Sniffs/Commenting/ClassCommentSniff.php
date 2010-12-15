<?php
/**
 * Parses and verifies the doc comments for classes.
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
 * @version   CVS: $Id: ClassCommentSniff.php 301632 2010-07-28 01:57:56Z squiz $
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

if (class_exists('PHP_CodeSniffer_CommentParser_ClassCommentParser', true) === false) {
    $error = 'Class PHP_CodeSniffer_CommentParser_ClassCommentParser not found';
    throw new PHP_CodeSniffer_Exception($error);
}

if (class_exists('ZendNew_Sniffs_Commenting_FileCommentSniff', true) === false) {
    $error = 'Class ZendNew_Sniffs_Commenting_FileCommentSniff not found';
    throw new PHP_CodeSniffer_Exception($error);
}

/**
 * Parses and verifies the doc comments for classes.
 * That's basically the same as the FileCommentSniff. So just register the
 * CLASS and INTERFACE tokens and let FileCommentSniff do the rest. *
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
 * @see       ZendNew_Sniffs_Commenting_FileCommentSniff
 */
class ZendNew_Sniffs_Commenting_ClassCommentSniff extends ZendNew_Sniffs_Commenting_FileCommentSniff
{


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
                T_CLASS,
                T_INTERFACE,
               );

    }//end register()


}//end class

?>
