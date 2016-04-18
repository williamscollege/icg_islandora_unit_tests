<?php
//require_once dirname(__FILE__) . '/../CONF_for_testing.php';
//require_once dirname(__FILE__) . '/../simpletest/WMS_web_tester.php';
require_once('UnboundWebTestCase.php');

class SiteThesesTest extends UnboundWebTestCase {

    function SiteThesesTest() {
        $this->setUnboundSite('theses');
        echo "\n<br/><br/>\n<b>TESTING SITE ".$this->getTestingUrlBase()."</b><br/>\n";
    }

    //############################################################

    function TestSiteBasics() {
        $this->doStandardBasicSiteTests();
    }

    //############################################################

    function TestContentModelDisplay_Audio() {
        $this->fail("no audio objects yet in place to test");
//        $this->doContentModelTest_Audio('','','');
    }

    function TestContentModelDisplay_BasicImage() {
        $this->fail("no basic image objects yet in place to test");
//        $this->doContentModelTest_BasicImage('','','');
    }

    function TestContentModelDisplay_Binary() {
        $this->fail("no binary objects yet in place to test");
//        $this->doContentModelTest_Binary('','','');
    }

    function TestContentModelDisplay_Book(){
        $this->doContentModelTest_Book('','','');
    }

    function TestContentModelDisplay_Compound(){
        $this->fail("no compound objects yet in place to test");
//        $this->doContentModelTest_Compound('','','');
    }

    function TestContentModelDisplay_LargeImage(){
        $this->fail("no large image objects yet in place to test");
//        $this->doContentModelTest_LargeImage('','','');
    }

    function TestContentModelDisplay_PDF() {
        $this->doContentModelTest_PDF('theses','studenttheses','10');
    }

    function TestContentModelDisplay_Video() {
        $this->fail("no video objects yet in place to test");
//        $this->doContentModelTest_Video('','','');
    }

    //############################################################

    private $specificTestObjectUrl = '';

    function TestObject_Specific() {
        $this->specificTestObjectUrl = 'http://'.TARGET_HOST.'/theses/islandora/object/studenttheses%3A10';
        $this->get($this->specificTestObjectUrl);
        $this->standardResponseChecks();
    }

    function TestObjectDisplayCollectionInfo() {
        $this->get($this->specificTestObjectUrl);

        $this->assertPattern('/<div class="collection-info">/i');
        $this->assertNoPattern('/>In collections</i');
        $this->assertPattern('/<a href="\\/theses\\/islandora\\/object\\/studenttheses%3Aobject">Theses<\\/a>/i');
    }

    function TestObjectDisplayMetadataLabels() {
        $this->get($this->specificTestObjectUrl);

        $this->assertPattern('/<tr class="creator author">\s*<td class="mods_label">Author<\\/td>\s*<td class="mods_value">Alvarez, Kyung Nahiomy<\\/td>\s*<\\/tr>/i');
        $this->assertPattern('/<tr class="creator thesis_advisor">\s*<td class="mods_label">Thesis Advisor<\\/td>\s*<td class="mods_value">Mahon, James E., 1955-<\\/td>\s*<\\/tr>/i');
        $this->assertPattern('/<tr class="creator thesis_advisor">\s*<td class="mods_label">Thesis Advisor<\\/td>\s*<td class="mods_value">LaLumia, Sara<\\/td>\s*<\\/tr>/i');
        $this->assertPattern('/<tr class="department">\s*<td class="mods_label">Department<\\/td>\s*<td class="mods_value">Political Economy<\\/td>\s*<\\/tr>/i');
        $this->assertPattern('/<tr class="rights">\s*<td class="mods_label">Rights<\\/td>\s*<td class="mods_value">Contact Archives and Special Collections at archives@williams.edu<\\/td>\s*<\\/tr>/i');
        $this->assertPattern('/<tr class="creator repository">\s*<td class="mods_label">Repository<\\/td>\s*<td class="mods_value">Williams College<\\/td>\s*<\\/tr>/i');
        $this->assertPattern('/<tr class="creator repository">\s*<td class="mods_label">Repository<\\/td>\s*<td class="mods_value">Williams College. Archives<\\/td>\s*<\\/tr>/i');
        $this->assertPattern('/<tr class="date-issued">\s*<td class="mods_label">Date Issued<\\/td>\s*<td class="mods_value">2016-03<\\/td>\s*<\\/tr>/i');
        $this->assertPattern('/<tr class="note provenance">\s*<td class="mods_label">Provenance<\\/td>\s*<td class="mods_value">Submitted by author<\\/td>\s*<\\/tr>/i');
        $this->assertPattern('/<tr class="subject">\s*<td class="mods_label">Subject<\\/td>\s*<td class="mods_value">Credit cards -- Marketing<\\/td>\s*<\\/tr>/i');
        $this->assertPattern('/<tr class="identifier">\s*<td class="mods_label">callnumber<\\/td>\s*<td class="mods_value">541.A48 2016<\\/td>\s*<\\/tr>/i');
        $this->assertPattern('/<tr class="identifier">\s*<td class="mods_label">filename<\\/td>\s*<td class="mods_value">2016_January_Alvarez_Kyung_Thesis_Final_POEC.pdf<\\/td>\s*<\\/tr>/i');
    }

    function TestObjectDisplayDatastreamsSection() {
        $this->get($this->specificTestObjectUrl);

        $this->assertPattern('/<table class="object-datastreams">/i');

        $this->assertPattern('/<td>OBJ<\\/td>/i');
        $this->assertPattern('/<a href="\\/theses\\/islandora\\/object\\/studenttheses%3A10\\/datastream\\/OBJ\\/download">PUT MISSING TEST VALUE HERE<\\/a>/i');


        $this->assertPattern('/<td>FULL_TEXT<\\/td>/i');
        $this->assertPattern('/<a href="\\/theses\\/islandora\\/object\\/studenttheses%3A10\\/datastream\\/FULL_TEXT\\/download">PUT MISSING TEST VALUE HERE<\\/a>/i');

        $this->assertPattern('/<td>TN<\\/td>/i');
        $this->assertPattern('/<a href="\\/theses\\/islandora\\/object\\/studenttheses%3A10\\/datastream\\/TN\\/download">TN<\\/a>/i');

    }

    //############################################################

    function TestSearch_Author() {
        http://unbound.williams.edu/theses/islandora/search?f[0]=mods_name_personal_namePart_ms%3A%22LaLumia%2C%5C%20Sara%22

        $this->get('http://'.TARGET_HOST.'/theses/islandora/search?f[0]=mods_name_personal_namePart_ms%3A%22LaLumia%2C%5C%20Sara%22');
        $this->standardResponseChecks();
    }

    function TestSearch_SortTitle() {
        $this->get('http://'.TARGET_HOST.'/theses/islandora/search/%20?sort=sort.title%20asc');
        $this->standardResponseChecks();
    }

    function TestSearch_Facets() {
        $this->get('http://'.TARGET_HOST.'/theses/islandora/search/');

        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Author<\\/h3>/i');
        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Department<\\/h3>/i');
        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Resource Type<\\/h3>/i');
        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Language<\\/h3>/i');
        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Subject<\\/h3>/i');
        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Geographic Subject<\\/h3>/i');
        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Media Type<\\/h3>/i');
        $this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Title<\\/h3>/i');
    }
}