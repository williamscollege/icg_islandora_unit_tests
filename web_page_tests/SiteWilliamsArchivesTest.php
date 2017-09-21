<?php
	require_once dirname(__FILE__) . '/Site_Common_Battery_Test.php';

	class SiteWilliamsArchivesTest extends MultiSiteIslandoraWebTestCase {

		function SiteWilliamsArchivesTest() {
			# Set site name
			$this->setMultiSite('williamsarchives');
			echo "<p></p><hr><h3>TESTING: " . $this->getTestingUrlBase() . "</h3>";
		}

		#############################################################
		# Test Basics and Specific Pages
		#############################################################

		function TestSiteBasics() {
			$this->doStandardBasicSiteTests();
		}

		function TestArticlesPage() {
			$this->get(FULL_APP_URL . '/williamsarchives/articles');
			$this->standardResponseChecks();
		}

		function TestCollectionsPage() {
			$this->get(FULL_APP_URL . '/williamsarchives/collections');
			$this->standardResponseChecks();
		}

		#############################################################
		# Test Solution Packs
		#############################################################

		function Test_SolutionPacks_Begin(){
			echo "<p><strong>Testing Solution Packs</strong></p>";
			echo "<ul>";
		}

		function TestContentModelDisplay_Audio() {
			$this->doContentModelTest_Audio('williamsarchives', 'andyjaffe', '55');
		}

		function TestContentModelDisplay_BasicImage() {
			$this->doContentModelTest_BasicImage('williamsarchives', 'daviscenter', '60');
		}

		function TestContentModelDisplay_Binary() {
			$this->doContentModelTest_Binary('', '', '');
		}

		function TestContentModelDisplay_Book() {
			$this->doContentModelTest_Book('williamsarchives', 'gulielmensian', '2228');
		}

		function TestContentModelDisplay_Compound() {
			$this->doContentModelTest_Compound('', '', '');
		}

		function TestContentModelDisplay_LargeImage() {
			$this->doContentModelTest_LargeImage('', '', '');
		}

		function TestContentModelDisplay_PDF() {
			$this->doContentModelTest_PDF('williamsarchives', 'dwight', '88');
		}

		function TestContentModelDisplay_Video() {
			$this->doContentModelTest_Video('williamsarchives', 'andyjaffe', '42');
		}

		function Test_SolutionPacks_End(){
			echo "</ul>";
		}

		#############################################################
		# Test Collections and Objects (this site only)
		#############################################################

		function TestAccessibility_Collection_And_Object() {
			# array elements: ['collection_id', 'object_id']
			$array_collection_and_object_ids = [
				['furtwangler%3Abooks','']
//				, ['','']
//				, ['','']
//				, ['','']
//				, ['','']
//				, ['','']
//				, ['','']
//				, ['','']
//				, ['','']
//				, ['','']
			];

			$this->doTestSite_Collections_and_Objects($array_collection_and_object_ids);
		}

		#############################################################
		# Test Collection Objects
		#############################################################

		function Test_Collection_daviscenter_posters() {
			$this->get(FULL_APP_URL . '/williamsarchives/islandora/object/daviscenter%3Aposters');
			$this->standardResponseChecks();
		}

		function Test_Object_daviscenter_posters() {
			$this->get(FULL_APP_URL . '/williamsarchives/?q=islandora/object/daviscenter%3A32');
			$this->standardResponseChecks();
		}


		function Test_Collection_dively() {
			$this->get(FULL_APP_URL . '/williamsarchives/islandora/object/dively%3Aposters');
			$this->standardResponseChecks();
		}

		function Test_Object_dively() {
			$this->get(FULL_APP_URL . '/williamsarchives/?q=islandora/object/dively%3A26');
			$this->standardResponseChecks();
		}


		function Test_Collection_reily() {
			$this->get(FULL_APP_URL . '/williamsarchives/islandora/object/reily%3Ascrapbook');
			$this->standardResponseChecks();
		}

		function Test_Object_reily() {
			$this->get(FULL_APP_URL . '/williamsarchives/?q=islandora/object/reily%3A50');
			$this->standardResponseChecks();
		}

		function Test_Collection_andyjaffe() {
			$this->get(FULL_APP_URL . '/williamsarchives/islandora/object/andyjaffe%3Aproject');
			$this->standardResponseChecks();
		}

		function Test_Object_andyjaffe() {
			$this->get(FULL_APP_URL . '/williamsarchives/?q=islandora/object/andyjaffe%3A49');
			$this->standardResponseChecks();
		}


		function Test_Collection_alexanderdavidson() {
			$this->get(FULL_APP_URL . '/williamsarchives/islandora/object/alexanderdavidson%3Aphotography');
			$this->standardResponseChecks();
		}

		function Test_Object_alexanderdavidson() {
			$this->get(FULL_APP_URL . '/williamsarchives/?q=islandora/object/alexanderdavidson%3A152');
			$this->standardResponseChecks();
		}


		function Test_Collection_shakers_songbooks() {
			$this->get(FULL_APP_URL . '/williamsarchives/islandora/object/shakers%3Asongbooks');
			$this->standardResponseChecks();
		}

		function Test_Object_shakers_songbooks() {
			$this->get(FULL_APP_URL . '/williamsarchives/?q=islandora/object/shakers%3A35');
			$this->standardResponseChecks();
		}


		function Test_Collection_shakers_highlights() {
			$this->get(FULL_APP_URL . '/williamsarchives/islandora/object/shakers%3Ahighlights');
			$this->standardResponseChecks();
		}

		function Test_Object_shakers_highlights() {
			$this->get(FULL_APP_URL . '/williamsarchives/?q=islandora/object/shakers%3A63');
			$this->standardResponseChecks();
		}


		function Test_Collection_holley() {
			$this->get(FULL_APP_URL . '/williamsarchives/islandora/object/holley%3Apapers');
			$this->standardResponseChecks();
		}

		function Test_Object_holley() {
			$this->get(FULL_APP_URL . '/williamsarchives/?q=islandora/object/holley%3A20');
			$this->standardResponseChecks();
		}


		function Test_Collection_williams_higher_education() {
			$this->get(FULL_APP_URL . '/williamsarchives/islandora/object/williams-higher-education%3Amixed-materials');
			$this->standardResponseChecks();
		}

		function Test_Object_williams_higher_education() {
			$this->get(FULL_APP_URL . '/williamsarchives/?q=islandora/object/williams-higher-education%3A27');
			$this->standardResponseChecks();
		}


		function Test_Collection_daviscenter_videos() {
			$this->get(FULL_APP_URL . '/williamsarchives/islandora/object/daviscenter%3Avideos');
			$this->standardResponseChecks();
		}

		function Test_Object_daviscenter_videos() {
			$this->get(FULL_APP_URL . '/williamsarchives/?q=islandora/object/daviscenter%3A67');
			$this->standardResponseChecks();
		}


		function Test_Collection_dwight() {
			$this->get(FULL_APP_URL . '/williamsarchives/islandora/object/dwight%3Apapers');
			$this->standardResponseChecks();
		}

		function Test_Object_dwight() {
			$this->get(FULL_APP_URL . '/williamsarchives/?q=islandora/object/dwight%3A23');
			$this->standardResponseChecks();
		}


		#############################################################
		# Test Search and Facets
		#############################################################

		function TestSearch_DateCreated() {
			$this->get(FULL_APP_URL . '/williamsarchives/islandora/search?islandora_solr_search_navigation=0&f[0]=mods_originInfo_dateIssued_ms%3A"1898"');
			$this->standardResponseChecks();
		}

		function TestSearch_Sort_CollectionMembership() {
			$this->get(FULL_APP_URL . '/williamsarchives/islandora/search/%20?islandora_solr_search_navigation=0&sort=collection_membership.title_s%20asc');
			$this->standardResponseChecks();
		}

		function TestSearch_Facets() {
			$this->get(FULL_APP_URL . '/williamsarchives/islandora/search');

			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Collection<\\/h3>/i');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Name<\\/h3>/i');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Group or Department<\\/h3>/i');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Material type<\\/h3>/i');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Date<\\/h3>/i');
		}

		#############################################################
		# Utility Tool: Flush content to keep browser alive
		#############################################################
		function Test_Utility_KeepBrowserAlive() {
			$this->util_KeepBrowserAlive_Flush(); // prevent browser timeout issues
		}

	}