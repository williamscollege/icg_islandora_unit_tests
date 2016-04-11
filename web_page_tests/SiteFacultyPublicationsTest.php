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
        echo "large_image test case - NOT USED ON THIS SITE<br/>\n";
    }

    function TestContentModelDisplay_PDF() {
        $test_url = 'http://'.TARGET_HOST.'/facultypublications/islandora/object/facultyarticles%3A135';
        echo "PDF test case - <a href=\"$test_url\">$test_url</a><br/>\n";
        $this->get($test_url);
        $this->standardResponseChecks();

        $this->assertPattern('/<div class="islandora-pdf-content">/');
        $this->assertPattern('/<iframe class="pdf"/');
        $this->assertPattern('/src="http:\\/\\/'.TARGET_HOST.'\\/facultypublications\\/sites\\/all\\/libraries\\/pdfjs\\/web\\/viewer.html\\?file=(http%3A\\/\\/'.TARGET_HOST.'\\/|\\/)facultypublications\\/islandora\\/object\\/facultyarticles\\%253A135\\/datastream\\/OBJ\\/view"/');
    }

    function TestContentModelDisplay_Video() {
        echo "video test case - NOT USED ON THIS SITE<br/>\n";
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