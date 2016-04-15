<?php
//require_once dirname(__FILE__) . '/../CONF_for_testing.php';
//require_once dirname(__FILE__) . '/../simpletest/WMS_web_tester.php';
require_once('UnboundWebTestCase.php');

class Site_Unbound_Test extends UnboundWebTestCase {

    function Site_Unbound_Test() {
        $this->setUnboundSite('');
        echo "\n<br/><br/>\n<b>TESTING SITE ".$this->getTestingUrlBase()."</b><br/>\n";
    }

    //############################################################

    function TestSiteBasics() {
        $this->doStandardBasicSiteTests();
    }

    function TestProjectLeads() {
        $this->get('http://'.TARGET_HOST.'/project-leads');
        $this->standardResponseChecks();
    }

    function TestStartAProject() {
        $this->get('http://'.TARGET_HOST.'/start-a-project');
        $this->standardResponseChecks();
    }

    function TestSearch_Type() {
        $this->get('http://'.TARGET_HOST.'/islandora/search?f[0]=dc.type%3A%22Physical%5C%20Object%22');
        $this->standardResponseChecks();
    }

    function TestSearch_Facets() {
        $this->get('http://'.TARGET_HOST.'/islandora/search/');
        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Collection<\\/h3>/i');
        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Name<\\/h3>/i');
        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Department or Group<\\/h3>/i');
        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Type<\\/h3>/i');
        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Subject<\\/h3>/i');
        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Geographic<\\/h3>/i');
        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Language<\\/h3>/i');
    }

    function TestCollectionAccessibility() {

        echo '<p>TODO: add the full list of collections to check for on the main site http://'.TARGET_HOST."</p>\n";

        $collections_ids_to_check = [
            'alexanderdavidson%3Aphotography'
            ,'architectural-plans%3Aimages'
            // ,'pressimages2012%3Aimages'  // not accessible as a collection on the live site - should the namespace be there at all?
            ,'daviscenter%3Aposters#'
        ];

        foreach ($collections_ids_to_check as $col_id) {

            $initialFailCount = $this->reporter->reporter->reporter->getFailCount();

            $this->get('http://'.TARGET_HOST.'/islandora/object/'.$col_id);
            $this->assertNoPattern('/Access denied/i');

            if ($this->reporter->reporter->reporter->getFailCount() > $initialFailCount) {
                echo "<br/><b style=\"color:#00a;\">collection accessibility failure for ".$this->getUrl()."</b><br/><br/>\n";
            }
        }
    }

    //############################################################

    function TestContentModelDisplay_Audio() {
        $this->doContentModelTest_Audio('','andyjaffe','55');
    }

    function TestContentModelDisplay_BasicImage() {
        $this->doContentModelTest_BasicImage('','alexanderdavidson','205');
    }

    function TestContentModelDisplay_Book(){
        $this->doContentModelTest_Book('','','');
    }

    function TestContentModelDisplay_Compound(){
        $this->doContentModelTest_Compound('','','');
    }

    function TestContentModelDisplay_LargeImage(){
        $this->doContentModelTest_LargeImage('','motul','375');
    }

    function TestContentModelDisplay_PDF() {
        $this->doContentModelTest_PDF('','facultyarticles','135');
    }

    function TestContentModelDisplay_Video() {
        $this->doContentModelTest_Video('','andyjaffe','42');
    }

}