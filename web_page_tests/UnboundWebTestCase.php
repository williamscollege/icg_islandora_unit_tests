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
            echo "<b style=\"color:#00a;\">standard <u>reponse</u> check failures for ".$this->getUrl()."</b><br/><br/>\n";
        }

    }

//    function standardFacetsChecks() {
//        $initialFailCount = $this->reporter->reporter->reporter->getFailCount();
//        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Author<\\/h3>/i');
//        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Department<\\/h3>/i');
//        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Resource Type<\\/h3>/i');
//        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Subject<\\/h3>/i');
//        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Geographic<\\/h3>/i');
//        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Digital Media Type<\\/h3>/i');
//        if ($this->reporter->reporter->reporter->getFailCount() > $initialFailCount) {
//            echo "<b style=\"color:#00a;\">standard <u>facets</u> check failures for ".$this->getUrl()."</b><br/><br/>\n";
//        }
//    }

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

    function _setUpTestFor($content_model_tested,$site,$namespace,$id_number,$url_suffix='') {
        if ($site=='' && $namespace=='' && $id_number=='') {
            echo "$content_model_tested test case - NOT USED ON THIS SITE<br/>\n";
            return;
        }

        $site_url_part = '';
        $site_url_part_escaped = '';
        $site_url_part_double_escaped = '';
        $site_url_part_triple_escaped = '';
        if ($site) {
            $site_url_part = '/'.$site;
            $site_url_part_escaped = '\\/'.$site;
            $site_url_part_double_escaped = '\\\\/'.$site;
            $site_url_part_triple_escaped = '\\\\\\/'.$site;
        }
        $test_url = 'http://'.TARGET_HOST.$site_url_part.'/islandora/object/'.$namespace.'%3A'.$id_number.$url_suffix;

        echo $content_model_tested.' test case - <a href="'.$test_url.'">'.$test_url."</a><br/>\n";
        $this->get($test_url);
        $this->standardResponseChecks();

        return [
            'site_url_part' => $site_url_part,
            'site_url_part_escaped' => $site_url_part_escaped,
            'site_url_part_double_escaped' => $site_url_part_double_escaped,
            'site_url_part_triple_escaped' => $site_url_part_triple_escaped,
            'test_url' => $test_url
        ];
    }

    function doContentModelTest_Audio($site='',$namespace='',$id_number='') {
        $test_values = $this->_setUpTestFor('audio',$site,$namespace,$id_number);
        if (! $test_values) { return; }

        $this->assertPattern('/<div class="islandora-audio-content">/');
//        $this->assertPattern('/<a href="http:\\/\\/'.TARGET_HOST.$test_values['site_url_part_escaped'].'\\/islandora\\/object\\/'.$namespace.'\\%3A'.$id_number.'\\/datastream\\/PROXY_MP3"><img typeof="foaf:Image" src="'.$test_values['site_url_part_escaped'].'\\/islandora\\/object\\/'.$namespace.'\\%3A'.$id_number.'\\/datastream\\/TN\\/view"/');

        $this->assertPattern('/"file":"http:\\\\\/\\\\\/'.TARGET_HOST.$test_values['site_url_part_triple_escaped'].'\\\\\/islandora\\\\\/object\\\\\/'.$namespace.'%3A'.$id_number.'\\\\\/datastream\\\\\/PROXY_MP3\\\\\/file_name_spoof.mp3"/');
        $this->assertPattern('/<div id="mediaplayer">Loading JW Player...<\\/div>/');
    }

    function doContentModelTest_BasicImage($site,$namespace,$id_number) {
        $test_values = $this->_setUpTestFor('basic image', $site,$namespace,$id_number);
        if (! $test_values) { return; }

        $this->assertPattern('/<div class="islandora-basic-image-content">/');
        $this->assertPattern('/src="'.$test_values['site_url_part_escaped'].'\\/islandora\\/object\\/'.$namespace.'\\%3A'.$id_number.'\\/datastream\\/MEDIUM_SIZE\\/view"/');
    }

    function doContentModelTest_Book($site,$namespace,$id_number) {
        $test_values = $this->_setUpTestFor('book', $site,$namespace,$id_number,'#page/1/mode/1up');
        if (! $test_values) { return; }

        $this->assertPattern('/"islandoraInternetArchiveBookReader":\\{"book":"'.$namespace.':'.$id_number.'"/');
        $this->assertPattern('/<div id="book-viewer">/');
        $this->assertPattern('/<div id="BookReader" class="islandora-internet-archive-bookreader">/');
    }

    function doContentModelTest_Compound($site,$namespace,$id_number) {
        $test_values = $this->_setUpTestFor('compound', $site,$namespace,$id_number);
        if (! $test_values) { return; }

        $this->fail('need to implement actual tests for compound content model');
    }

    function doContentModelTest_LargeImage($site,$namespace,$id_number) {
        $test_values = $this->_setUpTestFor('large image', $site,$namespace,$id_number);
        if (! $test_values) { return; }

        $this->assertPattern('/<div class="islandora-large-image-content">/');
        $this->assertPattern('/id="islandora-openseadragon"/');
        $this->assertPattern('/\\{"pid":"'.$namespace.':'.$id_number.'","resourceUri":"http:\\\\\/\\\\\/'.TARGET_HOST.$test_values['site_url_part_triple_escaped'].'\\\\\/islandora\\\\\/object\\\\\/'.$namespace.'\\%3A'.$id_number.'\\\\\/datastream\\\\\/JP2/');
    }

    function doContentModelTest_PDF($site='',$namespace='',$id_number='') {
        $test_values = $this->_setUpTestFor('PDF', $site,$namespace,$id_number);
        if (! $test_values) { return; }

        $this->assertPattern('/<div class="islandora-pdf-content">/');
        $this->assertPattern('/<iframe class="pdf"/');
        $this->assertPattern('/src="http:\\/\\/'.TARGET_HOST.$test_values['site_url_part_escaped'].'\\/sites\\/all\\/libraries\\/pdfjs\\/web\\/viewer.html\\?file=(http%3A\\/\\/'.TARGET_HOST.$test_values['site_url_part_escaped'].'\\/|'.$test_values['site_url_part_escaped'].'\\/)islandora\\/object\\/'.$namespace.'\\%253A'.$id_number.'\\/datastream\\/OBJ\\/view"/');
    }

    function doContentModelTest_Video($site='',$namespace='',$id_number='') {
        $test_values = $this->_setUpTestFor('video', $site,$namespace,$id_number);
        if (! $test_values) { return; }

        $this->assertPattern('/"islandora_jwplayer":{"thumbnail":"http:\\\\\/\\\\\/'.TARGET_HOST.$test_values['site_url_part_triple_escaped'].'\\\\\/islandora\\\\\/object\\\\\/'.$namespace.'\\%3A'.$id_number.'\\\\\/datastream\\\\\/TN\\\\\/view","file":"'.$test_values['site_url_part_triple_escaped'].'\\\\\/islandora\\\\\/object\\\\\/'.$namespace.'\\%3A'.$id_number.'\\\\\/datastream\\\\\/MP4\\\\\/view\\\\\/file_name_spoof.mp4"/');
        $this->assertPattern('/<div class="islandora-video-content">/');
        $this->assertPattern('/<div id="mediaplayer">Loading JW Player...<\\/div>/');
    }
}