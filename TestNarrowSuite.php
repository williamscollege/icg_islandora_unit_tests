<?php
	require_once('simpletest/autorun.php');
	require_once('simpletest/web_tester_islandora.php');
	require_once dirname(__FILE__) . '/util.php';
	SimpleTest::prefer(new TextReporter());


	class TestNarrowSuite extends TestSuite {
		function TestNarrowSuite() {
			$this->TestSuite('Narrowly focused tests - changes');

			#############################################################
			# Tests
			#############################################################

//			$this->addFile('web_page_tests/Security_Basic_Fedora_Test.php');


			$this->addFile('web_page_tests/SiteThesesTest.php');
/*
			$this->addFile('web_page_tests/Security_Basic_Web_Test.php');
			$this->addFile('web_page_tests/Site_Common_Battery_Test.php');
			$this->addFile('web_page_tests/Site_Main_Test.php');
			$this->addFile('web_page_tests/SiteFacultyPublicationsTest.php');
			$this->addFile('web_page_tests/SiteHenryArtCollectionsTest.php');
			$this->addFile('web_page_tests/SiteMayaMotulDeSanJoseArchaeologyTest.php');
			$this->addFile('web_page_tests/SiteRonadhCoxTest.php');
			$this->addFile('web_page_tests/SiteStudentScholarshipTest.php');
			$this->addFile('web_page_tests/SiteThesesTest.php');
			$this->addFile('web_page_tests/SiteWilliamsArchivesTest.php');
*/


			#############################################################
			# Sound Effect
			#############################################################
			# $this->addFile('soundForTesting.php');
		}
	}

