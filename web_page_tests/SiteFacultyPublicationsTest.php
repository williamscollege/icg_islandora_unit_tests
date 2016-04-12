<?php
//require_once dirname(__FILE__) . '/../CONF_for_testing.php';
//require_once dirname(__FILE__) . '/../simpletest/WMS_web_tester.php';
require_once('UnboundWebTestCase.php');

class SiteFacultyPublicationsTest extends UnboundWebTestCase {

    function SiteFacultyPublicationsTest() {
        $this->setUnboundSite('facultypublications');
        echo "\n<br/><br/>\n<b>TESTING SITE ".$this->getTestingUrlBase()."</b><br/>\n";
    }

    //############################################################

    function TestSiteBasics() {
        $this->doStandardBasicSiteTests();
    }

    //############################################################

    function TestContentModelDisplay_Audio() {
        $this->doContentModelTest_Audio('','','');
    }

    function TestContentModelDisplay_BasicImage() {
        $this->doContentModelTest_BasicImage('','','');
    }

    function TestContentModelDisplay_Book(){
        $this->doContentModelTest_Book('','','');
    }

    function TestContentModelDisplay_Compound(){
        $this->doContentModelTest_Compound('','','');
    }

    function TestContentModelDisplay_LargeImage(){
        $this->doContentModelTest_LargeImage('','','');
    }

    function TestContentModelDisplay_PDF() {
        $this->doContentModelTest_PDF('facultypublications','facultyarticles','135');
    }

    function TestContentModelDisplay_Video() {
        $this->doContentModelTest_Video('','','');
    }

    //############################################################

    function TestObject_Specific() {
        $this->get('http://'.TARGET_HOST.'/facultypublications/islandora/object/facultyarticles%3A15');
        $this->standardResponseChecks();
    }

    function TestObjectDisplayMetadataLabels() {
        $this->get('http://'.TARGET_HOST.'/facultypublications/islandora/object/facultyarticles%3A139');
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