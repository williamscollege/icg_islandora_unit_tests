<?php
	require_once('simpletest/autorun.php');
	require_once dirname(__FILE__) . '/util.php';
	SimpleTest::prefer(new TextReporter());


	class TestOfAllSuite extends TestSuite {
		function TestOfAllSuite() {
			$this->TestSuite('Islandora Web Access');

			#############################################################
			# Tests: Run All Tests
			#############################################################

			$this->addFile('TestOfWebPageSuite.php');


			#############################################################
			# Sound Effect
			#############################################################
			# $this->addFile('soundForTesting.php');
		}
	}
