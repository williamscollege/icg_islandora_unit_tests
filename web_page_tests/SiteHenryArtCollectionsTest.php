<?php
//require_once dirname(__FILE__) . '/../CONF_for_testing.php';
//require_once dirname(__FILE__) . '/../simpletest/WMS_web_tester.php';
require_once('UnboundWebTestCase.php');

class SiteHenryArtCollectionsTest extends UnboundWebTestCase {

    function SiteHenryArtCollectionsTest() {
        $this->setUnboundSite('henryartcollections');
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
        $this->doContentModelTest_BasicImage('','','');
    }

    function TestContentModelDisplay_Book(){
        $this->doContentModelTest_Book('','','');
    }

    function TestContentModelDisplay_Compound(){
        $this->doContentModelTest_Compound('','','');
    }

    function TestContentModelDisplay_LargeImage(){
        $this->doContentModelTest_LargeImage('henryartcollections','hopkinsforestmaps','109');
    }

    function TestContentModelDisplay_PDF() {
        $this->doContentModelTest_PDF('','','');
    }

    function TestContentModelDisplay_Video() {
        $this->doContentModelTest_Video('','','');
    }

    //############################################################

    function TestProjectLeadPage() {
        $this->get('http://'.TARGET_HOST.'/henryartcollections/project-lead');
        $this->standardResponseChecks();
    }

    function TestObject_Collection() {
        $this->get('http://'.TARGET_HOST.'/henryartcollections/islandora/object/hopkinsforestmaps%3Aimages');
        $this->standardResponseChecks();
    }

    function TestObject_Specific() {
        $this->get('http://'.TARGET_HOST.'/henryartcollections/islandora/object/hopkinsforestmaps%3A70');
        $this->standardResponseChecks();
    }

    function TestSearch_SubjectGeographic() {
        $this->get('http://'.TARGET_HOST.'/henryartcollections/islandora/search?f[0]=mods_subject_geographic_ms%3A"Hopkins%5C%20Memorial%5C%20Forest"');
        $this->standardResponseChecks();
    }

    function TestSearch_Sort_Title() {
        $this->get('http://'.TARGET_HOST.'/henryartcollections/islandora/search/%20?sort=sort.title%20asc');
        $this->standardResponseChecks();
    }

    function TestSearch_Facets() {
        $this->get('http://'.TARGET_HOST.'/henryartcollections/islandora/search/');

        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Collector<\\/h3>/i');
//        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Source<\\/h3>/i');
//        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Surveyor<\\/h3>/i');
//        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Date<\\/h3>/i');
        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Language<\\/h3>/i');
        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Resource Type<\\/h3>/i');
        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Subject<\\/h3>/i');
        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Geographic Subject<\\/h3>/i');
        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Digital Media Type<\\/h3>/i');
    }

}