<?php
	require_once dirname(__FILE__) . '/../institution.cfg.php';
	require_once dirname(__FILE__) . '/../simpletest/web_tester_islandora.php';

	class MultiSiteIslandoraWebTestCase extends IslandoraWebTestCase {

		private $multiSite = '';

		function setMultiSite($v) {
			$this->multiSite = $v;
		}

		function getMultiSite() {
			return $this->multiSite;
		}

		function getTestingUrlBase() {
			if ($this->multiSite) {
				return FULL_APP_URL . '/' . $this->multiSite;
			}
			return FULL_APP_URL;
		}

		#############################################################
		# Utility Tool: Flush content to keep browser alive
		#############################################################

		function util_KeepBrowserAlive_Flush() {
			ob_flush(); // flush (send) the output buffer; to flush the ob output buffers, you will have to call both ob_flush() and flush()
			flush(); // flush system output buffer; to flush the ob output buffers, you will have to call both ob_flush() and flush()
			set_time_limit(0); // restarts the timeout counter from zero
			// echo 'fxn: flushed content to browser.<br />';
			// ob_end_flush();
		}

		#############################################################
		# Test Standard Responses
		#############################################################

		function standardResponseChecks() {
			$initialFailCount = $this->reporter->reporter->reporter->getFailCount();
			// print_r($initialFailCount);
			$this->assertResponse(array(200));
			$this->assertNoPattern('/ERROR/i');
			$this->assertNoPattern('/FAIL[^s]/i');
			$this->assertNoPattern('/WARNING:/i');
			$this->assertNoPattern('/NOTICE:/i');
			$this->assertNoPattern('/ACCESS DENIED/i');
			$this->assertNoPattern('/PAGE NOT FOUND/i');
			$this->assertNoPattern('/SORRY, BUT YOUR SEARCH RETURNED NO RESULTS/i');
			if ($this->reporter->reporter->reporter->getFailCount() > $initialFailCount) {
				echo "<p><span class=\"fail\">standardResponseChecks found failures </span> - " . $this->getUrl() . "</p>\n";
			}
		}

		#############################################################
		# Test Basics and Specific Pages
		#############################################################

		function doStandardBasicSiteTests() {
			$this->doTestSiteHomePage();
			$this->doTestSiteAboutPage();
			$this->doTestSiteSearch_browseAll();
		}

		function doTestSiteHomePage() {
			$this->get($this->getTestingUrlBase());
			$this->standardResponseChecks();
		}

		function doTestSiteAboutPage() {
			$this->get($this->getTestingUrlBase() . '/about');
			$this->standardResponseChecks();
		}

		function doTestSiteSearch_browseAll() {
			if ($this->getTestingUrlBase() == FULL_APP_URL) {
				// This fails due to parsing error: $this->get(FULL_APP_URL . '/islandora/search');
				// TODO - Fix above test: Browse All on primary site fails, but works on other sites; too much data to parse?
				$this->fail("KNOWN ERROR: Test fails on parent site, but works on other multisite sites.");
			}
			else {
				// example: $this->get(FULL_APP_URL . 'henryartcollections/islandora/search');
				$this->get($this->getTestingUrlBase() . '/islandora/search');
				$this->standardResponseChecks();
				$this->assertPattern('/islandora-solr-search-result-inner/'); // at least one result
			}
		}

		#############################################################
		# Test Solution Packs
		#############################################################

		function _setUpTestFor($content_model_tested, $site, $namespace, $id_number, $url_suffix = '') {
			if ($site == '' && $namespace == '' && $id_number == '') {
				echo "<li><span class=\"skip\">Test skipped: " . $content_model_tested . "</span> - <em>NOT USED ON THIS SITE</em></li>";
				return;
			}

			$site_single_escaped = '';
			$site_double_escaped = '';
			$site_triple_escaped = '';

			if ($site) {
				// create various parse options for subsequent testing scenarios
				$site                = '/' . $site; //requires a preceding slash
				$site_single_escaped = str_replace('/', '\\/', $site);
				$site_double_escaped = str_replace('/', '\\\\/', $site);
				$site_triple_escaped = str_replace('/', '\\\\\\/', $site);
			}

			$test_url = FULL_APP_URL . $site . '/islandora/object/' . $namespace . '%3A' . $id_number . $url_suffix;
			echo "<li><span class=\"pass\">Test Successful: " . $content_model_tested . "</span> - <a href=\"" . $test_url . "\">" . $test_url . "</a></li>";
			$this->get($test_url);
			$this->standardResponseChecks();

			return [
				'site_single_escaped'         => $site_single_escaped,
				'site_double_escaped'         => $site_double_escaped,
				'site_triple_escaped'         => $site_triple_escaped,
				'full_app_url_single_escaped' => str_replace('/', '\\/', FULL_APP_URL),
				'full_app_url_double_escaped' => str_replace('/', '\\\\/', FULL_APP_URL),
				'full_app_url_triple_escaped' => str_replace('/', '\\\\\\/', FULL_APP_URL)
			];
		}

		function doContentModelTest_Audio($site = '', $namespace = '', $id_number = '') {
			$test_values = $this->_setUpTestFor('Audio Solution Pack', $site, $namespace, $id_number);
			if (!$test_values) {
				return;
			}

			$this->assertPattern('/<div class="islandora-audio-content">/');
			# match full path
			$this->assertPattern('/"file":"' . $test_values['full_app_url_triple_escaped'] . $test_values['site_triple_escaped'] . '\\\\\\/islandora\\\\\\/object\\\\\\/' . $namespace . '%3A' . $id_number . '\\\\\\/datastream\\\\\\/PROXY_MP3\\\\\\/file_name_spoof.mp3"/');
			$this->assertPattern('/<div id="mediaplayer">Loading JW Player...<\\/div>/');
		}

		function doContentModelTest_BasicImage($site = '', $namespace = '', $id_number = '') {
			$test_values = $this->_setUpTestFor('Basic Image Solution Pack', $site, $namespace, $id_number);
			if (!$test_values) {
				return;
			}

			$this->assertPattern('/<div class="islandora-basic-image-content">/');
			# match full path
			$this->assertPattern('/href="' . $test_values['full_app_url_single_escaped'] . $test_values['site_single_escaped'] . '\\/islandora\\/object\\/' . $namespace . '%3A' . $id_number . '\\/datastream\\/OBJ\\/view"/');
			# match relative path
			$this->assertPattern('/src="' . $test_values['site_single_escaped'] . '\\/islandora\\/object\\/' . $namespace . '%3A' . $id_number . '\\/datastream\\/MEDIUM_SIZE\\/view"/');
		}

		# TODO FUTURE HOOK
		function doContentModelTest_Binary($site = '', $namespace = '', $id_number = '') {
			$test_values = $this->_setUpTestFor('Binary Object Solution Pack', $site, $namespace, $id_number);
			if (!$test_values) {
				return;
			}

			$this->fail("TESTS FOR BINARY CONTENT MODEL NOT IMPLEMENTED (hook in place)");
			// $this->assertPattern('/<div class="islandora-basic-image-content">/');
			// $this->assertPattern('/src="' . '\\/islandora\\/object\\/' . $namespace . '%3A' . $id_number . '\\/datastream\\/MEDIUM_SIZE\\/view"/');
		}

		function doContentModelTest_Book($site = '', $namespace = '', $id_number = '') {
			$test_values = $this->_setUpTestFor('Book Solution Pack', $site, $namespace, $id_number, '#page/1/mode/1up');
			if (!$test_values) {
				return;
			}

			$this->assertPattern('/"islandoraInternetArchiveBookReader":\\{"book":"' . $namespace . ':' . $id_number . '"/');
			$this->assertPattern('/<div id="book-viewer">/');
			$this->assertPattern('/<div id="BookReader" class="islandora-internet-archive-bookreader">/');
		}

		# TODO FUTURE HOOK
		function doContentModelTest_Compound($site = '', $namespace = '', $id_number = '') {
			$test_values = $this->_setUpTestFor('Compound Object Solution Pack', $site, $namespace, $id_number);
			if (!$test_values) {
				return;
			}

			$this->fail('need to implement actual tests for compound content model');
			// $this->assertPattern('/<div class="islandora-basic-image-content">/');
			// $this->assertPattern('/src="' . '\\/islandora\\/object\\/' . $namespace . '%3A' . $id_number . '\\/datastream\\/MEDIUM_SIZE\\/view"/');
		}

		function doContentModelTest_LargeImage($site = '', $namespace = '', $id_number = '') {
			$test_values = $this->_setUpTestFor('Large Images', $site, $namespace, $id_number);
			if (!$test_values) {
				return;
			}

			$this->assertPattern('/<div class="islandora-large-image-content">/');
			$this->assertPattern('/id="islandora-openseadragon"/');
			# match full path
			$this->assertPattern('/\\{"pid":"' . $namespace . ':' . $id_number . '","resourceUri":"' . $test_values['full_app_url_triple_escaped'] . $test_values['site_triple_escaped'] . '\\\\\/islandora\\\\\\/object\\\\\\/' . $namespace . '\\%3A' . $id_number . '\\\\\\/datastream\\\\\\/JP2/');
		}

		function doContentModelTest_PDF($site = '', $namespace = '', $id_number = '') {
			$test_values = $this->_setUpTestFor('PDF Solution Pack', $site, $namespace, $id_number);
			if (!$test_values) {
				return;
			}

			$this->assertPattern('/<div class="islandora-pdf-content">/');
			$this->assertPattern('/<iframe class="pdf"/');
			// csw original: $this->assertPattern('/src="' . $test_values['site_single_escaped'] . 'sites\\/all\\/libraries\\/pdfjs\\/web\\/viewer.html\\?file=(http%3A\\/\\/' . APP_DOMAIN . $test_values['site_single_escaped'] . '\\/|' . $test_values['site_single_escaped'] . '\\/)islandora\\/object\\/' . $namespace . '\\%253A' . $id_number . '\\/datastream\\/OBJ\\/view"/');
			# match both full and relative paths
			$this->assertPattern('/src="' . $test_values['full_app_url_single_escaped'] . $test_values['site_single_escaped'] . '\\/sites\\/all\\/libraries\\/pdfjs\\/web\\/viewer.html\\?file=(' . $test_values['site_single_escaped'] . ')' . '\\/islandora\\/object\\/' . $namespace . '\\%253A' . $id_number . '\\/datastream\\/OBJ\\/view"/');
		}

		function doContentModelTest_Video($site = '', $namespace = '', $id_number = '') {
			$test_values = $this->_setUpTestFor('Video Solution Pack', $site, $namespace, $id_number);
			if (!$test_values) {
				return;
			}

			$this->assertPattern('/<div class="islandora-video-content">/');
			$this->assertPattern('/<div id="mediaplayer">Loading JW Player...<\\/div>/');
			# match full path
			$this->assertPattern('/"islandora_jwplayer":\\{"thumbnail":"' . $test_values['full_app_url_triple_escaped'] . $test_values['site_triple_escaped'] . '\\\\\\/islandora\\\\\\/object\\\\\\/' . $namespace . '\\%3A' . $id_number . '\\\\\\/datastream\\\\\\/TN\\\\\\/view","file":"' . $test_values['site_triple_escaped'] . '\\\\\\/islandora\\\\\\/object\\\\\\/' . $namespace . '\\%3A' . $id_number . '\\\\\\/datastream\\\\\\/MP4\\\\\\/view\\\\\\/file_name_spoof.mp4"/');
		}

		#############################################################
		# Test Collections and Objects (this site only)
		#############################################################

		function doTestSite_Collections_and_Objects($array_collection_and_object_ids) {
			# Site Islandora Root
			$this->get($this->getTestingUrlBase() . '/islandora/object/islandora%3Aroot');

			echo "<p><strong>Testing Site Collections and Objects: " . $this->getTestingUrlBase() . '/islandora/object/islandora%3Aroot' . "</strong></p>";
			echo "<ul>";

			foreach ($array_collection_and_object_ids as $array_ids) {
				# Test Collection ID
				$initialFailCount = $this->reporter->reporter->reporter->getFailCount();
				$this->get($this->getTestingUrlBase() . '/islandora/object/' . $array_ids[0]);
				$this->standardResponseChecks();

				if ($this->reporter->reporter->reporter->getFailCount() > $initialFailCount) {
					echo "<li><span class=\"fail\">Failed to find collection - </span>" . $this->getUrl() . "</li>";
				}
				elseif ($array_ids[0] == '') {
					echo "<li><span class=\"fail\">Collection appears to be missing or empty - </span>" . $this->getUrl() . "</li>";
				}
				else {
					echo "<li><span class=\"pass\">Collection exists - </span>" . $this->getUrl() . "</li>";
				}

				# Test Object ID
				$initialFailCount = $this->reporter->reporter->reporter->getFailCount();
				$this->get($this->getTestingUrlBase() . '/islandora/object/' . $array_ids[1]);
				$this->standardResponseChecks();

				if ($this->reporter->reporter->reporter->getFailCount() > $initialFailCount) {
					echo "<li><span class=\"fail\">Failed to find collection object - </span>" . $this->getUrl() . "</li>";
				}
				elseif ($array_ids[1] == '') {
					echo "<li><span class=\"fail\">Collection has no associated object or may be empty</span></li>";
				}
				else {
					echo "<li><span class=\"pass\">Collection object exists - </span>" . $this->getUrl() . "</li>";
				}

				$this->util_KeepBrowserAlive_Flush(); // prevent browser timeout issues
			}
			echo "</ul>";
		}

	}