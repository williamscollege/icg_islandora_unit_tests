<?php
//require_once dirname(__FILE__) . '/../CONF_for_testing.php';
//require_once dirname(__FILE__) . '/../simpletest/WMS_web_tester.php';
require_once('UnboundWebTestCase.php');

class SiteMayaMotulDeSanJoseArchaeologyTest extends UnboundWebTestCase {

    function SiteMayaMotulDeSanJoseArchaeologyTest() {
        $this->setUnboundSite('mayamotuldesanjosearchaeology');
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
        $this->doContentModelTest_LargeImage('mayamotuldesanjosearchaeology','motul','372');
    }

    function TestContentModelDisplay_PDF() {
        $this->doContentModelTest_PDF('mayamotuldesanjosearchaeology','motul','519');
    }

    function TestContentModelDisplay_Video() {
        $this->doContentModelTest_Video('','','');
    }

    //############################################################


    function TestObject_Collection_Artifacts() {
        $this->get('http://'.TARGET_HOST.'/mayamotuldesanjosearchaeology/islandora/object/motul%253Amayaartifacts');
        $this->standardResponseChecks();
    }

    function TestObject_Specific_Artifact() {
        $this->get('http://'.TARGET_HOST.'/mayamotuldesanjosearchaeology/islandora/object/motul%3A239');
        $this->standardResponseChecks();
    }

    function TestObject_Collection_Publications() {
        $this->get('http://'.TARGET_HOST.'/mayamotuldesanjosearchaeology/islandora/object/motul%3Asitereports');
        $this->standardResponseChecks();
    }

    function TestObject_Specific_Publication() {
        $this->get('http://'.TARGET_HOST.'/mayamotuldesanjosearchaeology/islandora/object/motul%3A499');
        $this->standardResponseChecks();
    }

    function TestSearch_Operation() {
        $this->get('http://'.TARGET_HOST.'/mayamotuldesanjosearchaeology/islandora/search?f[0]=mods_note_operation_ms%3A%2210%22');
        $this->standardResponseChecks();
    }

    function TestSearch_Sort_Title() {
        $this->get('http://'.TARGET_HOST.'/mayamotuldesanjosearchaeology/islandora/search/%20?sort=sort.title%20asc');
        $this->standardResponseChecks();
    }

    function TestSearch_Facets() {
        $this->get('http://'.TARGET_HOST.'/mayamotuldesanjosearchaeology/islandora/search/');
        $this->standardFacetsChecks();
    }

}