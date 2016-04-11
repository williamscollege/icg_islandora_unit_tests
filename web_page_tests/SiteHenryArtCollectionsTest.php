<?php
//require_once dirname(__FILE__) . '/../CONF_for_testing.php';
//require_once dirname(__FILE__) . '/../simpletest/WMS_web_tester.php';
require_once('UnboundWebTestCase.php');

class SiteHenryArtCollectionsTest extends UnboundWebTestCase {

    function SiteHenryArtCollectionsTest() {
        $this->setUnboundSite('henryartcollections');
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
        echo "basic_image test case - NOT USED ON THIS SITE<br/>\n";
    }

    function TestContentModelDisplay_Book(){
        echo "book test case - NOT USED ON THIS SITE<br/>\n";
    }

    function TestContentModelDisplay_Compound(){
        echo "compound test case - NOT USED ON THIS SITE<br/>\n";
    }

    function TestContentModelDisplay_LargeImage(){
        $test_url = 'http://'.TARGET_HOST.'/henryartcollections/islandora/object/hopkinsforestmaps%3A109';
        echo "large_image test case - <a href=\"$test_url\">$test_url</a><br/>\n";
        $this->get($test_url);
        $this->standardResponseChecks();

        $this->assertPattern('/<div class="islandora-large-image-content">/');
        $this->assertPattern('/id="islandora-openseadragon"/');
        $this->assertPattern('/\\{"pid":"hopkinsforestmaps:109","resourceUri":"http:\\\\\/\\\\\/'.TARGET_HOST.'\\\\\/henryartcollections\\\\\/islandora\\\\\/object\\\\\/hopkinsforestmaps\\%3A109\\\\\/datastream\\\\\/JP2/');
    }

    function TestContentModelDisplay_PDF() {
        echo "PDF test case - NOT USED ON THIS SITE<br/>\n";
    }

    function TestContentModelDisplay_Video() {
        echo "video test case - NOT USED ON THIS SITE<br/>\n";
    }

    //############################################################

    function TestProjectLeadPage() {
        $this->get('http://'.TARGET_HOST.'/henryartcollections/project-lead');
        $this->standardResponseChecks();
    }

    function TestObject_Collection() {
        $this->get('http://'.TARGET_HOST.'/henryartcollections/islandora/object/hopkinsforestmaps%3Aimages');
        $this->standardResponseChecks();
    }

    function TestObject_Specific() {
        $this->get('http://'.TARGET_HOST.'/henryartcollections/islandora/object/hopkinsforestmaps%3A70');
        $this->standardResponseChecks();
    }

    function TestSearch_SubjectGeographic() {
        $this->get('http://'.TARGET_HOST.'/henryartcollections/islandora/search?f[0]=mods_subject_geographic_ms%3A"Hopkins%5C%20Memorial%5C%20Forest"');
        $this->standardResponseChecks();
    }

    function TestSearch_Sort_Title() {
        $this->get('http://'.TARGET_HOST.'/henryartcollections/islandora/search/%20?sort=sort.title%20asc');
        $this->standardResponseChecks();
    }

}