<?php
//require_once dirname(__FILE__) . '/../CONF_for_testing.php';
//require_once dirname(__FILE__) . '/../simpletest/WMS_web_tester.php';
require_once('UnboundWebTestCase.php');

class SiteWilliamsArchivesTest extends UnboundWebTestCase {

    function SiteWilliamsArchivesTest() {
        $this->setUnboundSite('williamsarchives');
        echo "\n<br/><br/>\n<b>TESTING SITE ".$this->getTestingUrlBase()."</b><br/>\n";
    }

    //############################################################

    function TestSiteBasics() {
        $this->doStandardBasicSiteTests();
    }

    //############################################################

    function TestArticlesPage() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/articles');
        $this->standardResponseChecks();
    }

    function TestCollectionsPage() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/collections');
        $this->standardResponseChecks();
    }

    //--------------------

    function TestContentModelDisplay_Audio() {
        $this->doContentModelTest_Audio('williamsarchives','andyjaffe','55');
    }

    function TestContentModelDisplay_BasicImage() {
        $this->doContentModelTest_BasicImage('williamsarchives','daviscenter','60');
    }

    function TestContentModelDisplay_Book(){
        $this->doContentModelTest_Book('williamsarchives','gulielmensian','2228');
    }

    function TestContentModelDisplay_Compound(){
        $this->doContentModelTest_Compound('','','');
    }

    function TestContentModelDisplay_LargeImage(){
        $this->doContentModelTest_LargeImage('','','');
    }

    function TestContentModelDisplay_PDF() {
        $this->doContentModelTest_PDF('williamsarchives','dwight','88');
    }

    function TestContentModelDisplay_Video() {
        $this->doContentModelTest_Video('williamsarchives','andyjaffe','42');
    }

//    function TestContentModelDisplay_Audio() {
//        $test_url = 'http://'.TARGET_HOST.'/williamsarchives/islandora/object/andyjaffe%3A55';
//        echo "audio test case - <a href=\"$test_url\">$test_url</a><br/>\n";
//        $this->get($test_url);
//        $this->standardResponseChecks();
//
//        $this->assertPattern('/<div class="islandora-audio-content">/');
//        $this->assertPattern('/"file":"http:\\\\\/\\\\\/'.TARGET_HOST.'\\\\\/williamsarchives\\\\\/islandora\\\\\/object\\\\\/andyjaffe%3A55\\\\\/datastream\\\\\/PROXY_MP3\\\\\/file_name_spoof.mp3"/');
//        $this->assertPattern('/<div id="mediaplayer">Loading JW Player...<\\/div>/');
//    }
//
//    function TestContentModelDisplay_BasicImage() {
//        $test_url = 'http://'.TARGET_HOST.'/williamsarchives/islandora/object/daviscenter%3A60';
//        echo "basic_image test case - <a href=\"$test_url\">$test_url</a><br/>\n";
//        $this->get($test_url);
//        $this->standardResponseChecks();
//
//        $this->assertPattern('/<div class="islandora-basic-image-content">/');
//        $this->assertPattern('/src="\\/williamsarchives\\/islandora\\/object\\/daviscenter\\%3A60\\/datastream\\/MEDIUM_SIZE\\/view"/');
////    }
//
//    function TestContentModelDisplay_Book() {
//        $test_url = 'http://'.TARGET_HOST.'/williamsarchives/islandora/object/gulielmensian%3A2228#page/1/mode/1up';
//        echo "book test case - <a href=\"$test_url\">$test_url</a><br/>\n";
//        $this->get($test_url);
//        $this->standardResponseChecks();
//
//        $this->assertPattern('/"islandoraInternetArchiveBookReader":\\{"book":"gulielmensian:2228"/');
//        $this->assertPattern('/<div id="book-viewer">/');
//        $this->assertPattern('/<div id="BookReader" class="islandora-internet-archive-bookreader">/');
//    }
//
//    function TestContentModelDisplay_Compound(){
//        echo "compound test case - NOT USED ON THIS SITE<br/>\n";
//    }
//
//    function TestContentModelDisplay_LargeImage(){
////        echo "large_image test case - NOT USED ON THIS SITE<br/>\n";
////    }
//
//    function TestContentModelDisplay_PDF() {
//        $test_url = 'http://'.TARGET_HOST.'/williamsarchives/islandora/object/dwight%3A88';
//        echo "PDF test case - <a href=\"$test_url\">$test_url</a><br/>\n";
//        $this->get($test_url);
//        $this->standardResponseChecks();
//
//        $this->assertPattern('/<div class="islandora-pdf-content">/');
//        $this->assertPattern('/<iframe class="pdf"/');
//        $this->assertPattern('/src="http:\\/\\/'.TARGET_HOST.'\\/williamsarchives\\/sites\\/all\\/libraries\\/pdfjs\\/web\\/viewer.html\\?file=(http%3A\\/\\/'.TARGET_HOST.'\\/|\\/)williamsarchives\\/islandora\\/object\\/dwight\\%253A88\\/datastream\\/OBJ\\/view"/');
////        echo $this->getBrowser()->getContent();
//    }
//
//    function TestContentModelDisplay_Video() {
//        $test_url = 'http://'.TARGET_HOST.'/williamsarchives/islandora/object/andyjaffe%3A42';
//        echo "Video test case - <a href=\"$test_url\">$test_url</a><br/>\n";
//        $this->get($test_url);
//        $this->standardResponseChecks();
//
//        $this->assertPattern('/"islandora_jwplayer":{"thumbnail":"http:\\\\\/\\\\\/'.TARGET_HOST.'\\\\\/williamsarchives\\\\\/islandora\\\\\/object\\\\\/andyjaffe\\%3A42\\\\\/datastream\\\\\/TN\\\\\/view","file":"\\\\\/williamsarchives\\\\\/islandora\\\\\/object\\\\\/andyjaffe\\%3A42\\\\\/datastream\\\\\/MP4\\\\\/view\\\\\/file_name_spoof.mp4"/');
//        $this->assertPattern('/<div class="islandora-video-content">/');
//        $this->assertPattern('/<div id="mediaplayer">Loading JW Player...<\\/div>/');
//    }

    //--------------------

    function Test_Collection_daviscenter_posters() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/islandora/object/daviscenter%3Aposters');
        $this->standardResponseChecks();
    }
    function Test_Object_daviscenter_posters() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/?q=islandora/object/daviscenter%3A32');
        $this->standardResponseChecks();
    }


    function Test_Collection_dively() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/islandora/object/dively%3Aposters');
        $this->standardResponseChecks();
    }
    function Test_Object_dively() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/?q=islandora/object/dively%3A26');
        $this->standardResponseChecks();
    }


    function Test_Collection_reily() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/islandora/object/reily%3Ascrapbook');
        $this->standardResponseChecks();
    }
    function Test_Object_reily() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/?q=islandora/object/reily%3A50');
        $this->standardResponseChecks();
    }


    function Test_Collection_communications() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/islandora/object/commencementcollection%3Aimages');
        $this->standardResponseChecks();
    }
    function Test_Object_communications() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/?q=islandora/object/communications%3A61');
        $this->standardResponseChecks();
    }


    function Test_Collection_andyjaffe() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/islandora/object/andyjaffe%3Aproject');
        $this->standardResponseChecks();
    }
    function Test_Object_andyjaffe() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/?q=islandora/object/andyjaffe%3A49');
        $this->standardResponseChecks();
    }


    function Test_Collection_alexanderdavidson() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/islandora/object/alexanderdavidson%3Aphotography');
        $this->standardResponseChecks();
    }
    function Test_Object_alexanderdavidson() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/?q=islandora/object/alexanderdavidson%3A152');
        $this->standardResponseChecks();
    }


    function Test_Collection_shakers_songbooks() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/islandora/object/shakers%3Asongbooks');
        $this->standardResponseChecks();
    }
    function Test_Object_shakers_songbooks() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/?q=islandora/object/shakers%3A35');
        $this->standardResponseChecks();
    }


    function Test_Collection_shakers_highlights() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/islandora/object/shakers%3Ahighlights');
        $this->standardResponseChecks();
    }
    function Test_Object_shakers_highlights() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/?q=islandora/object/shakers%3A63');
        $this->standardResponseChecks();
    }


    function Test_Collection_holley() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/islandora/object/holley%3Apapers');
        $this->standardResponseChecks();
    }
    function Test_Object_holley() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/?q=islandora/object/holley%3A20');
        $this->standardResponseChecks();
    }


    function Test_Collection_williams_higher_education() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/islandora/object/williams-higher-education%3Amixed-materials');
        $this->standardResponseChecks();
    }
    function Test_Object_williams_higher_education() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/?q=islandora/object/williams-higher-education%3A27');
        $this->standardResponseChecks();
    }


    function Test_Collection_daviscenter_videos() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/islandora/object/daviscenter%3Avideos');
        $this->standardResponseChecks();
    }
    function Test_Object_daviscenter_videos() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/?q=islandora/object/daviscenter%3A67');
        $this->standardResponseChecks();
    }


    function Test_Collection_dwight() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/islandora/object/dwight%3Apapers');
        $this->standardResponseChecks();
    }
    function Test_Object_dwight() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/?q=islandora/object/dwight%3A23');
        $this->standardResponseChecks();
    }


    function Test_Collection_psalmodiarchaeology() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/islandora/object/psalmodiarchaeology%3Aimages');
        $this->standardResponseChecks();
    }
    function Test_Object_psalmodiarchaeology() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/?q=islandora/object/psalmodiarchaeology%3A6');
        $this->standardResponseChecks();
    }

    //--------------------

    function TestSearch_DateCreated() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/?q=islandora/search&f[0]=mods_dateCreated_ms%3A%221898%22');
        $this->standardResponseChecks();
    }

    function TestSearch_Sort_CollectionMembership() {
        $this->get('http://'.TARGET_HOST.'/williamsarchives/?q=islandora/search/%20&sort=sort.collection%20asc');
        $this->standardResponseChecks();
    }
}