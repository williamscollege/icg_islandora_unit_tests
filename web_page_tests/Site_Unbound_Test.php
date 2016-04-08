<?php
//require_once dirname(__FILE__) . '/../CONF_for_testing.php';
//require_once dirname(__FILE__) . '/../simpletest/WMS_web_tester.php';
require_once('UnboundWebTestCase.php');

class Site_Unbound_Test extends UnboundWebTestCase {

    function Site_Unbound_Test() {
        $this->setUnboundSite('');
        echo "\n<br/><br/>\n<b>TESTING SITE ".$this->getTestingUrlBase()."</b><br/>\n";
    }

    //############################################################

    function TestSiteBasics() {
        $this->doStandardBasicSiteTests();
    }

    function TestProjectLeads() {
        $this->get('http://'.TARGET_HOST.'/project-leads');
        $this->standardResponseChecks();
    }

    function TestStartAProject() {
        $this->get('http://'.TARGET_HOST.'/start-a-project');
        $this->standardResponseChecks();
    }

    function TestSearch_Type() {
        $this->get('http://'.TARGET_HOST.'/islandora/search?f[0]=dc.type%3A%22Physical%5C%20Object%22');
        $this->standardResponseChecks();
    }

    function TestCollectionAccessibility() {

        echo '<p>TODO: add the full list of collections to check for on the main site http://'.TARGET_HOST."</p>\n";

        $collections_ids_to_check = [
            'alexanderdavidson%3Aphotography'
            ,'architectural-plans%3Aimages'
            ,'pressimages2012%3Aimages'
            ,'daviscenter%3Aposters#'
        ];

        foreach ($collections_ids_to_check as $col_id) {

            $initialFailCount = $this->reporter->reporter->reporter->getFailCount();

            $this->get('http://'.TARGET_HOST.'/islandora/object/'.$col_id);
            $this->assertNoPattern('/Access denied/i');

            if ($this->reporter->reporter->reporter->getFailCount() > $initialFailCount) {
                echo "<br/><b style=\"color:#00a;\">collection accessibility failure for ".$this->getUrl()."</b><br/><br/>\n";
            }
        }
    }
/*
x-Audio - http://unbound-dev.williams.edu/islandora/object/daviscenter%3A80
x-Basic Image - http://unbound-dev.williams.edu/islandora/object/daviscenter%3A89
Compound -
Book -
x-Large Image - http://unbound-dev.williams.edu/islandora/object/motul%3A375
x-PDF - http://unbound-dev.williams.edu/islandora/object/facultyarticles%3A139
Video - http://unbound-dev.williams.edu/islandora/object/andyjaffe%3A42
*/
    function TestContentModelDisplay_Audio() {
        $test_url = 'http://'.TARGET_HOST.'/islandora/object/daviscenter%3A80';
        echo "audio test case - <a href=\"$test_url\">$test_url</a><br/>\n";
        $this->get($test_url);
        $this->standardResponseChecks();

        $this->assertPattern('/<div class="islandora-audio-content">/');
        $this->assertPattern('/<a href="http:\\/\\/'.TARGET_HOST.'\\/islandora\\/object\\/daviscenter\\%3A80\\/datastream\\/PROXY_MP3"><img typeof="foaf:Image" src="\\/islandora\\/object\\/daviscenter\\%3A80\\/datastream\\/TN\\/view"/');
    }

    function TestContentModelDisplay_BasicImage() {
        $test_url = 'http://'.TARGET_HOST.'/islandora/object/daviscenter%3A89';
        echo "basic_image test case - <a href=\"$test_url\">$test_url</a><br/>\n";
        $this->get($test_url);
        $this->standardResponseChecks();

        $this->assertPattern('/<div class="islandora-basic-image-content">/');
        $this->assertPattern('/src="\\/islandora\\/object\\/daviscenter\\%3A89\\/datastream\\/MEDIUM_SIZE\\/view"/');
    }

    function TestContentModelDisplay_LargeImage(){
        $test_url = 'http://'.TARGET_HOST.'/islandora/object/motul%3A375';
        echo "large_image test case - <a href=\"$test_url\">$test_url</a><br/>\n";
        $this->get($test_url);
        $this->standardResponseChecks();

        $this->assertPattern('/<div class="islandora-large-image-content">/');
        $this->assertPattern('/id="islandora-openseadragon"/');
        $this->assertPattern('/\\{"pid":"motul:375","resourceUri":"http:\\\\\/\\\\\/'.TARGET_HOST.'\\\\\/islandora\\\\\/object\\\\\/motul\\%3A375\\\\\/datastream\\\\\/JP2/');
    }

    function TestContentModelDisplay_PDF() {
        $test_url = 'http://'.TARGET_HOST.'/islandora/object/facultyarticles%3A139';
        echo "PDF test case - <a href=\"$test_url\">$test_url</a><br/>\n";
        $this->get($test_url);
        $this->standardResponseChecks();

        $this->assertPattern('/<div class="islandora-pdf-content">/');
        $this->assertPattern('/src="http:\\/\\/'.TARGET_HOST.'\\/sites\\/all\\/libraries\\/pdfjs\\/web\\/viewer.html\\?file=\\/islandora\\/object\\/facultyarticles\\%253A139\\/datastream\\/OBJ\\/view"/');
    }

    function TestContentModelDisplay_Video() {
        $test_url = 'http://'.TARGET_HOST.'/islandora/object/andyjaffe%3A42';
        echo "Video test case - <a href=\"$test_url\">$test_url</a><br/>\n";
        $this->get($test_url);
        $this->standardResponseChecks();

//        $this->assertPattern('/<div class="islandora-pdf-content">/');
//        $this->assertPattern('/src="http:\\/\\/'.TARGET_HOST.'\\/sites\\/all\\/libraries\\/pdfjs\\/web\\/viewer.html\\?file=\\/islandora\\/object\\/facultyarticles\\%253A139\\/datastream\\/OBJ\\/view"/');
    }


}