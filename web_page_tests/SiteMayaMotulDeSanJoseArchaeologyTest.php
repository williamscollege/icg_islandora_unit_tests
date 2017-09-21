<?php
	require_once dirname(__FILE__) . '/Site_Common_Battery_Test.php';

	class SiteMayaMotulDeSanJoseArchaeologyTest extends MultiSiteIslandoraWebTestCase {

		function SiteMayaMotulDeSanJoseArchaeologyTest() {
			# Set site name
			$this->setMultiSite('mayamotuldesanjosearchaeology');
			echo "<p></p><hr><h3>TESTING: " . $this->getTestingUrlBase() . "</h3>";
		}

		#############################################################
		# Test Basics and Specific Pages
		#############################################################

		function TestSiteBasics() {
			$this->doStandardBasicSiteTests();
		}

		function TestProjectLeadPage() {
			$this->get(FULL_APP_URL . '/mayamotuldesanjosearchaeology/project-leads');
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
			$this->doContentModelTest_LargeImage('mayamotuldesanjosearchaeology', 'motul', '372');
		}

		function TestContentModelDisplay_PDF() {
			$this->doContentModelTest_PDF('mayamotuldesanjosearchaeology', 'motul', '519');
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
				['motul%253Amayaartifacts', 'motul%3A239']
				, ['motul%3Asitereports', 'motul%3A434']
				// , ['','']
			];

			$this->doTestSite_Collections_and_Objects($array_collection_and_object_ids);
		}

		#############################################################
		# Test Search and Facets
		#############################################################

		function TestSearch_Operation() {
			$this->get(FULL_APP_URL . '/mayamotuldesanjosearchaeology/islandora/search?f[0]=mods_note_operation_ms%3A%2210%22');
			$this->standardResponseChecks();
		}

		function TestSearch_Sort_Title() {
			$this->get(FULL_APP_URL . '/mayamotuldesanjosearchaeology/islandora/search/%20?sort=sort.title%20asc');
			$this->standardResponseChecks();
		}

		function TestSearch_Facets() {
			$this->get(FULL_APP_URL . '/mayamotuldesanjosearchaeology/islandora/search');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Collection<\\/h3>/i');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Resource type<\\/h3>/i');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Language<\\/h3>/i');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Subject<\\/h3>/i');
		}

		#############################################################
		# Utility Tool: Flush content to keep browser alive
		#############################################################
		function Test_Utility_KeepBrowserAlive() {
			$this->util_KeepBrowserAlive_Flush(); // prevent browser timeout issues
		}

	}