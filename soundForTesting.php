<?php
	require_once('simpletest/web_tester_islandora.php');

	class soundForTesting extends TestSuite {
		public function TestOfSoundCompleted() {
			$this->assertEqual(1, 1);
		}
	}

?>

<embed height="1" width="1" src="soundForTesting.mp3">