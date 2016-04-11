<?php
require_once('simpletest/autorun.php');
require_once('simpletest/WMS_web_tester.php');
require_once dirname(__FILE__) . '/CONF_for_testing.php';
SimpleTest::prefer(new TextReporter());


class TestOfWebSuite extends TestSuite {
    function TestOfWebSuite() {
        $this->TestSuite('Unbound Site Tests');
        echo "running against ".TARGET_HOST."<br/><br/>\n";

        #######################################################
        # Tests: public access to the various unbound sites

        $this->addFile('web_page_tests/Site_Unbound_Test.php');
//
//        $this->addFile('web_page_tests/SiteFacultyPublicationsTest.php');
//
//        $this->addFile('web_page_tests/SiteMayaMotulDeSanJoseArchaeologyTest.php');
//
//        $this->addFile('web_page_tests/SiteRonadhCoxTest.php');
//
        $this->addFile('web_page_tests/SiteWilliamsArchivesTest.php');

//--------------------------------------------------------------

////        $this->addFile('web_page_tests/BasicSecurityTest.php');

////            $this->addFile('web_page_tests/SiteTest.php');

        # Sound Effect
        $this->addFile('soundForTesting.php');
    }
}
?>