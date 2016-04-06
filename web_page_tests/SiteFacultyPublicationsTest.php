<?php
//require_once dirname(__FILE__) . '/../CONF_for_testing.php';
//require_once dirname(__FILE__) . '/../simpletest/WMS_web_tester.php';
require_once('UnboundWebTestCase.php');

class SiteFacultyPublicationsTest extends UnboundWebTestCase {

    //############################################################

    function TestSiteBasics() {
        $this->setUnboundSite('facultypublications');
        $this->doStandardBasicSiteTests();
    }

    //############################################################

    function TestObject_Specific() {
        $this->get('http://'.TARGET_HOST.'/facultypublications/islandora/object/facultyarticles%3A15');
        $this->standardResponseChecks();
    }

    function TestObjectDisplayMetadataLabels() {
        $this->get('http://'.TARGET_HOST.'/facultypublications/islandora/object/facultyarticles%3A159');
        $this->standardResponseChecks();

        $this->assertPattern('/AUTHOR/i');
        $this->assertPattern('/DEPARTMENT/i');
    }

    //############################################################

    function TestSearch_Author() {
        $this->get('http://'.TARGET_HOST.'/facultypublications/islandora/search?f[0]=mods_name_Author_ms%3A%22Morgan%5C%20McGuire%5C%20%22');
        $this->standardResponseChecks();
    }

    function TestSearch_SortTitle() {
        $this->get('http://'.TARGET_HOST.'/facultypublications/islandora/search/%20?sort=sort.title%20asc');
        $this->standardResponseChecks();
    }

}