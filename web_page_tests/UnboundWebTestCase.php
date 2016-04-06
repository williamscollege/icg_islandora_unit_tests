<?php
require_once dirname(__FILE__) . '/../CONF_for_testing.php';
require_once dirname(__FILE__) . '/../simpletest/WMS_web_tester.php';

class UnboundWebTestCase extends WMSWebTestCase {

    private $unboundSite = '';

    function setUnboundSite($v) {
        $this->unboundSite = $v;
    }

    function getUnboundSite() {
        return $this->unboundSite;
    }

    function getTestingUrlBase() {
        //echo URL_STEM_SSL.$this->unboundSite.'/';
        //exit;
        if ($this->unboundSite) {
            return URL_STEM.$this->unboundSite.'/';
        }
        return URL_STEM;
    }

    //############################################################

    function standardResponseChecks() {
        $initialFailCount = $this->reporter->reporter->reporter->getFailCount();
        $this->assertResponse(200);
        $this->assertNoPattern('/ERROR/i');
        $this->assertNoPattern('/FAIL/i');
        if ($this->reporter->reporter->reporter->getFailCount() > $initialFailCount) {
            echo "<b style=\"color:#00a;\">standard reponse check failures for ".$this->getUrl()."</b><br/><br/>\n";
        }

    }

    //############################################################

    function doStandardBasicSiteTests() {
        $this->doTestSiteHomePage();
        $this->doTestSiteAboutPage();
        $this->doTestSiteSearch_browseAll();
    }

    function doTestSiteHomePage() {
        $this->get($this->getTestingUrlBase());
        $this->standardResponseChecks();
        //exit;
    }

    function doTestSiteAboutPage() {
        $this->get($this->getTestingUrlBase().'about');
        $this->standardResponseChecks();
    }

    function doTestSiteSearch_browseAll() {
        $this->get($this->getTestingUrlBase().'islandora/search');
        $this->standardResponseChecks();

        $this->assertPattern('/islandora-solr-search-result-inner/'); // at least one result
    }

}