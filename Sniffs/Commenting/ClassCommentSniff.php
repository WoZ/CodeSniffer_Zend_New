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
class ZendNew_Sniffs_Commenting_ClassCommentSniff extends PEAR_Sniffs_Commenting_ClassCommentSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Tags in correct order and related info.
     *
     * @var array
     */
    protected $tags = array(
                       'category'   => array(
                                        'required'       => false,
                                        'allow_multiple' => false,
                                        'order_text'     => 'precedes @package',
                                       ),
                       'package'    => array(
                                        'required'       => true,
                                        'allow_multiple' => false,
                                        'order_text'     => 'follows @category',
                                       ),
                       'subpackage' => array(
                                        'required'       => false,
                                        'allow_multiple' => false,
                                        'order_text'     => 'follows @package',
                                       ),
                       'author'     => array(
                                        'required'       => false,
                                        'allow_multiple' => true,
                                        'order_text'     => 'follows @subpackage (if used) or @package',
                                       ),
                       'copyright'  => array(
                                        'required'       => false,
                                        'allow_multiple' => true,
                                        'order_text'     => 'follows @author',
                                       ),
                       'license'    => array(
                                        'required'       => false,
                                        'allow_multiple' => false,
                                        'order_text'     => 'follows @copyright (if used) or @author',
                                       ),
                       'version'    => array(
                                        'required'       => false,
                                        'allow_multiple' => false,
                                        'order_text'     => 'follows @license',
                                       ),
                       'link'       => array(
                                        'required'       => false,
                                        'allow_multiple' => true,
                                        'order_text'     => 'follows @version',
                                       ),
                       'see'        => array(
                                        'required'       => false,
                                        'allow_multiple' => true,
                                        'order_text'     => 'follows @link',
                                       ),
                       'since'      => array(
                                        'required'       => false,
                                        'allow_multiple' => false,
                                        'order_text'     => 'follows @see (if used) or @link',
                                       ),
                       'deprecated' => array(
                                        'required'       => false,
                                        'allow_multiple' => false,
                                        'order_text'     => 'follows @since (if used) or @see (if used) or @link',
                                       ),
                );

    /**
     * Process the version tag.
     *
     * @param int $errorPos The line number where the error occurs.
     *
     * @return void
     */
    protected function processVersion($errorPos)
    {
        $version = $this->commentParser->getVersion();
        if ($version !== null) {
            $content = $version->getContent();
            $matches = array();
            if (empty($content) === true) {
                $error = 'Content missing for @version tag in file comment';
                $this->currentFile->addError($error, $errorPos, 'EmptyVersion');
            }
        }

    }//end processVersion()

    /**
     * Process the copyright tags.
     *
     * @param int $commentStart The position in the stack where
     *                          the comment started.
     *
     * @return void
     */
    protected function processCopyrights($commentStart)
    {
        $copyrights = $this->commentParser->getCopyrights();

        foreach ($copyrights as $copyright) {

            $errorPos = ($commentStart + $copyright->getLine());

            $content = $copyright->getContent();

            if (empty($content)) {

                $this->currentFile->addError('A copyright-tag must have content', $errorPos, 'CopyrightNoContent');

            }

        }

    }

}//end class

?>
