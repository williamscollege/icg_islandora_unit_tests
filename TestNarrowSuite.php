<?php
require_once('simpletest/autorun.php');
require_once('simpletest/WMS_web_tester.php');
SimpleTest::prefer(new TextReporter());


class TestNarrowSuite extends TestSuite {
    function TestNarrowSuite() {
        $this->TestSuite('Narrowly focused tests - changes');

        # Tests
//        $this->addFile('web_page_tests/Site_Unbound_Test.php');
//        $this->addFile('web_page_tests/SiteRonadhCoxTest.php');
        $this->addFile('web_page_tests/SiteFacultyPublicationsTest.php');
//        $this->addFile('web_page_tests/Site_Unbound_Test.php');

		# Sound Effect
		$this->addFile('soundForTesting.php');
     }
}
?>