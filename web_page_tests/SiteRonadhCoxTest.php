<?php
//require_once dirname(__FILE__) . '/../CONF_for_testing.php';
//require_once dirname(__FILE__) . '/../simpletest/WMS_web_tester.php';
require_once('UnboundWebTestCase.php');

class SiteRonadhCoxTest extends UnboundWebTestCase {

    function SiteRonadhCoxTest() {
        $this->setUnboundSite('ronadhcox');
        echo "\n<br/><br/>\n<b>TESTING SITE ".$this->getTestingUrlBase()."</b><br/>\n";
    }

    //############################################################

    function TestSiteBasics() {
        $this->doStandardBasicSiteTests();
    }

    //############################################################

    function TestContentModelDisplay_Audio() {
        $this->doContentModelTest_Audio('','','');
    }

    function TestContentModelDisplay_BasicImage() {
        $this->doContentModelTest_BasicImage('ronadhcox','lavaka','920');
    }

    function TestContentModelDisplay_Book(){
        $this->doContentModelTest_Book('','','');
    }

    function TestContentModelDisplay_Compound(){
        $this->doContentModelTest_Compound('','','');
    }

    function TestContentModelDisplay_LargeImage(){
        $this->doContentModelTest_LargeImage('','','');
    }

    function TestContentModelDisplay_PDF() {
        $this->doContentModelTest_PDF('','','');
    }

    function TestContentModelDisplay_Video() {
        $this->doContentModelTest_Video('','','');
    }

    //############################################################

    function TestProjectLeadPage() {
        $this->get('http://'.TARGET_HOST.'/ronadhcox/project-lead');
        $this->standardResponseChecks();
    }

    function TestObject_Collection() {
        $this->get('http://'.TARGET_HOST.'/ronadhcox/islandora/object/sedimentology%3Aimages');
        $this->standardResponseChecks();
    }

    function TestObject_Specific() {
        $this->get('http://'.TARGET_HOST.'/ronadhcox/islandora/object/sedimentology%3A2');
        $this->standardResponseChecks();
    }

    function TestSearch_SubjectGeographic() {
        $this->get('http://'.TARGET_HOST.'/ronadhcox/islandora/search?f[0]=mods_subject_geographic_ms%3A%22Tsiroanomandidy%22');
        $this->standardResponseChecks();
    }

    function TestSearch_Sort_Title() {
        $this->get('http://'.TARGET_HOST.'/ronadhcox/islandora/search/%20?sort=sort.title%20asc');
        $this->standardResponseChecks();
    }

    function TestSearch_Facets() {
        $this->get('http://'.TARGET_HOST.'/ronadhcox/islandora/search/');
        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Collection<\\/h3>/i');
        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Photographer<\\/h3>/i');
        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Subject<\\/h3>/i');
        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Geographic<\\/h3>/i');
        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Time Period<\\/h3>/i');
    }

}