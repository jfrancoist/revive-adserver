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

require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/OA/DB/Table.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * A class for testing the OA_DB_Table class.
 *
 * @package    OpenXDB
 * @subpackage TestSuite
 */
class Test_OA_DB_Table extends UnitTestCase
{
    /**
     * The constructor method.
     */
    public function __construct()
    {
        parent::__construct();

        // Mock the OA_DB class
        Mock::generate('OA_DB');

        // Partially mock the OA_DB_Table class
        Mock::generatePartial(
            'OA_DB_Table',
            'PartialMockOA_DB_Table',
            ['_getDbConnection']
        );
    }

    /**
     * A private method to write out a test database schema in XML.
     *
     * @access private
     */
    public function _writeTestDatabaseSchema()
    {
        $fp = fopen(MAX_PATH . '/var/test.xml', 'w');
        fwrite($fp, '<?xml version="1.0" encoding="ISO-8859-1" ?>');
        fwrite($fp, '<database>');
        fwrite($fp, ' <name>test_db</name>');
        fwrite($fp, ' <create>true</create>');
        fwrite($fp, ' <overwrite>false</overwrite>');
        fwrite($fp, ' <table>');
        fwrite($fp, '  <name>test_table</name>');
        fwrite($fp, '  <declaration>');
        fwrite($fp, '   <field>');
        fwrite($fp, '    <name>test_column</name>');
        fwrite($fp, '    <type>integer</type>');
        fwrite($fp, '    <length>4</length>');
        fwrite($fp, '    <notnull>true</notnull>');
        fwrite($fp, '   </field>');
        fwrite($fp, '  </declaration>');
        fwrite($fp, ' </table>');
        fwrite($fp, '</database>');
        fclose($fp);
    }
    /**
     * A private method to write out a bigger test database schema in XML.
     *
     * @access private
     */
    public function _writeBigTestDatabaseSchema()
    {
        $fp = fopen(MAX_PATH . '/var/test.xml', 'w');
        fwrite($fp, '<?xml version="1.0" encoding="ISO-8859-1" ?>');
        fwrite($fp, '<database>');
        fwrite($fp, ' <name>test_db</name>');
        fwrite($fp, ' <create>true</create>');
        fwrite($fp, ' <overwrite>false</overwrite>');
        fwrite($fp, ' <table>');
        fwrite($fp, '  <name>test_table</name>');
        fwrite($fp, '  <declaration>');
        fwrite($fp, '   <field>');
        fwrite($fp, '    <name>test_column</name>');
        fwrite($fp, '    <type>integer</type>');
        fwrite($fp, '    <length>4</length>');
        fwrite($fp, '    <notnull>true</notnull>');
        fwrite($fp, '   </field>');
        fwrite($fp, '  </declaration>');
        fwrite($fp, ' </table>');
        fwrite($fp, ' <table>');
        fwrite($fp, '  <name>the_second_table</name>');
        fwrite($fp, '  <declaration>');
        fwrite($fp, '   <field>');
        fwrite($fp, '    <name>test_column</name>');
        fwrite($fp, '    <type>integer</type>');
        fwrite($fp, '    <length>4</length>');
        fwrite($fp, '    <notnull>true</notnull>');
        fwrite($fp, '   </field>');
        fwrite($fp, '  </declaration>');
        fwrite($fp, ' </table>');
        fwrite($fp, '</database>');
        fclose($fp);
    }

    public function _writeSequenceTestDatabaseSchema()
    {
        $fp = fopen(MAX_PATH . '/var/test.xml', 'w');
        fwrite($fp, '<?xml version="1.0" encoding="ISO-8859-1" ?>');
        fwrite($fp, '<database>');
        fwrite($fp, ' <name>test_db</name>');
        fwrite($fp, ' <create>true</create>');
        fwrite($fp, ' <overwrite>false</overwrite>');
        fwrite($fp, ' <table>');
        fwrite($fp, '  <name>test_table1</name>');
        fwrite($fp, '  <declaration>');
        fwrite($fp, '   <field>');
        fwrite($fp, '    <name>test_id1</name>');
        fwrite($fp, '    <type>openads_mediumint</type>');
        fwrite($fp, '    <unsigned>true</unsigned>');
        fwrite($fp, '    <length>9</length>');
        fwrite($fp, '    <notnull>true</notnull>');
        fwrite($fp, '    <default>0</default>');
        fwrite($fp, '    <autoincrement>1</autoincrement>');
        fwrite($fp, '   </field>');
        fwrite($fp, '   <field>');
        fwrite($fp, '    <name>test_desc1</name>');
        fwrite($fp, '    <type>openads_varchar</type>');
        fwrite($fp, '    <length>32</length>');
        fwrite($fp, '    <notnull>true</notnull>');
        fwrite($fp, '    <default></default>');
        fwrite($fp, '   </field>');
        fwrite($fp, '   <index>');
        fwrite($fp, '    <name>test_table1_pkey</name>');
        fwrite($fp, '    <primary>true</primary>');
        fwrite($fp, '    <field>');
        fwrite($fp, '     <name>test_id1</name>');
        fwrite($fp, '     <sorting>ascending</sorting>');
        fwrite($fp, '    </field>');
        fwrite($fp, '   </index>');
        fwrite($fp, '  </declaration>');
        fwrite($fp, ' </table>');
        fwrite($fp, ' <table>');
        fwrite($fp, '  <name>test_table2</name>');
        fwrite($fp, '  <declaration>');
        fwrite($fp, '   <field>');
        fwrite($fp, '    <name>test_id2</name>');
        fwrite($fp, '    <type>openads_mediumint</type>');
        fwrite($fp, '    <unsigned>true</unsigned>');
        fwrite($fp, '    <length>9</length>');
        fwrite($fp, '    <notnull>true</notnull>');
        fwrite($fp, '    <default>0</default>');
        fwrite($fp, '    <autoincrement>1</autoincrement>');
        fwrite($fp, '   </field>');
        fwrite($fp, '   <field>');
        fwrite($fp, '    <name>test_desc2</name>');
        fwrite($fp, '    <type>openads_varchar</type>');
        fwrite($fp, '    <length>32</length>');
        fwrite($fp, '    <notnull>true</notnull>');
        fwrite($fp, '    <default></default>');
        fwrite($fp, '   </field>');
        fwrite($fp, '   <index>');
        fwrite($fp, '    <name>test_table2_pkey</name>');
        fwrite($fp, '    <primary>true</primary>');
        fwrite($fp, '    <field>');
        fwrite($fp, '     <name>test_id2</name>');
        fwrite($fp, '     <sorting>ascending</sorting>');
        fwrite($fp, '    </field>');
        fwrite($fp, '   </index>');
        fwrite($fp, '  </declaration>');
        fwrite($fp, ' </table>');
        fwrite($fp, '</database>');
        fclose($fp);
    }


    /**
     * A private method to write out a test database schema with string types in XML.
     *
     * @access private
     */
    public function _writeStringTestDatabaseSchema()
    {
        $fp = fopen(MAX_PATH . '/var/test.xml', 'w');
        fwrite($fp, '<?xml version="1.0" encoding="ISO-8859-1" ?>');
        fwrite($fp, '<database>');
        fwrite($fp, ' <name>test_db</name>');
        fwrite($fp, ' <create>true</create>');
        fwrite($fp, ' <overwrite>false</overwrite>');
        fwrite($fp, ' <table>');
        fwrite($fp, '  <name>test_table</name>');
        fwrite($fp, '  <declaration>');
        fwrite($fp, '   <field>');
        fwrite($fp, '    <name>test_column</name>');
        fwrite($fp, '    <type>openads_varchar</type>');
        fwrite($fp, '    <length>10</length>');
        fwrite($fp, '    <notnull>true</notnull>');
        fwrite($fp, '   </field>');
        fwrite($fp, '  </declaration>');
        fwrite($fp, ' </table>');
        fwrite($fp, ' <table>');
        fwrite($fp, '  <name>the_second_table</name>');
        fwrite($fp, '  <declaration>');
        fwrite($fp, '   <field>');
        fwrite($fp, '    <name>test_column</name>');
        fwrite($fp, '    <type>openads_varchar</type>');
        fwrite($fp, '    <length>10</length>');
        fwrite($fp, '    <notnull>true</notnull>');
        fwrite($fp, '   </field>');
        fwrite($fp, '  </declaration>');
        fwrite($fp, ' </table>');
        fwrite($fp, '</database>');
        fclose($fp);
    }

    /**
     * A method to test the constructor method.
     *
     * Requirements:
     * Test 1: Ensure the constructor correctly creates and registers
     *         an OA_DB object.
     */
    public function testConstructor()
    {
        // Mock the OA_DB class
        $oDbh = new MockOA_DB($this);

        // Partially mock the OA_DB_Table class
        $oTable = new PartialMockOA_DB_Table($this);
        $oTable->setReturnReference('_getDbConnection', $oDbh);

        // Test 1
        $this->assertEqual(strtolower(get_class($oTable)), strtolower('PartialMockOA_DB_Table'));
        $oDbhReturn = $oTable->_getDbConnection();
        $this->assertIdentical($oDbh, $oDbhReturn);
    }

    /**
     * A method to test the init method.
     *
     * Requirements:
     * Test 1: Check that false is returned if the XML file is null.
     * Test 2: Check that false is returned if the XML file does not exist.
     * Test 3: Check that false is returned if the XML file is invalid.
     * Test 4: Check that true is returned if the XML file is valid.
     */
    public function testInit()
    {
        $oTable = new OA_DB_Table();

        // Test 1
        $return = $oTable->init(null);
        $this->assertFalse($return);

        // Test 2
        $errorReporting = error_reporting();
        error_reporting($errorReporting ^ E_WARNING);
        $return = $oTable->init(MAX_PATH . '/this_file_doesnt_exist.xml');
        error_reporting($errorReporting);
        $this->assertFalse($return);

        // Test 3
        $fp = fopen(MAX_PATH . '/var/test.xml', 'w');
        fwrite($fp, "asdf;");
        fclose($fp);
        RV::disableErrorHandling();
        $return = $oTable->init(MAX_PATH . '/var/test.xml');
        RV::enableErrorHandling();
        $this->assertFalse($return);

        // Test 4
        $this->_writeTestDatabaseSchema();
        $return = $oTable->init(MAX_PATH . '/var/test.xml');
        $this->assertTrue($return);

        unlink(MAX_PATH . '/var/test.xml');
    }

    /**
     * A method to test the listing of OpenX tables with case sensitivity *on*
     *
     */
    public function test_listOATablesCaseSensitive()
    {
        $aTables = OA_DB_Table::listOATablesCaseSensitive();
        $this->assertIsA($aTables, 'array', '');
    }

    /**
     * A method to test the create table method.
     *
     * Requirements:
     * Test 1: Test that a table can be created.
     * Test 2: Test character sets are set correctly (mysql specific).
     * Test 3: Test table created with prefix
     * Test 4: Test table created with uppercase prefix
     */
    public function testCreateTable()
    {
        // Test 1
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = OA_DB::singleton();
        $conf['table']['prefix'] = '';
        $oTable = new OA_DB_Table();
        $this->_writeTestDatabaseSchema();
        $oTable->init(MAX_PATH . '/var/test.xml');
        $oTable->createTable('test_table');
        $aExistingTables = OA_DB_Table::listOATablesCaseSensitive();
        $this->assertEqual($aExistingTables[0], 'test_table');
        $this->assertTrue($oTable->dropTable('test_table'));

        // Test 2
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = OA_DB::singleton();
        $conf['table']['prefix'] = 'oatest_';
        $oTable = new OA_DB_Table();
        $this->_writeTestDatabaseSchema();
        $oTable->init(MAX_PATH . '/var/test.xml');
        $oTable->createTable('test_table');
        $aExistingTables = OA_DB_Table::listOATablesCaseSensitive();
        $this->assertEqual($aExistingTables[0], 'oatest_test_table');
        $oTable->dropTable('oatest_test_table');

        // Test 3
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = OA_DB::singleton();
        $conf['table']['prefix'] = 'OATEST_';
        $oTable = new OA_DB_Table();
        $this->_writeTestDatabaseSchema();
        $oTable->init(MAX_PATH . '/var/test.xml');
        $oTable->createTable('test_table');
        $aExistingTables = OA_DB_Table::listOATablesCaseSensitive();
        $this->assertEqual($aExistingTables[0], 'OATEST_test_table');
        $oTable->dropTable('OATEST_test_table');

        TestEnv::restoreConfig();
    }

    /**
     * A method to test the create all tables method.
     *
     * Requirements:
     * Test 1: Test that a table can be created.
     * Test 2: Test that multiple tables can be created.
     */
    public function testCreateAllTables()
    {
        // Test 1
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = OA_DB::singleton();
        $conf['table']['prefix'] = '';
        $oTable = new OA_DB_Table();
        $this->_writeTestDatabaseSchema();
        $oTable->init(MAX_PATH . '/var/test.xml');
        $oTable->createAllTables();
        $aExistingTables = OA_DB_Table::listOATablesCaseSensitive();
        $this->assertEqual($aExistingTables[0], 'test_table');
        $oTable->dropTable('test_table');

        // Test 2
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = OA_DB::singleton();
        $conf['table']['prefix'] = '';
        $oTable = new OA_DB_Table();
        $this->_writeBigTestDatabaseSchema();
        $oTable->init(MAX_PATH . '/var/test.xml');
        $oDate = new Date();
        $oTable->createAllTables($oDate);
        $aExistingTables = OA_DB_Table::listOATablesCaseSensitive();
        $this->assertEqual($aExistingTables[0], 'test_table');
        $this->assertEqual($aExistingTables[1], 'the_second_table');
        unlink(MAX_PATH . '/var/test.xml');
        $oTable->dropTable('test_table');
        $oTable->dropTable('the_second_table');

        TestEnv::restoreConfig();
    }

    public function test_resetSequence()
    {
        $oDbh = OA_DB::singleton();
        if ($oDbh->dbsyntax == 'pgsql') {
            $sequence = 'test_table1_test_id1_seq';
        } elseif ($oDbh->dbsyntax == 'mysql' || $oDbh->dbsyntax == 'mysqli') {
            $sequence = 'test_table1';
        }
        $conf = &$GLOBALS['_MAX']['CONF'];
        $conf['table']['prefix'] = '';
        $oTable = new OA_DB_Table();
        $this->_writeSequenceTestDatabaseSchema();
        $oTable->init(MAX_PATH . '/var/test.xml');
        $oTable->createTable('test_table1');
        $aExistingTables = OA_DB_Table::listOATablesCaseSensitive();
        $this->assertEqual($aExistingTables[0], 'test_table1');

        if ($oDbh->dbsyntax == 'pgsql') {
            OA_DB::setCaseSensitive();
            $aSequences = $oDbh->manager->listSequences();
            OA_DB::disableCaseSensitive();
            $this->assertEqual($aSequences[0], 'test_table1_test_id1');
        }

        for ($i = 1;$i < 11;$i++) {
            $query = "INSERT INTO " . $oDbh->quoteIdentifier('test_table1', true) . " (test_desc1) VALUES ('{$i}')";
            $oDbh->query($query);
        }
        $query = "SELECT * FROM " . $oDbh->quoteIdentifier('test_table1', true);
        $aRows = $oDbh->queryAll($query);
        $this->assertEqual(count($aRows), 10, 'incorrect number of rows in test_table1');
        reset($aRows);
        foreach ($aRows as $k => $v) {
            $this->assertTrue($v['test_id1'] == $v['test_desc1'], 'sequence problem with new table');
        }
        $query = "DELETE FROM " . $oDbh->quoteIdentifier('test_table1', true);
        $oDbh->query($query);
        $query = "SELECT * FROM " . $oDbh->quoteIdentifier('test_table1', true);
        $aRows = $oDbh->queryAll($query);
        $this->assertEqual(count($aRows), 0, 'failed to delete rows from test_table1');

        $this->assertTrue($oTable->resetSequence($sequence), 'failed to reset sequence on test_table1');

        for ($i = 1;$i < 11;$i++) {
            $query = "INSERT INTO " . $oDbh->quoteIdentifier('test_table1', true) . " (test_desc1) VALUES ('{$i}')";
            $oDbh->query($query);
        }
        $query = "SELECT * FROM " . $oDbh->quoteIdentifier('test_table1', true);
        $aRows = $oDbh->queryAll($query);
        $this->assertEqual(count($aRows), 10, 'incorrect number of rows in test_table1');
        reset($aRows);
        foreach ($aRows as $k => $v) {
            $this->assertTrue($v['test_id1'] == $v['test_desc1'], 'sequence problem after reset: ' . $v['test_id1'] . '=>' . $v['test_desc1']);
        }
        $query = "DELETE FROM " . $oDbh->quoteIdentifier('test_table1', true);
        $oDbh->query($query);
        $query = "SELECT * FROM " . $oDbh->quoteIdentifier('test_table1', true);
        $aRows = $oDbh->queryAll($query);
        $this->assertEqual(count($aRows), 0, 'failed to delete rows from test_table1');

        // Test second parameter
        $this->assertTrue($oTable->resetSequence($sequence, 1000), 'failed to reset sequence on test_table1');

        $query = "INSERT INTO " . $oDbh->quoteIdentifier('test_table1', true) . " (test_desc1) VALUES ('1')";
        $oDbh->exec($query);

        $nextId = $oDbh->queryOne("SELECT test_id1 FROM " . $oDbh->quoteIdentifier('test_table1', true));

        if ($oDbh->dbsyntax == 'pgsql') {
            $this->assertEqual($nextId, 1000);
        } else {
            $this->assertEqual($nextId, 1);
        }

        $oTable->dropTable('test_table1');
        @unlink(MAX_PATH . '/var/test.xml');
    }

    /**
     * test reseting of all sequences
     *
     * @return boolean true on success, false otherwise
     */
    public function test_resetAllSequences()
    {
        $oDbh = OA_DB::singleton();
//        if ($oDbh->dbsyntax == 'pgsql')
//        {
//            $sequence = 'test_table1_test_id1_seq';
//        }
//        else if ($oDbh->dbsyntax == 'mysql')
//        {
//            $sequence = 'test_table1';
//        }
        $conf = &$GLOBALS['_MAX']['CONF'];
        $conf['table']['prefix'] = '';
        $oTable = new OA_DB_Table();
        $this->_writeSequenceTestDatabaseSchema();
        $oTable->init(MAX_PATH . '/var/test.xml');
        $oTable->createAllTables();
        $aExistingTables = OA_DB_Table::listOATablesCaseSensitive();
        $this->assertEqual($aExistingTables[0], 'test_table1');
        $this->assertEqual($aExistingTables[1], 'test_table2');

        if ($oDbh->dbsyntax == 'pgsql') {
            OA_DB::setCaseSensitive();
            $aSequences = $oDbh->manager->listSequences();
            OA_DB::disableCaseSensitive();
            $this->assertEqual($aSequences[0], 'test_table1_test_id1');
            $this->assertEqual($aSequences[1], 'test_table2_test_id2');
        }

        // table1
        for ($i = 1;$i < 11;$i++) {
            $query = "INSERT INTO " . $oDbh->quoteIdentifier('test_table1', true) . " (test_desc1) VALUES ('{$i}')";
            $oDbh->query($query);
        }
        $query = "SELECT * FROM " . $oDbh->quoteIdentifier('test_table1', true);
        $aRows = $oDbh->queryAll($query);
        $this->assertEqual(count($aRows), 10, 'incorrect number of rows in test_table1');
        reset($aRows);
        foreach ($aRows as $k => $v) {
            $this->assertTrue($v['test_id1'] == $v['test_desc1'], 'sequence problem with new table');
        }
        $query = "DELETE FROM " . $oDbh->quoteIdentifier('test_table1', true);
        $oDbh->query($query);
        $query = "SELECT * FROM " . $oDbh->quoteIdentifier('test_table1', true);
        $aRows = $oDbh->queryAll($query);
        $this->assertEqual(count($aRows), 0, 'failed to delete rows from test_table1');

        // table2
        for ($i = 1;$i < 11;$i++) {
            $query = "INSERT INTO " . $oDbh->quoteIdentifier('test_table2', true) . " (test_desc2) VALUES ('{$i}')";
            $oDbh->query($query);
        }
        $query = "SELECT * FROM " . $oDbh->quoteIdentifier('test_table2', true);
        $aRows = $oDbh->queryAll($query);
        $this->assertEqual(count($aRows), 10, 'incorrect number of rows in test_table2');
        reset($aRows);
        foreach ($aRows as $k => $v) {
            $this->assertTrue($v['test_id2'] == $v['test_desc2'], 'sequence problem with new table');
        }
        $query = "DELETE FROM " . $oDbh->quoteIdentifier('test_table2', true);
        $oDbh->query($query);
        $query = "SELECT * FROM " . $oDbh->quoteIdentifier('test_table2', true);
        $aRows = $oDbh->queryAll($query);
        $this->assertEqual(count($aRows), 0, 'failed to delete rows from test_table2');

        $this->assertTrue($oTable->resetAllSequences(), 'failed to reset all sequences');

        // table1
        for ($i = 1;$i < 11;$i++) {
            $query = "INSERT INTO " . $oDbh->quoteIdentifier('test_table1', true) . " (test_desc1) VALUES ('{$i}')";
            $oDbh->query($query);
        }
        $query = "SELECT * FROM " . $oDbh->quoteIdentifier('test_table1', true);
        $aRows = $oDbh->queryAll($query);
        $this->assertEqual(count($aRows), 10, 'incorrect number of rows in test_table1');
        reset($aRows);
        foreach ($aRows as $k => $v) {
            $this->assertTrue($v['test_id1'] == $v['test_desc1'], 'sequence problem after reset: ' . $v['test_id1'] . '=>' . $v['test_desc1']);
        }
        $oTable->dropTable('test_table1');

        // table2
        for ($i = 1;$i < 11;$i++) {
            $query = "INSERT INTO " . $oDbh->quoteIdentifier('test_table2', true) . " (test_desc2) VALUES ('{$i}')";
            $oDbh->query($query);
        }
        $query = "SELECT * FROM " . $oDbh->quoteIdentifier('test_table2', true);
        $aRows = $oDbh->queryAll($query);
        $this->assertEqual(count($aRows), 10, 'incorrect number of rows in test_table2');
        reset($aRows);
        foreach ($aRows as $k => $v) {
            $this->assertTrue($v['test_id2'] == $v['test_desc2'], 'sequence problem after reset: ' . $v['test_id2'] . '=>' . $v['test_desc2']);
        }
        $oTable->dropTable('test_table2');

        @unlink(MAX_PATH . '/var/test.xml');
    }

    /**
     * A method to test the create required tables method.
     *
     * Requirements:
     * Test 1: Test with the OA_DB_Table_Core class, using
     *         the banners table.
     */
    public function testCreateRequiredTables()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $conf['table']['prefix'] = '';
        $oDbh = OA_DB::singleton();
        $oTable = &OA_DB_Table_Core::singleton();
        $oTable->createRequiredTables('banners');
        $aExistingTables = OA_DB_Table::listOATablesCaseSensitive();
        $this->assertEqual($aExistingTables[0], 'accounts');
        $this->assertEqual($aExistingTables[1], 'agency');
        $this->assertEqual($aExistingTables[2], 'banners');
        $this->assertEqual($aExistingTables[3], 'campaigns');
        $this->assertEqual($aExistingTables[4], 'clients');
        $oTable->dropTable('accounts');
        $oTable->dropTable('agency');
        $oTable->dropTable('banners');
        $oTable->dropTable('campaigns');
        $oTable->dropTable('clients');

        TestEnv::restoreConfig();
    }

    /**
     * A method to test the drop table method.
     *
     * Requirements:
     * Test 1: Test that a table can be dropped.
     * Test 2: Test that a temporary table can be dropped.
     * Test 3: Test that a tablename with uppercase prefix can be dropped.
     * Test 4: Test that a tablename with a mixed prefix can be dropped.
     */
    public function testDropTable()
    {
        // Test 1
        $conf = &$GLOBALS['_MAX']['CONF'];
        $prefix = $conf['table']['prefix'];
        $oDbh = OA_DB::singleton();
        $table = $oDbh->quoteIdentifier($prefix . 'foo', true);
        $oTable = new OA_DB_Table();
        $query = "CREATE TABLE {$table} ( a INTEGER )";
        $oDbh->query($query);
        $aExistingTables = OA_DB_Table::listOATablesCaseSensitive();
        $this->assertEqual($aExistingTables[0], $prefix . 'foo');
        $this->assertTrue($oTable->dropTable($prefix . 'foo'));
        $aExistingTables = OA_DB_Table::listOATablesCaseSensitive();
        $this->assertEqual(count($aExistingTables), 0, $prefix . 'foo');
        //TestEnv::restoreEnv();

        // Test 2
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = OA_DB::singleton();
        $oTable = new OA_DB_Table();
        $table = $oDbh->quoteIdentifier($prefix . 'foo', true);
        $query = "CREATE TEMPORARY TABLE {$table} ( a INTEGER )";
        $oDbh->query($query);
        // Test table exists with an insert
        $query = "INSERT INTO {$table} (a) VALUES (37)";
        $result = $oDbh->query($query);
        $this->assertTrue($result);
        $this->assertTrue($oTable->dropTable($prefix . 'foo'));
        // Test table does not exist with an insert
        $query = "INSERT INTO {$table} (a) VALUES (37)";
        RV::disableErrorHandling();
        $result = $oDbh->query($query);
        RV::enableErrorHandling();
        $this->assertEqual(strtolower(get_class($result)), 'mdb2_error');
        //TestEnv::restoreEnv();

        // Test 3
        $conf = &$GLOBALS['_MAX']['CONF'];
        $conf['table']['prefix'] = 'OA_';
        $prefix = $conf['table']['prefix'];
        $oDbh = OA_DB::singleton();
        $table = $oDbh->quoteIdentifier($prefix . 'foo', true);
        $query = "CREATE TABLE {$table} ( a INTEGER )";
        $oDbh->query($query);
        $aExistingTables = OA_DB_Table::listOATablesCaseSensitive();
        $this->assertEqual($aExistingTables[0], 'OA_foo');
        $this->assertTrue($oTable->dropTable('OA_foo'));
        $aExistingTables = OA_DB_Table::listOATablesCaseSensitive();
        $this->assertEqual(count($aExistingTables), 0, 'Table OA_foo');

        //TestEnv::restoreEnv();

        // Test 4
        $conf = &$GLOBALS['_MAX']['CONF'];
        $conf['table']['prefix'] = 'oA_';
        $prefix = $conf['table']['prefix'];
        $oDbh = OA_DB::singleton();
        $table = $oDbh->quoteIdentifier($prefix . 'foo', true);
        $oTable = new OA_DB_Table();
        $query = "CREATE TABLE {$table} ( a INTEGER )";
        $oDbh->query($query);
        $aExistingTables = OA_DB_Table::listOATablesCaseSensitive();
        $this->assertEqual($aExistingTables[0], 'oA_foo');
        $this->assertTrue($oTable->dropTable('oA_foo'));
        $aExistingTables = OA_DB_Table::listOATablesCaseSensitive();
        $this->assertEqual(count($aExistingTables), 0, 'Table oA_foo');
        //TestEnv::restoreEnv();
    }
}
