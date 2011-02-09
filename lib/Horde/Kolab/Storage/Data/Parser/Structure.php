<?php
/**
 * Parses an object by relying on the MIME capabilities of the backend.
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
 * Parses an object by relying on the MIME capabilities of the backend.
er.
 *
 * Copyright 2011 The Horde Project (http://www.horde.org/)
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
class Horde_Kolab_Storage_Data_Parser_Structure
implements  Horde_Kolab_Storage_Data_Parser
{
    /**
     * The backend driver.
     *
     * @param Horde_Kolab_Storage_Driver
     */
    private $_driver;

    /**
     * The bridge between the backend object and the format parser.
     *
     * @param Horde_Kolab_Storage_Data_Format
     */
    private $_format;

    /**
     * Constructor
     *
     * @param Horde_Kolab_Storage_Driver      $driver The backend driver.
     * @param Horde_Kolab_Storage_Data_Format $format The data object <-> format
     *                                                bridge.
     */
    public function __construct(
        Horde_Kolab_Storage_Driver $driver,
        Horde_Kolab_Storage_Data_Format $format
    ) {
        $this->_driver = $driver;
        $this->_format = $format;
    }

    /**
     * Fetches the objects for the specified backend IDs.
     *
     * @param string $folder  The folder to access.
     * @param array  $obids   The object backend IDs to fetch.
     * @param array  $options Additional options for fetching.
     *
     * @return array The parsed objects.
     */
    public function fetch($folder, $obids, $options = array())
    {
        $objects = array();
        $structures = $this->_driver->fetchStructure($folder, $obids);
        foreach ($structures as $obid => $structure) {
            if (!isset($structure['structure'])) {
                throw new Horde_Kolab_Storage_Exception(
                    'Backend returned a structure without the expected "structure" element.'
                );
            }
            $objects[$obid] = $this->_format->parse($folder, $obid, $structure['structure'], $options);
            $this->_fetchAttachments($objects[$obid], $folder, $obid, $options);
        }
        return $objects;
    }

    /**
     * Completes the given object with any required attachments.
     *
     * @param array  $object  The object to fetch attachments for.
     * @param string $folder  The folder to access.
     * @param array  $obid    The object backend ID.
     * @param array  $options Additional options for fetching.
     *
     * @return NULL
     */
    private function _fetchAttachments(array &$object, $folder, $obid, $options = array())
    {
    }

    /**
     * Fetch the specified mime part.
     *
     * @param string $folder  The folder to access.
     * @param string $obid    The backend ID to parse from.
     * @param string $mime_id The ID of the part that should be fetched.
     *
     * @return resource A stream for the specified body part.
     */
    public function fetchPart($folder, $obid, $mime_id)
    {
        return $this->_driver->fetchBodypart($folder, $obid, $mime_id);
    }
}
