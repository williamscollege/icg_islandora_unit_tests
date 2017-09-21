<?php
	require_once dirname(__FILE__) . '/Site_Common_Battery_Test.php';

	class SiteRonadhCoxTest extends MultiSiteIslandoraWebTestCase {

		function SiteRonadhCoxTest() {
			# Set site name
			$this->setMultiSite('ronadhcox');
			echo "<p></p><hr><h3>TESTING: " . $this->getTestingUrlBase() . "</h3>";
		}

		#############################################################
		# Test Basics and Specific Pages
		#############################################################

		function TestSiteBasics() {
			$this->doStandardBasicSiteTests();
		}

		function TestProjectLeadPage() {
			$this->get(FULL_APP_URL . '/ronadhcox/project-lead');
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
			$this->doContentModelTest_BasicImage('ronadhcox', 'lavaka', '920');
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
			$this->doContentModelTest_LargeImage('ronadhcox', 'sedimentology', '319');
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
				['lavaka%3Aimages', 'lavaka%3A64']
				, ['sedimentology%3Aimages', 'sedimentology%3A319']
				// , ['','']
			];

			$this->doTestSite_Collections_and_Objects($array_collection_and_object_ids);
		}

		#############################################################
		# Test Search and Facets
		#############################################################

		function TestSearch_SubjectGeographic() {
			$this->get(FULL_APP_URL . '/ronadhcox/islandora/search?f[0]=mods_subject_geographic_ms%3A%22Madagascar%22');
			$this->standardResponseChecks();
		}

		function TestSearch_Sort_Title() {
			$this->get(FULL_APP_URL . '/ronadhcox/islandora/search/%20?sort=sort.title%20asc');
			$this->standardResponseChecks();
		}

		function TestSearch_Facets() {
			$this->get(FULL_APP_URL . '/ronadhcox/islandora/search');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Collection<\\/h3>/i');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Photographer<\\/h3>/i');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Subject<\\/h3>/i');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Geographic<\\/h3>/i');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Time Period<\\/h3>/i');
		}

		#############################################################
		# Utility Tool: Flush content to keep browser alive
		#############################################################
		function Test_Utility_KeepBrowserAlive() {
			$this->util_KeepBrowserAlive_Flush(); // prevent browser timeout issues
		}

	}