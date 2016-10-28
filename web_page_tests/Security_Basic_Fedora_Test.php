<?php
	require_once dirname(__FILE__) . '/../institution.cfg.php';
	require_once dirname(__FILE__) . '/../simpletest/web_tester_islandora.php';

	class BasicFedoraSecurityTest extends IslandoraWebTestCase {

		function TestPrintName() {
			echo "<p></p><hr><h3>SECURITY TESTS: " . FULL_FEDORA_URL . "</h3>";
		}

		#############################################################
		# Standard Checks functions
		#############################################################

		function standardResponseChecks() {
			$this->assertResponse(array(200));
			$this->assertNoPattern('/ERROR/i');
			$this->assertNoPattern('/FAIL/i');
			$this->assertNoPattern('/SORRY/i');
			$this->assertNoPattern('/DENIED/i');
			$this->assertNoPattern('/ERR_EMPTY_RESPONSE/i');
			$this->assertNoPattern('/ERR_NETWORK_CHANGED/i');
			$this->assertNoPattern('/ERR_SSL_PROTOCOL_ERROR/i');
		}

		function standardRestrictedChecks() {
			$this->assertResponse(array(0));
		}

		#############################################################
		# Test Access Routes
		#############################################################

		function TestFedoraAccessByHttp() {
			$this->get('http://' . FEDORA_DOMAIN . FEDORA_PORT . FEDORA_FOLDER);
			$this->standardResponseChecks();
		}

		function TestFedoraAccessByHttps() {
			$this->get('https://' . FEDORA_DOMAIN . FEDORA_PORT . FEDORA_FOLDER);
			$this->standardResponseChecks();
		}

		function TestFedoraHttpAccessIsRedirectedToHttps() {
			$this->get('http://' . FEDORA_DOMAIN . FEDORA_PORT . FEDORA_FOLDER);
			$this->standardResponseChecks();
			$this->assertEqual($this->getUrl(), 'https://' . FEDORA_DOMAIN . FEDORA_PORT . FEDORA_FOLDER);
		}

		function TestFedoraServerAccessibleOnCampus() {
			$this->get(FEDORA_PREFIX . FEDORA_DOMAIN . FEDORA_PORT . FEDORA_FOLDER);
			$this->standardResponseChecks();
		}

		function TestFedoraServerAccessRestrictedOffCampus() {
			$this->get(FEDORA_PREFIX . FEDORA_DOMAIN . ':80' . FEDORA_FOLDER);
			$this->standardRestrictedChecks();
		}

		#############################################################
		# Utility Tool: Flush content to keep browser alive
		#############################################################
		function Test_Utility_KeepBrowserAlive() {
			$this->util_KeepBrowserAlive_Flush(); // prevent browser timeout issues
		}

	}