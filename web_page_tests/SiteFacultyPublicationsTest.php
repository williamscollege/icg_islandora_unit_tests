<?php
	require_once dirname(__FILE__) . '/Site_Common_Battery_Test.php';

	class SiteFacultyPublicationsTest extends MultiSiteIslandoraWebTestCase {

		function SiteFacultyPublicationsTest() {
			# Set site name
			$this->setMultiSite('facultypublications');
			echo "<p></p><hr><h3>TESTING: " . $this->getTestingUrlBase() . "</h3>";
		}

		#############################################################
		# Test Basics and Specific Pages
		#############################################################

		function TestSiteBasics() {
			$this->doStandardBasicSiteTests();
		}

		function TestArticlesPage() {
			$this->get(FULL_APP_URL . '/facultypublications/articles');
			$this->standardResponseChecks();
		}

		#############################################################
		# Test Solution Packs
		#############################################################

		function Test_SolutionPacks_Begin() {
			echo "<p><strong>Testing Solution Packs</strong></p>";
			echo "<ul>";
		}

		function TestContentModelDisplay_Audio() {
			$this->doContentModelTest_Audio('', '', '');
		}

		function TestContentModelDisplay_BasicImage() {
			$this->doContentModelTest_BasicImage('', '', '');
		}

		function TestContentModelDisplay_Binary() {
			$this->doContentModelTest_Binary('', '', '');
		}

		function TestContentModelDisplay_Book() {
			$this->doContentModelTest_Book('', '', '');
		}

		function TestContentModelDisplay_Compound() {
			$this->doContentModelTest_Compound('', '', '');
		}

		function TestContentModelDisplay_LargeImage() {
			$this->doContentModelTest_LargeImage('', '', '');
		}

		function TestContentModelDisplay_PDF() {
			$this->doContentModelTest_PDF('facultypublications', 'facultyarticles', '138');
		}

		function TestContentModelDisplay_Video() {
			$this->doContentModelTest_Video('', '', '');
		}

		function Test_SolutionPacks_End() {
			echo "</ul>";
		}

		#############################################################
		# Test Collections and Objects (this site only)
		#############################################################

		function TestAccessibility_Collection_And_Object() {
			# array elements: ['collection_id', 'object_id']
			$array_collection_and_object_ids = [
				['facultyarticles%3Atext', 'facultyarticles%3A138']
				// , ['','']
			];

			$this->doTestSite_Collections_and_Objects($array_collection_and_object_ids);
		}

		#############################################################
		# Test Collection Objects
		#############################################################

		private $specificTestObjectUrl = '';

		function TestObjectDisplayCollectionInfo() {
			$this->specificTestObjectUrl = FULL_APP_URL . '/facultypublications/islandora/object/facultyarticles%3A138';
			$this->get($this->specificTestObjectUrl);

			$this->assertPattern('/<div class="collection-info">/i');
			$this->assertPattern('/>IN COLLECTIONS</i');
			$this->assertPattern('/<a href="\\/facultypublications\\/islandora\\/object\\/facultyarticles%3Atext">Faculty Articles<\\/a>/i');
		}

		function TestObjectDisplayMetadataLabels() {
			$this->get($this->specificTestObjectUrl);

			$this->assertPattern('/<tr class="creator author">\s*<td class="mods_label">Author<\\/td>\s*<td class="mods_value">Maroja, Luana<\\/td>\s*<\\/tr>/i');
			$this->assertPattern('/<tr class="creator author">\s*<td class="mods_label">Author<\\/td>\s*<td class="mods_value">Richardson, David P.<\\/td>\s*<\\/tr>/i');
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

			$this->assertPattern('/<td class="id">OBJ<\\/td>/i');
			$this->assertPattern('/<a href="\\/facultypublications\\/islandora\\/object\\/facultyarticles%3A138\\/datastream\\/OBJ\\/download">maroja_bmc_evol_bio_2014.pdf<\\/a>/i');

			$this->assertPattern('/<td class="id">FULL_TEXT<\\/td>/i');
			$this->assertPattern('/<a href="\\/facultypublications\\/islandora\\/object\\/facultyarticles%3A138\\/datastream\\/FULL_TEXT\\/download">maroja_bmc_evol_bio_2014.txt<\\/a>/i');

			$this->assertPattern('/<td class="id">TN<\\/td>/i');
			$this->assertPattern('/<a href="\\/facultypublications\\/islandora\\/object\\/facultyarticles%3A138\\/datastream\\/TN\\/download">TN<\\/a>/i');
		}

		#############################################################
		# Test Search and Facets
		#############################################################

		function TestSearch_Author() {
			$this->get(FULL_APP_URL . '/facultypublications/islandora/search?f[0]=mods_name_personal_namePart_ms%3A%22McGuire%2C%5C%20Morgan%22');
			$this->standardResponseChecks();
		}

		function TestSearch_SortTitle() {
			$this->get(FULL_APP_URL . '/facultypublications/islandora/search/%20?sort=sort.title%20asc');
			$this->standardResponseChecks();
		}

		function TestSearch_Facets() {
			$this->get(FULL_APP_URL . '/facultypublications/islandora/search');

			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Author<\\/h3>/i');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Department<\\/h3>/i');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Resource type<\\/h3>/i');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Language<\\/h3>/i');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Subject<\\/h3>/i');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Geographic<\\/h3>/i');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Digital media type<\\/h3>/i');
		}

		#############################################################
		# Utility Tool: Flush content to keep browser alive
		#############################################################
		function Test_Utility_KeepBrowserAlive() {
			$this->util_KeepBrowserAlive_Flush(); // prevent browser timeout issues
		}

	}