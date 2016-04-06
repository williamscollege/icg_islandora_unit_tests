<?php
require_once dirname(__FILE__) . '/../CONF_for_testing.php';
require_once dirname(__FILE__) . '/../simpletest/WMS_web_tester.php';

class BasicSecurityTest extends WMSWebTestCase {

    //############################################################

    function standardResponseChecks() {
        $this->assertResponse(200);
        $this->assertNoPattern('/ERROR/i');
        $this->assertNoPattern('/FAIL/i');
    }

    function TestSiteAccessIsRedirectedToHttps() {
        $this->fail("no main site https check done yet");

        $this->get('http://'.TARGET_HOST.'/');
        $this->standardResponseChecks();
    }

    function TestLoginIsHttps() {
        $this->fail("no login https check done yet");

        $this->get('http://'.TARGET_HOST.'/user/login');
        $this->standardResponseChecks();
    }

    function TestFedoraServer8080AccessibleOnCampus() {
        $this->get('http://unbound-fedora.williams.edu:8080');
        $this->standardResponseChecks();
    }

    function TestFedoraServerAccessRestrictedOffCampus() {
        $this->fail("no fedora off campus restriction check done yet");

        $this->get('http://unbound-fedora.williams.edu:80');
        $this->standardResponseChecks();

        $this->get('http://unbound-fedora.williams.edu:8080');
        $this->standardResponseChecks();
    }
}