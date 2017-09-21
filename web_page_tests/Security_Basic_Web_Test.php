<?php
	require_once dirname(__FILE__) . '/Site_Common_Battery_Test.php';

	class BasicWebSecurityTest extends IslandoraWebTestCase {

		function TestPrintName() {
			echo "<p></p><hr><h3>SECURITY TESTS: " . FULL_APP_URL . "</h3>";
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

		function TestSiteAccessByHttp() {
			$this->get('http://' . APP_DOMAIN . APP_PORT . APP_FOLDER);
			$this->standardResponseChecks();
		}

		function TestSiteAccessByHttps() {
			$this->get('https://' . APP_DOMAIN . APP_PORT . APP_FOLDER);
			$this->standardResponseChecks();
			$this->assertEqual($this->getUrl(), 'https://' . APP_DOMAIN . APP_PORT . APP_FOLDER);
		}

		function TestSiteHttpAccessIsRedirectedToHttps() {
			$this->get('http://' . APP_DOMAIN . APP_PORT . APP_FOLDER);
			$this->standardResponseChecks();
			$this->assertEqual($this->getUrl(), 'https://' . APP_DOMAIN . APP_PORT . APP_FOLDER . '/');
		}

		function TestLoginIsHttp() {
			$this->get('http://' . APP_DOMAIN . APP_PORT . APP_FOLDER . '/user/login');
			$this->setFieldById('edit-name', APP_TEST_USER);
			$this->setFieldById('edit-pass', APP_TEST_PASS);
			$this->click('Log in');
			$this->standardResponseChecks();
			$this->assertPattern('/MEMBER/i');
		}

		function TestLoginIsHttps() {
			$this->get('https://' . APP_DOMAIN . APP_PORT . APP_FOLDER . '/user/login');
			$this->setFieldById('edit-name', APP_TEST_USER);
			$this->setFieldById('edit-pass', APP_TEST_PASS);
			$this->click('Log in');
			$this->standardResponseChecks();
			$this->assertPattern('/MEMBER/i');
		}

		#############################################################
		# Utility Tool: Flush content to keep browser alive
		#############################################################
		function Test_Utility_KeepBrowserAlive() {
			// $this->util_KeepBrowserAlive_Flush(); // prevent browser timeout issues

			// workaround for inability to access above fxn, is below:
			ob_flush(); // flush (send) the output buffer; to flush the ob output buffers, you will have to call both ob_flush() and flush()
			flush(); // flush system output buffer; to flush the ob output buffers, you will have to call both ob_flush() and flush()
			set_time_limit(0); // restarts the timeout counter from zero
			// echo 'fxn: flushed content to browser.<br />';
			// ob_end_flush();
		}

	}