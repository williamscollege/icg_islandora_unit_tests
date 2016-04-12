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
        $this->assertNoPattern('/FAIL[^s]/i');
        $this->assertNoText('Warning:');
        $this->assertNoText('Notice:');
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

    //############################################################

    function _setUpTestValuesFor($site,$namespace,$id_number) {
        $site_url_part = '';
        $site_url_part_escaped = '';
        if ($site) {
            $site_url_part = '/'.$site;
            $site_url_part_escaped = '\\\\/'.$site;
        }
        $test_url = 'http://'.TARGET_HOST.$site_url_part.'/islandora/object/'.$namespace.'%3A'.$id_number;

        return [
            'site_url_part' => $site_url_part,
            'site_url_part_escaped' => $site_url_part_escaped,
            'test_url' => $test_url
        ];
    }

    function doContentModelTest_Audio($site='',$namespace='',$id_number='') {
        if ($site=='' && $namespace=='' && $id_number=='') {
            echo "audio test case - NOT USED ON THIS SITE<br/>\n";
            return;
        }
        $tv = $this->_setUpTestValuesFor($site,$namespace,$id_number);

        echo 'audio test case - <a href="'.$tv['test_url'].'">'.$tv['test_url']."</a><br/>\n";
        $this->get($tv['test_url']);
        $this->standardResponseChecks();

        $this->assertPattern('/<div class="islandora-audio-content">/');
        $this->assertPattern('/<a href="http:\\/\\/'.TARGET_HOST.$tv['site_url_part_escaped'].'\\/islandora\\/object\\/'.$namespace.'\\%3A'.$id_number.'\\/datastream\\/PROXY_MP3"><img typeof="foaf:Image" src="'.$tv['site_url_part_escaped'].'\\/islandora\\/object\\/'.$namespace.'\\%3A'.$id_number.'\\/datastream\\/TN\\/view"/');
    }

    function doContentModelTest_BasicImage($site,$namespace,$id_number) {
        if ($site=='' && $namespace=='' && $id_number=='') {
            echo "basic image test case - NOT USED ON THIS SITE<br/>\n";
            return;
        }
        $tv = $this->_setUpTestValuesFor($site,$namespace,$id_number);

        echo 'basic image test case - <a href="'.$tv['test_url'].'">'.$tv['test_url']."</a><br/>\n";
        $this->get($tv['test_url']);
        $this->standardResponseChecks();

        $this->assertPattern('/<div class="islandora-basic-image-content">/');
        $this->assertPattern('/src="'.$tv['site_url_part_escaped'].'\\/islandora\\/object\\/'.$namespace.'\\%3A'.$id_number.'\\/datastream\\/MEDIUM_SIZE\\/view"/');
    }

    function doContentModelTest_Book($site,$namespace,$id_number) {
        if ($site=='' && $namespace=='' && $id_number=='') {
            echo "book test case - NOT USED ON THIS SITE<br/>\n";
            return;
        }
        $tv = $this->_setUpTestValuesFor($site,$namespace,$id_number);
        $tv['test_url'] .= '#page/1/mode/1up';

        echo 'book test case - <a href="'.$tv['test_url'].'">'.$tv['test_url']."</a><br/>\n";
        $this->get($tv['test_url']);
        $this->standardResponseChecks();

        $this->assertPattern('/"islandoraInternetArchiveBookReader":\\{"book":"'.$namespace.':'.$id_number.'"/');
        $this->assertPattern('/<div id="book-viewer">/');
        $this->assertPattern('/<div id="BookReader" class="islandora-internet-archive-bookreader">/');
    }
}