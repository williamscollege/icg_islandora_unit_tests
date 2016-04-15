<?php
//require_once dirname(__FILE__) . '/../CONF_for_testing.php';
//require_once dirname(__FILE__) . '/../simpletest/WMS_web_tester.php';
require_once('UnboundWebTestCase.php');

class SiteFacultyPublicationsTest extends UnboundWebTestCase {

    function SiteFacultyPublicationsTest() {
        $this->setUnboundSite('facultypublications');
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
        $this->doContentModelTest_LargeImage('','','');
    }

    function TestContentModelDisplay_PDF() {
        $this->doContentModelTest_PDF('facultypublications','facultyarticles','138');
    }

    function TestContentModelDisplay_Video() {
        $this->doContentModelTest_Video('','','');
    }

    //############################################################

    private $specificTestObjectUrl = '';

    function TestObject_Specific() {
        $this->specificTestObjectUrl = 'http://'.TARGET_HOST.'/facultypublications/islandora/object/facultyarticles%3A138';
        $this->get($this->specificTestObjectUrl);
        $this->standardResponseChecks();
    }

    function TestObjectDisplayCollectionInfo() {
        $this->get($this->specificTestObjectUrl);

        $this->assertPattern('/<div class="collection-info">/i');
        $this->assertNoPattern('/>In collections</i');
        $this->assertPattern('/<a href="\\/facultypublications\\/islandora\\/object\\/facultyarticles%3Atext">Faculty Articles<\\/a>/i');
    }

    function TestObjectDisplayMetadataLabels() {
        $this->get($this->specificTestObjectUrl);

        $this->assertPattern('/<tr class="creator author">\s*<td class="mods_label">Author<\\/td>\s*<td class="mods_value">Luana S. Maroja<\\/td>\s*<\\/tr>/i');
        $this->assertPattern('/<tr class="creator author">\s*<td class="mods_label">Author<\\/td>\s*<td class="mods_value">David P. Richardson<\\/td>\s*<\\/tr>/i');
        $this->assertPattern('/<tr class="department">\s*<td class="mods_label">Department<\\/td>\s*<td class="mods_value">Biology<\\/td>\s*<\\/tr>/i');
        $this->assertPattern('/<tr class="department">\s*<td class="mods_label">Department<\\/td>\s*<td class="mods_value">Chemistry<\\/td>\s*<\\/tr>/i');

        $this->assertPattern('/<tr class="url">\s*<td class="mods_label">url<\\/td>\s*<td class="mods_value"><a href="http:\\/\\/www.biomedcentral.com\\/1471-2148\\/14\\/65">http:\\/\\/www.biomedcentral.com\\/1471-2148\\/14\\/65<\\/a><\\/td>\s*<\\/tr>/i');

        $this->assertPattern('/<tr class="identifier">\s*<td class="mods_label">doi<\\/td>\s*<td class="mods_value">10.1186\\/1471-2148-14-65<\\/td>\s*<\\/tr>/i');
        $this->assertPattern('/<tr class="identifier">\s*<td class="mods_label">pmid<\\/td>\s*<td class="mods_value">24678642<\\/td>\s*<\\/tr>/i');
        $this->assertPattern('/<tr class="identifier">\s*<td class="mods_label">issn<\\/td>\s*<td class="mods_value">1471-2148<\\/td>\s*<\\/tr>/i');

        $this->assertPattern('/<td class="mods_label">Start Page<\\/td>/');
        $this->assertPattern('/<td class="mods_label">Date Issued<\\/td>/');
    }

    function TestObjectDisplayDatastreamsSection() {
        $this->get($this->specificTestObjectUrl);

        $this->assertPattern('/<table class="object-datastreams">/i');

        $this->assertPattern('/<td>OBJ<\\/td>/i');
        $this->assertPattern('/<a href="\\/facultypublications\\/islandora\\/object\\/facultyarticles%3A138\\/datastream\\/OBJ\\/download">maroja_bmc_evol_bio_2014.pdf<\\/a>/i');


        $this->assertPattern('/<td>FULL_TEXT<\\/td>/i');
        $this->assertPattern('/<a href="\\/facultypublications\\/islandora\\/object\\/facultyarticles%3A138\\/datastream\\/FULL_TEXT\\/download">maroja_bmc_evol_bio_2014.txt<\\/a>/i');

        $this->assertPattern('/<td>TN<\\/td>/i');
        $this->assertPattern('/<a href="\\/facultypublications\\/islandora\\/object\\/facultyarticles%3A138\\/datastream\\/TN\\/download">TN<\\/a>/i');

    }

    //############################################################

    function TestSearch_Author() {
        $this->get('http://'.TARGET_HOST.'/facultypublications/islandora/search?f[0]=mods_name_Author_ms%3A%22Morgan%5C%20McGuire%5C%20%22');
        $this->standardResponseChecks();
    }

    function TestSearch_SortTitle() {
        $this->get('http://'.TARGET_HOST.'/facultypublications/islandora/search/%20?sort=sort.title%20asc');
        $this->standardResponseChecks();
    }

    function TestSearch_Facets() {
        $this->get('http://'.TARGET_HOST.'/facultypublications/islandora/search/');
        $this->standardFacetsChecks();
    }
}