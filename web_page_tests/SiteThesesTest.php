<?php
	require_once('Site_Common_Battery_Test.php');

	class SiteThesesTest extends MultiSiteIslandoraWebTestCase {

		function SiteThesesTest() {
			# Set site name
			$this->setMultiSite('theses');
			echo "<p></p><hr><h3>TESTING: " . $this->getTestingUrlBase() . "</h3>";
		}

		#############################################################
		# Test Basics and Specific Pages
		#############################################################

		function TestSiteBasics() {
			$this->doStandardBasicSiteTests();
		}

		function TestArticlesPage() {
			$this->get(FULL_APP_URL . '/theses/node/20');
			$this->fail("IMPROVEMENT IDEA: Change 'node/20' to a more pleasant relative link");
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
			$this->doContentModelTest_PDF('theses', 'studenttheses', '10');
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
				['islandora%3Aicgdemo', '']
				, ['studenttheses%3Aobject', 'studenttheses%3A242']
				// , ['','']
			];

			$this->doTestSite_Collections_and_Objects($array_collection_and_object_ids);
		}

		#############################################################
		# Test Collection Objects
		#############################################################

		private $specificTestObjectUrl = '';

		function TestObjectDisplayCollectionInfo() {
			$this->specificTestObjectUrl = FULL_APP_URL . '/theses/islandora/object/studenttheses%3A10';
			$this->get($this->specificTestObjectUrl);

			$this->assertPattern('/<div class="collection-info">/i');
			$this->assertPattern('/>IN COLLECTIONS</i');
			$this->assertPattern('/<a href="\\/theses\\/islandora\\/object\\/studenttheses%3Aobject">Theses<\\/a>/i');
		}

		function TestObjectDisplayMetadataLabels() {
			$this->get($this->specificTestObjectUrl);

			$this->assertPattern('/<tr class="identifier">\s*<td class="mods_label">FILENAME<\\/td>\s*<td class="mods_value">2016_January_Alvarez_Kyung_Thesis_Final_POEC.pdf<\\/td>\s*<\\/tr>/i');
			$this->assertPattern('/<tr class="rights">\s*<td class="mods_label">rights<\\/td>\s*<td class="mods_value">Contact Archives and Special Collections at archives@williams.edu<\\/td>\s*<\\/tr>/i');
			$this->assertPattern('/<tr class="creator author">\s*<td class="mods_label">author<\\/td>\s*<td class="mods_value">Alvarez, Kyung Nahiomy<\\/td>\s*<\\/tr>/i');
			$this->assertPattern('/<tr class="creator advisor">\s*<td class="mods_label">ADVISOR<\\/td>\s*<td class="mods_value">Mahon, James E., 1955-<\\/td>\s*<\\/tr>/i');
			$this->assertPattern('/<tr class="creator advisor">\s*<td class="mods_label">ADVISOR<\\/td>\s*<td class="mods_value">LaLumia, Sara<\\/td>\s*<\\/tr>/i');
			$this->assertPattern('/<tr class="department">\s*<td class="mods_label">department<\\/td>\s*<td class="mods_value">Political Economy<\\/td>\s*<\\/tr>/i');
			$this->assertPattern('/<tr class="genre">\s*<td class="mods_label">GENRE<\\/td>\s*<td class="mods_value">Thesis<\\/td>\s*<\\/tr>/i');
			$this->assertPattern('/<tr class="date-issued">\s*<td class="mods_label">date issued<\\/td>\s*<td class="mods_value">2016<\\/td>\s*<\\/tr>/i');
			$this->assertPattern('/<tr class="note provenance">\s*<td class="mods_label">provenance<\\/td>\s*<td class="mods_value">Submitted by author<\\/td>\s*<\\/tr>/i');
			$this->assertPattern('/<tr class="subject">\s*<td class="mods_label">subject<\\/td>\s*<td class="mods_value">Credit cards -- Marketing<\\/td>\s*<\\/tr>/i');
			$this->assertPattern('/<tr class="geographic">\s*<td class="mods_label">GEOGRAPHIC<\\/td>\s*<td class="mods_value">United States<\\/td>\s*<\\/tr>/i');
			$this->assertPattern('/<tr class="identifier">\s*<td class="mods_label">CALLNUMBER<\\/td>\s*<td class="mods_value">541.A48 2016<\\/td>\s*<\\/tr>/i');
		}

		function TestObjectDisplayDatastreamsSection() {
			$this->get($this->specificTestObjectUrl);

			$this->assertPattern('/<table class="object-datastreams">/i');

			$this->assertPattern('/<td>OBJ<\\/td>/i');
			$this->assertPattern('/<a href="\\/theses\\/islandora\\/object\\/studenttheses%3A10\\/datastream\\/OBJ\\/download">2016_January_Alvarez_Kyung_Thesis_Final_POEC.pdf<\\/a>/i');

			$this->assertPattern('/<td>FULL_TEXT<\\/td>/i');
			$this->assertPattern('/<a href="\\/theses\\/islandora\\/object\\/studenttheses%3A10\\/datastream\\/FULL_TEXT\\/download">2016_January_Alvarez_Kyung_Thesis_POEC_text.txt<\\/a>/i');

			$this->assertPattern('/<td>TN<\\/td>/i');
			$this->assertPattern('/<a href="\\/theses\\/islandora\\/object\\/studenttheses%3A10\\/datastream\\/TN\\/download">TN<\\/a>/i');
		}

		#############################################################
		# Test Search and Facets
		#############################################################

		function TestSearch_Author() {
			$this->get(FULL_APP_URL . '/theses/islandora/search?f[0]=mods_name_personal_namePart_ms%3A%22LaLumia%2C%5C%20Sara%22');
			$this->standardResponseChecks();
		}

		function TestSearch_SortTitle() {
			$this->get(FULL_APP_URL . '/theses/islandora/search/%20?sort=sort.title%20asc');
			$this->standardResponseChecks();
		}

		function TestSearch_Facets() {
			$this->get(FULL_APP_URL . '/theses/islandora/search');

			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Department<\\/h3>/i');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Year<\\/h3>/i');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Advisor<\\/h3>/i');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Material type<\\/h3>/i');
		}

		#############################################################
		# Utility Tool: Flush content to keep browser alive
		#############################################################
		function Test_Utility_KeepBrowserAlive() {
			$this->util_KeepBrowserAlive_Flush(); // prevent browser timeout issues
		}

	}