<?php
	require_once('simpletest/autorun.php');
	SimpleTest::prefer(new TextReporter());

	class TestOfAllSuite extends TestSuite {
		function TestOfAllSuite() {

			$this->TestSuite('Unbound Web Access');

			$this->addFile('TestOfWebPageSuite.php');


			# Sound Effect
			$this->addFile('soundForTesting.php');
		}
	}

?>