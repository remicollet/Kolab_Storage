<?php
/**
 * A stop watch decorator for outgoing requests from the Kolab storage drivers.
 *
 * PHP version 5
 *
 * @category Kolab
 * @package  Kolab_Storage
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.fsf.org/copyleft/lgpl.html LGPL
 * @link     http://pear.horde.org/index.php?package=Kolab_Storage
 */

/**
 * A stop watch decorator for outgoing requests from the Kolab storage drivers.
 *
 * Copyright 2010 The Horde Project (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @category Kolab
 * @package  Kolab_Storage
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.fsf.org/copyleft/lgpl.html LGPL
 * @link     http://pear.horde.org/index.php?package=Kolab_Storage
 */
class Horde_Kolab_Storage_Driver_Decorator_Timer
extends Horde_Kolab_Storage_Driver_Decorator_Base
{
    /**
     * A log handler.
     *
     * @var mixed
     */
    private $_logger;

    /**
     * A stop watch.
     *
     * @var Horde_Support_Timer
     */
    private $_timer;

    /**
     * Constructor.
     *
     * @param Horde_Kolab_Storage_Driver $driver The decorated driver.
     * @param Horde_Support_Timer        $timer  A stop watch.
     * @param mixed                      $logger The log handler. This instance
     *                                           must provide the info() method.
     */
    public function __construct(
        Horde_Kolab_Storage_Driver $driver,
        Horde_Support_Timer $timer,
        $logger
    ) {
        $this->_logger = $logger;
        $this->_timer = $timer;
        parent::__construct($driver);
    }

    /**
     * Create the backend driver.
     *
     * @return mixed The backend driver.
     */
    public function createBackend()
    {
        $this->_timer->push();
        $result = parent::createBackend();
        $this->_logger->info(
            sprintf(
                'REQUEST OUT IMAP: %s ms [construct]',
                floor($this->_timer->pop() * 1000)
            )
        );
        return $result;
    }

    /**
     * Retrieves a list of mailboxes from the server.
     *
     * @return array The list of mailboxes.
     */
    public function getMailboxes()
    {
        $this->_timer->push();
        $result = parent::getMailboxes();
        $this->_logger->info(
            sprintf(
                'REQUEST OUT IMAP: %s ms [getMailboxes]',
                floor($this->_timer->pop() * 1000)
            )
        );
        return $result;
    }

    /**
     * Retrieves the specified annotation for the complete list of mailboxes.
     *
     * @param string $annotation The name of the annotation to retrieve.
     *
     * @return array An associative array combining the folder names as key with
     *               the corresponding annotation value.
     */
    public function listAnnotation($annotation)
    {
        $this->_timer->push();
        $result = parent::listAnnotation($annotation);
        $this->_logger->info(
            sprintf(
                'REQUEST OUT IMAP: %s ms [listAnnotation]',
                floor($this->_timer->pop() * 1000)
            )
        );
        return $result;
    }

    /**
     * Does the given folder exist?
     *
     * @param string $folder The folder to check.
     *
     * @return boolean True in case the folder exists, false otherwise.
     */
    public function exists($folder)
    {
    }

    /**
     * Opens the given folder.
     *
     * @param string $folder  The folder to open
     *
     * @return mixed  True in case the folder was opened successfully, a PEAR
     *                error otherwise.
     */
    public function select($folder)
    {
    }

    /**
     * Returns the status of the current folder.
     *
     * @param string $folder Check the status of this folder.
     *
     * @return array  An array that contains 'uidvalidity' and 'uidnext'.
     */
    public function status($folder)
    {
    }

    /**
     * Returns the message ids of the messages in this folder.
     *
     * @param string $folder Check the status of this folder.
     *
     * @return array  The message ids.
     */
    public function getUids($folder)
    {
    }

    /**
     * Create the specified folder.
     *
     * @param string $folder The folder to create.
     *
     * @return mixed True in case the operation was successfull, a
     *               PEAR error otherwise.
     */
    public function create($folder)
    {
    }

    /**
     * Delete the specified folder.
     *
     * @param string $folder  The folder to delete.
     *
     * @return mixed True in case the operation was successfull, a
     *               PEAR error otherwise.
     */
    public function delete($folder)
    {
    }

    /**
     * Rename the specified folder.
     *
     * @param string $old  The folder to rename.
     * @param string $new  The new name of the folder.
     *
     * @return mixed True in case the operation was successfull, a
     *               PEAR error otherwise.
     */
    public function rename($old, $new)
    {
    }

    /**
     * Appends a message to the current folder.
     *
     * @param string $mailbox The mailbox to append the message(s) to. Either
     *                        in UTF7-IMAP or UTF-8.
     * @param string $msg     The message to append.
     *
     * @return mixed  True or a PEAR error in case of an error.
     */
    public function appendMessage($mailbox, $msg)
    {
    }

    /**
     * Deletes messages from the current folder.
     *
     * @param integer $uids  IMAP message ids.
     *
     * @return mixed  True or a PEAR error in case of an error.
     */
    public function deleteMessages($mailbox, $uids)
    {
    }

    /**
     * Moves a message to a new folder.
     *
     * @param integer $uid        IMAP message id.
     * @param string $new_folder  Target folder.
     *
     * @return mixed  True or a PEAR error in case of an error.
     */
    public function moveMessage($old_folder, $uid, $new_folder)
    {
    }

    /**
     * Expunges messages in the current folder.
     *
     * @param string $mailbox The mailbox to append the message(s) to. Either
     *                        in UTF7-IMAP or UTF-8.
     *
     * @return mixed  True or a PEAR error in case of an error.
     */
    public function expunge($mailbox)
    {
    }

    /**
     * Retrieves the message headers for a given message id.
     *
     * @param string $mailbox The mailbox to append the message(s) to. Either
     *                        in UTF7-IMAP or UTF-8.
     * @param int $uid                The message id.
     * @param boolean $peek_for_body  Prefetch the body.
     *
     * @return mixed  The message header or a PEAR error in case of an error.
     */
    public function getMessageHeader($mailbox, $uid, $peek_for_body = true)
    {
    }

    /**
     * Retrieves the message body for a given message id.
     *
     * @param string $mailbox The mailbox to append the message(s) to. Either
     *                        in UTF7-IMAP or UTF-8.
     * @param integet $uid  The message id.
     *
     * @return mixed  The message body or a PEAR error in case of an error.
     */
    public function getMessageBody($mailbox, $uid)
    {
    }

    /**
     * Retrieve the access rights for a folder.
     *
     * @param Horde_Kolab_Storage_Folder $folder The folder to retrieve the ACL for.
     *
     * @return An array of rights.
     */
    public function getAcl(Horde_Kolab_Storage_Folder $folder)
    {
    }

    /**
     * Set the access rights for a folder.
     *
     * @param string $folder  The folder to act upon.
     * @param string $user    The user to set the ACL for.
     * @param string $acl     The ACL.
     *
     * @return NULL
     */
    public function setAcl($folder, $user, $acl)
    {
    }

    /**
     * Delete the access rights for user on a folder.
     *
     * @param string $folder  The folder to act upon.
     * @param string $user    The user to delete the ACL for
     *
     * @return NULL
     */
    public function deleteAcl($folder, $user)
    {
    }

    /**
     * Fetches the annotation on a folder.
     *
     * @param string $entry  The entry to fetch.
     * @param string $folder The name of the folder.
     *
     * @return string The annotation value.
     */
    public function getAnnotation($entry, $folder)
    {
    }

    /**
     * Sets the annotation on a folder.
     *
     * @param string $entry  The entry to set.
     * @param array  $value  The values to set
     * @param string $folder The name of the folder.
     *
     * @return NULL
     */
    public function setAnnotation($entry, $value, $folder)
    {
    }

    /**
     * Retrieve the namespace information for this connection.
     *
     * @return Horde_Kolab_Storage_Driver_Namespace The initialized namespace handler.
     */
    public function getNamespace()
    {
        $this->_timer->push();
        $result = parent::getNamespace();
        $this->_logger->info(
            sprintf(
                'REQUEST OUT IMAP: %s ms [getNamespace]',
                floor($this->_timer->pop() * 1000)
            )
        );
        return $result;
    }

    /**
     * Get the group handler for this connection.
     *
     * @return Horde_Group The group handler.
     */
    public function getGroupHandler()
    {
    }
}