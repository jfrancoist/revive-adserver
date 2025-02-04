<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

/**
 * OpenX Developer Toolbox
 */


class OX_DevToolbox
{
    /**
     * check access to an array of requried files/folders
     *
     *
     * @return array of error messages
     */
    public function checkFilePermissions($aFiles)
    {
        $aErrors = [];

        foreach ($aFiles as $file) {
            if (empty($file)) {
                continue;
            }
            if (!file_exists($file)) {
                $aErrors['errors'][] = sprintf("The file '%s' does not exist", $file);
            } elseif (!is_writable($file)) {
                if (is_dir($file)) {
                    $aErrors['errors'][] = sprintf("The directory '%s' is not writable", $file);
                    $aErrors['fixes'][] = sprintf("chmod -R a+w %s", $file);
                } else {
                    $aErrors['errors'][] = sprintf("The file '%s' is not writable", $file);
                    $aErrors['fixes'][] = sprintf("chmod a+w %s", $file);
                }
            }
        }

        if (count($aErrors)) {
            return $aErrors;
        }
        return true;
    }

    /**
     * create a new database with the given name
     * check first and drop if necessary
     *
     * @param string $database_name
     * @return boolean
     */
    /*function _createDatabase($database_name)
    {
        if ($this->_dropDatabase($database_name))
        {
            $this->aDB_definition['name'] = $database_name;
            if ($this->oSchema->db->manager->createDatabase($database_name))
            {
                $this->oSchema->db = OA_DB::changeDatabase($database_name);
                $oaTable = new OA_DB_Table();
                $oaTable->oSchema = $this->oSchema;
                $oaTable->aDefinition = $this->aDB_definition;
                return $oaTable->createAllTables();
            }
        }
        return false;
    }*/

    /**
     * check if given database exists and drop if it does
     *
     * @param string $database_name
     * @return boolean
     */
    /*function _dropDatabase($database_name)
    {
        if ($this->_databaseExists($database_name))
        {
            $this->oSchema->db->manager->dropDatabase($database_name);
        }
        return (!$this->_databaseExists($database_name));
    }*/

    /**
     * check if a given database name is in use
     *
     * @param string $database_name
     * @return boolean
     */
    /*function _databaseExists($database_name)
    {
        $result = $this->oSchema->db->manager->listDatabases();
        if (PEAR::isError($result))
        {
            $this->oLogger->logError($result->getUserInfo());
            return false;
        }
        return in_array(strtolower($database_name), array_map('strtolower', $result));
    }*/
}
