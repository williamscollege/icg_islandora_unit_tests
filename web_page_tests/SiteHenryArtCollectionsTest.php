<?php
	require_once dirname(__FILE__) . '/Site_Common_Battery_Test.php';

	class SiteHenryArtCollectionsTest extends MultiSiteIslandoraWebTestCase {

		function SiteHenryArtCollectionsTest() {
			# Set site name
			$this->setMultiSite('henryartcollections');
			echo "<p></p><hr><h3>TESTING: " . $this->getTestingUrlBase() . "</h3>";
		}

		#############################################################
		# Test Basics and Specific Pages
		#############################################################

		function TestSiteBasics() {
			$this->doStandardBasicSiteTests();
		}

		function TestProjectLeadPage() {
			$this->get(FULL_APP_URL . '/henryartcollections/project-lead');
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
			$this->doContentModelTest_LargeImage('henryartcollections', 'hopkinsforestmaps', '109');
		}

		function TestContentModelDisplay_PDF() {
			$this->doContentModelTest_PDF('', '', '');
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
				['hopkinsforestmaps%3Aimages', 'hopkinsforestmaps%3A241']
				, ['rosenburgarchives%3Aimages', 'rosenburgarchives%3A121']
				// , ['','']
			];

			$this->doTestSite_Collections_and_Objects($array_collection_and_object_ids);
		}


		#############################################################
		# Test Search and Facets
		#############################################################

		function TestSearch_SubjectGeographic() {
			$this->get(FULL_APP_URL . '/henryartcollections/islandora/search?f[0]=mods_subject_geographic_ms%3A"Hopkins%5C%20Memorial%5C%20Forest"');
			$this->standardResponseChecks();
		}

		function TestSearch_Sort_Title() {
			$this->get(FULL_APP_URL . '/henryartcollections/islandora/search/%20?sort=sort.title%20asc');
			$this->standardResponseChecks();
		}

		function TestSearch_Facets() {
			$this->get(FULL_APP_URL . '/henryartcollections/islandora/search');

			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Creator \(Personal\)<\\/h3>/i');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Creator \(Corporate\)<\\/h3>/i');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Date<\\/h3>/i');
		}

		#############################################################
		# Utility Tool: Flush content to keep browser alive
		#############################################################
		function Test_Utility_KeepBrowserAlive() {
			$this->util_KeepBrowserAlive_Flush(); // prevent browser timeout issues
		}

	}