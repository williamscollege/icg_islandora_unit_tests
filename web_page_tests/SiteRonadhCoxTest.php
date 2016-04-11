<?php
//require_once dirname(__FILE__) . '/../CONF_for_testing.php';
//require_once dirname(__FILE__) . '/../simpletest/WMS_web_tester.php';
require_once('UnboundWebTestCase.php');

class SiteRonadhCoxTest extends UnboundWebTestCase {

    function SiteRonadhCoxTest() {
        $this->setUnboundSite('ronadhcox');
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
        $test_url = 'http://'.TARGET_HOST.'/ronadhcox/islandora/object/lavaka%3A920';
        echo "basic_image test case - <a href=\"$test_url\">$test_url</a><br/>\n";
        $this->get($test_url);
        $this->standardResponseChecks();

        $this->assertPattern('/<div class="islandora-basic-image-content">/');
        $this->assertPattern('/src="\\/ronadhcox\\/islandora\\/object\\/lavaka\\%3A920\\/datastream\\/MEDIUM_SIZE\\/view"/');
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
        echo "PDF test case - NOT USED ON THIS SITE<br/>\n";
    }

    function TestContentModelDisplay_Video() {
        echo "video test case - NOT USED ON THIS SITE<br/>\n";
    }

    //############################################################

    function TestProjectLeadPage() {
        $this->get('http://'.TARGET_HOST.'/ronadhcox/project-lead');
        $this->standardResponseChecks();
    }

    function TestObject_Collection() {
        $this->get('http://'.TARGET_HOST.'/ronadhcox/islandora/object/sedimentology%3Aimages');
        $this->standardResponseChecks();
    }

    function TestObject_Specific() {
        $this->get('http://'.TARGET_HOST.'/ronadhcox/islandora/object/sedimentology%3A2');
        $this->standardResponseChecks();
    }

    function TestSearch_SubjectGeographic() {
        $this->get('http://'.TARGET_HOST.'/ronadhcox/islandora/search?f[0]=mods_subject_geographic_ms%3A%22Tsiroanomandidy%22');
        $this->standardResponseChecks();
    }

    function TestSearch_Sort_Title() {
        $this->get('http://'.TARGET_HOST.'/ronadhcox/islandora/search/%20?sort=sort.title%20asc');
        $this->standardResponseChecks();
    }

}