<?php
	require_once('simpletest/autorun.php');
	require_once('simpletest/web_tester_islandora.php');
	require_once dirname(__FILE__) . '/institution.cfg.php';
	require_once dirname(__FILE__) . '/util.php';
	SimpleTest::prefer(new TextReporter());


	class TestOfWebSuite extends TestSuite {
		function TestOfWebSuite() {
			$this->TestSuite('Islandora Site Tests');
			echo "Running against: " . FULL_APP_URL . "<br/><br/>\n";

			#############################################################
			# Tests: public access to the various Islandora sites
			#############################################################

			$this->addFile('web_page_tests/Security_Basic_Fedora_Test.php');
			$this->addFile('web_page_tests/Security_Basic_Web_Test.php');
			$this->addFile('web_page_tests/Site_Main_Test.php');
			$this->addFile('web_page_tests/SiteFacultyPublicationsTest.php');
			$this->addFile('web_page_tests/SiteHenryArtCollectionsTest.php');
			$this->addFile('web_page_tests/SiteMayaMotulDeSanJoseArchaeologyTest.php');
			$this->addFile('web_page_tests/SiteRonadhCoxTest.php');
			$this->addFile('web_page_tests/SiteThesesTest.php');
			$this->addFile('web_page_tests/SiteWilliamsArchivesTest.php');
			$this->addFile('web_page_tests/Site_Common_Battery_Test.php');


			#############################################################
			# Sound Effect
			#############################################################
			# $this->addFile('soundForTesting.php');
		}
	}
