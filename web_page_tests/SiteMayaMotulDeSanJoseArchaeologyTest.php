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
        echo "audio test case - NOT USED ON THIS SITE<br/>\n";
    }

    function TestContentModelDisplay_BasicImage(){
        echo "basic image test case - NOT USED ON THIS SITE<br/>\n";
    }

    function TestContentModelDisplay_Book(){
        echo "book test case - NOT USED ON THIS SITE<br/>\n";
    }

    function TestContentModelDisplay_Compound(){
        echo "compound test case - NOT USED ON THIS SITE<br/>\n";
    }

    function TestContentModelDisplay_LargeImage(){
        $test_url = 'http://'.TARGET_HOST.'/mayamotuldesanjosearchaeology/islandora/object/motul%3A372';
        echo "large_image test case - <a href=\"$test_url\">$test_url</a><br/>\n";
        $this->get($test_url);
        $this->standardResponseChecks();

        $this->assertPattern('/<div class="islandora-large-image-content">/');
        $this->assertPattern('/id="islandora-openseadragon"/');
        $this->assertPattern('/\\{"pid":"motul:372","resourceUri":"http:\\\\\/\\\\\/'.TARGET_HOST.'\\\\\/mayamotuldesanjosearchaeology\\\\\/islandora\\\\\/object\\\\\/motul\\%3A372\\\\\/datastream\\\\\/JP2/');
    }

    function TestContentModelDisplay_PDF() {
        $test_url = 'http://'.TARGET_HOST.'/mayamotuldesanjosearchaeology/islandora/object/motul%3A519';
        echo "PDF test case - <a href=\"$test_url\">$test_url</a><br/>\n";
        $this->get($test_url);
        $this->standardResponseChecks();

        $this->assertPattern('/<div class="islandora-pdf-content">/');
        $this->assertPattern('/<iframe class="pdf"/');
        $this->assertPattern('/src="http:\\/\\/'.TARGET_HOST.'\\/mayamotuldesanjosearchaeology\\/sites\\/all\\/libraries\\/pdfjs\\/web\\/viewer.html\\?file=\\/mayamotuldesanjosearchaeology\\/islandora\\/object\\/motul\\%253A519\\/datastream\\/OBJ\\/view"/');
    }

    function TestContentModelDisplay_Video() {
        echo "video test case - NOT USED ON THIS SITE<br/>\n";
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

}